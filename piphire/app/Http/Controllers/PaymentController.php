<?php

namespace App\Http\Controllers;

use Mail;
use App\Plan;
use App\Order;
use App\Invoice;
use App\EventLog;
use Carbon\Carbon;
use Razorpay\Api\Api;
use Ramsey\Uuid\Uuid;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use DB;
class PaymentController extends Controller
{
    /**
     * Return the Payment Page for the Plan
     */
    public function show(Request $request)
    {
        $api = new Api(config('payment.key'), config('payment.secret'));
        $plan = Plan::where('puid', $request->plan)->first();
        if (is_null($plan)) {
            abort('404');
        }
        $amount = $plan->amount * 100;
        $order = $api->order->create([
            'receipt' => uniqid('PR'),
            'amount' => $amount,
            'payment_capture' => 1,
            'currency' => config('payment.currency')
        ]);
        $header_class = 'plans';
        $auto_job = DB::connection('pephire_auto')
        ->table('autonomous_job_file_master')
        ->where('uid', auth()->user()->id)
        ->first();
    $schedule = DB::connection('pephire_auto')
        ->table('autonomous_job_schedule')
        ->where('uid', auth()->user()->id)
        ->first();
        return view('payments.show', compact('plan', 'header_class', 'order', 'amount','auto_job','schedule'));
    }

    /**
     * Finish with the housekeeping, once the payment is completed.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        $api = new Api(config('payment.key'), config('payment.secret'));

        // Change the Plans for the Organization
        $user = auth()->user();
        $organization = $user->organization;

        $plan = Plan::where('puid', $request->plan)->first();



        $plan_end_date = Carbon::now()->addYear($plan->year_count )->addMonths($plan->month_count)->format('Y-m-d');

        if (! is_null($organization)) {
            $organization->plan_id = $plan->id;
            $organization->max_users = $plan->max_users;
            $organization->max_resume_count = $plan->max_resume_count;
            $organization->total_search = $organization->total_search + $plan->no_of_searches;
            $organization->left_search = $organization->left_search + $plan->no_of_searches;
            $organization->plan_end_date = $plan_end_date;
            $organization->save();
        }

        $order = new Order();
        $order->user_id = $user->id;
        $order->plan_id = $plan->id;
        $order->amount = $request->amount;
        $order->razorpay_order_id = $request->razorpay_order_id;
        $order->razorpay_payment_id = $request->razorpay_payment_id;
        $order->razorpay_signature = $request->razorpay_signature;
        $order->status = 1;
        $order->save();

        // Generate the Invoice Against the Payment
        $client = new Client();
        $res = $client->request('GET', 'https://api.razorpay.com/v1/payments/' . $request->razorpay_payment_id, [
            'auth' => [ config('payment.key'), config('payment.secret') ]
        ]);
        $response = json_decode($res->getBody()->getContents(), true);

        setlocale(LC_MONETARY, 'en_IN');
        $invoice = Invoice::create([
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'status' => $response['status'],
            'payment_method' => $response['method'],
            'description' => $response['description'],
            'email' => $response['email'],
            'contact' => $response['contact'],
            'fee' => $response['fee'],
            'tax' => $response['tax'],
            'amount' => number_format($response['amount'] / 100, 2),
            'order_id' => $order->id,
            'user_id' => auth()->user()->id,
            'plan_id' => $plan->id,
            'plantype_id' => $plan->plantype_id,
            'razorpay_order_id' => $request->razorpay_order_id,
            'created_at' => Carbon::parse($response['created_at'])->toDateTimeString()
        ]);

        if ($response['method'] == 'card') {
            $res = $client->request('GET',
                'https://api.razorpay.com/v1/payments/' . $request->razorpay_payment_id . '/card',
                [
                    'auth' => [ config('payment.key'), config('payment.secret') ]
                ]
            );
            $card_details = json_decode($res->getBody()->getContents(), true);
            $invoice->payment_description = $card_details['issuer'] . ' ending '. $card_details['last4'] . ' Name on card - ' . $card_details['name'];
            $invoice->save();
        }

        session()->flash('status', 'Payment Successful');


        if($organization->name != ''){

            $event_text = $organization->name.' upgraded to the plan '.$plan->name.' at '.Carbon::now()->format('d/M/Y g:i A');
        }else{

            $event_text = $user->name.' upgraded to the plan '.$plan->name.' at '.Carbon::now()->format('d/M/Y g:i A');
        }

        $event                      = new EventLog();
        $event->euid                = Uuid::uuid1()->toString();
        $event->organization_id     = $organization->id;
        $event->user_id             = $user->id;
        $event->event_details       = $event_text;
        $event->save();

        $data               = array();
        $data['name']       = $user->name;
        $data['planname']   = $plan->name;
        $data['email']      = $user->email;
        $this->sendmail($data, 'Pephire : Plan Upgraded', 'frontend.mail.paymentsuccess');

        return redirect('/plans');
    }

    private function sendmail($data,$subject,$view)
    {
        Mail::send($view, $data, function($message) use($data, $subject) {
            $message->to($data['email'], $data['name'])->subject($subject);
        });
    }


}
