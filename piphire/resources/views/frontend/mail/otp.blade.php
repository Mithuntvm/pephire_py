<!doctype html>
<html>

<head>
    <title>{{ config('app.name', 'PepHire') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon-96x96.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Quicksand:400,500,600&display=swap" rel="stylesheet">
    <style>
      p {
          font-family: 'Open Sans', sans-serif;
          font-size: 14px;
      }
    </style>
</head>

<body style="
      margin: 0;
      padding: 0;
      ">
    <div style="
         position: relative;
         width: 810px;
         margin: 10px auto;
         border: 1px solid rgba(0,0,0,0.1);
         ">
        <div style="
            position: relative;
            display: inline-block;
            width: 100%;
            ">
            <div style="
               background: #2E5BFF;
               height: 34px;
               "></div>
        </div>
        <div style="
            padding: 50px 30px;
            ">
            <p style="
               margin: 0 0 20px 0;
               font-size: 18px;
               display: inline-block;
               ">{{$name}},</p>
              <p>Your PepHire account verification OTP is {{$otp}}</p><br/>
              <p style="
               ">You may reach out to <a href="mailto:info@pephire.com">info@pephire.com</a> for assistance, and we will be more than glad to guide you through.</p>
            <p style="
               margin: 20px 0 0 0;
               font-size: 18px;
               position: relative;
               display: inline-block;
               ">Best Regards</p>
            <div style="
               position: relative;
               width: 100%;
               display: inline-block;
               min-height: 80px;
               border-bottom: 1px solid #ddd;
               ">
                <a href="{{url('/')}}" style="
                  display: inline-block;
                  padding-top: 18px;
                  padding-left: 15px;
                  "><img src="{{url('/')}}/assets/images/logo/logo.png"></a>
            </div>
        </div>
        <div style="
            background: #fff;
            color: #333;
            padding: 0 15px;
            ">
            <p style="
               display: inline-block;
               ">Copyright &copy; {{date('Y')}} Sentient Scripts, All rights reserved.</p>
            <p style="
               display: inline-block;
               float: right;
               ">
                <span>
               <a href="{{url('/')}}" style="
                  text-decoration: none;
                  color: #333;
                  padding: 0 5px;
                  ">Privacy Policy</a>
               <a href="{{url('/')}}" style="
                  text-decoration: none;
                  color: #333;
                  padding: 0 0 0 5px;
                  ">Terms and Conditions</a>
               </span>
            </p>
        </div>
    </div>

</body>

</html>