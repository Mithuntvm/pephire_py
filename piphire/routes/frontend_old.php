<?php

	use App\User;
	use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;


    Route::post('/loginajax', 'HomeController@loginajax');

    Route::post('/homecontactus', 'HomeController@homecontactus');

    Route::post('/checkemailexist', 'HomeController@checkemailexist');

    Route::post('/checkemailexistorg', 'HomeController@checkemailexistorg');

    Route::post('/postjob', 'JobController@Apijobsubmit');

    Route::post('/postresumes', 'ResumeController@Apidocupload');
    Route::get('/phpinfo', function () {
        return phpinfo();
    });
    Route::post('/createnewcandidate', 'PendingCandidateController@store');

    Route::post('/verifyotp', 'PendingCandidateController@verifyotp');

    Route::post('/resentotp', 'PendingCandidateController@resentotp');
    Route::any('/clearsessions', 'OrganizationController@clearsessions');


    Route::post('/submitresume', 'ResumeController@submitresume');

	Route::get('/validate/user/{uid}', function (Request $request) {

		$user = User::where('verification_link',$request->uid)->first();

	    return view('frontend/user/activate',compact('user'));

	});

    Route::post('/validate/user/{uid}', 'OrganizationController@activateuseraccount');

	//Route::get('/organization/register', 'HomeController@organizationcreate');

	Route::post('/organization/register', 'OrganizationController@store');

    Route::get('/success/register', 'OrganizationController@successregister');
    Route::get('/enter/otp/{email}/{otp}', 'OrganizationController@enterotp');

    Route::post('/verify_otp', 'OrganizationController@verify_otp')->name('verifyotp');




    // Route::post('/testJob', 'BulkJobsController@upload');



    Route::group(['middleware' => 'App\Http\Middleware\UserMiddleware'], function () {

        Route::get('/chat', 'ChatController@index');

        
        Route::group(['middleware' => 'App\Http\Middleware\BulkJobMiddleware'], function (){
                    
            Route::get('/bulkJobs/{bjuid}', 'BulkJobsController@history');
            Route::post('/bulkJobs/{bjuid}', 'BulkJobsController@searchhistory');

            Route::post('/uploadBulkJob', 'BulkJobsController@upload');

            Route::get('/bulkJobs', 'BulkJobsController@index');

            Route::post('/bulkJobs', 'BulkJobsController@search');
        });


        // Route::post('/testJob', 'BulkJobsController@upload');



        Route::get('/dashboard', 'HomeController@index');

        Route::get('/contactus', 'HomeController@contactus');

        Route::post('/contactus', 'HomeController@sendcontactus');

        Route::get('/powerbi', 'PowerbiController@index');

        Route::get('/organization-deactive', 'HomeController@organizationdeactive');

        Route::get('/teaminsight', 'HomeController@teaminsight');

        Route::get('/businessinsight', 'HomeController@businessinsight');

        Route::get('/sourcing', 'HomeController@sourcing');

        Route::get('/plans', 'PlanController@index');

        Route::get('/plan-expired', 'PlanController@planexpired');

        Route::get('payment/{plan}', 'PaymentController@show');

        Route::post('payment/success', 'PaymentController@success');

        Route::get('/jobs', 'JobController@index');

        Route::post('/jobs', 'JobController@dataTable');

        Route::get('/jobs/create', 'JobController@create');
        Route::get('/jobs/reusehistory/{juuid}', 'JobController@reuseHistory');

        Route::post('/jobs/reusehistory/{juuid}', 'JobController@store');

        Route::post('/jobs/create', 'JobController@store');

        Route::post('/updatejobdetails', 'JobController@updatejobdetails');

        Route::get('/jobs/{juid}/view', 'JobController@show');

        Route::post('/jobs/{juid}/view', 'JobController@ResumedataTable');

        Route::get('/jobs/{juid}/edit', 'JobController@edit');

        Route::post('/jobs/{juid}/edit', 'JobController@update');

        Route::post('/jobs/delete/{id}', 'JobController@destroy');

        Route::post('/jobs/activate/{id}', 'JobController@activate');

        Route::get('/getjson/{id}', 'JobController@getjson');

        Route::get('/jobs/history', 'JobController@history');
        Route::post('/jobs/history', 'JobController@searchhistory');

        Route::get('/jobs/historyminer', 'JobController@historyminer');
        
        Route::get('/Autonomous/job', 'AutonomousJobController@index');
        Route::post('/Autonomous/job', 'AutonomousJobController@autonomusJob');
        Route::get('Show/Autonomous/job', 'AutonomousJobController@show_automate');
        Route::get('Edit/Autonomous/job', 'AutonomousJobController@edit_automate');
        Route::post('Update/Autonomous/job', 'AutonomousJobController@update_automate');

        Route::post('Update/Interview/job', 'AutonomousJobController@updateInterview');

        Route::get('/job/details/{juid}', 'JobController@details')->name('job.show');
        Route::post('/job/details/{juid}', 'JobController@searchdetails')->name('job.result');

        Route::post('/report', 'JobController@report')->name('download.csv');
        Route::get('/resetform/profile', 'CandidateController@resetform_profile');
        
        Route::get('/resetform/pickprofile', 'CandidateController@resetform_pickprofile');

        Route::post('/resumes', 'JobController@resumes')->name('download.resume');

        Route::post('/shortlisted/report', 'JobController@shortlisted_report')->name('download.shortlistedcsv');

        Route::post('/shortlisted/resumes', 'JobController@shortlisted_resumes')->name('download.shortlistedresume');

        
        
        // **************** Interview Routes ********************
        Route::post('/interview/shortlisted/store/{juid}', 'InterviewController@storeShortlistedCandidates')->name('shortlistedCandidates.store');
        Route::get('/interview/shortlisted/view/{juid}', 'InterviewController@showShortlistedCandidates')->name('shortlistedCandidates.show');
        Route::post('/interview/shortlisted/update/{juid}', 'InterviewController@updateShortlistedCandidates')->name('shortlistedCandidates.update');
        Route::get('/interview/timeslot/view/{juid}', 'InterviewController@viewInterviewTimeSlot')->name('interviewTimeSlot.view');
        Route::post('/interview/timeslot/store/{juid}', 'InterviewController@storeInterviewTimeSlot')->name('interviewTimeSlot.store');
        Route::get('/interview/scheduled/view/{juid}', 'InterviewController@showScheduledCandidates')->name('scheduledCandidates.show');
        Route::post('/interview/scheduled/view/{juid}', 'InterviewController@filterScheduledCandidates')->name('scheduledCandidates.filter');
        // notInterested
        Route::post('/not_interested/{juid}', 'JobController@notInterested')->name('notIntetersted.update');

        // **************** Interview Routes ********************

        Route::get('/jobs/candidates/list', 'CandidateController@listCandidates')->name('candidates.list');
        Route::post('/jobs/candidates/list', 'CandidateController@filterCandidates')->name('candidates.filter');

        //Route::post('/job/details/search', 'JobController@detailssearch');

        Route::get('/job/scoreupdate/{juid}', 'JobController@updatescore');

        // Route::post('/job/submitresmeforscore/{juid}', 'JobController@submitresmeforscore');


        Route::post('/docpcupload', 'ResumeController@docpcupload');

        Route::post('/driveupload', 'ResumeController@driveupload');

        Route::post('/dropboxupload', 'ResumeController@dropboxupload');

        Route::get('/attributiondocs/{retry?}', 'ResumeController@attributiondocs');

        Route::get('/pendingresumes/{retry?}', 'ResumeController@pendingresumes');

        Route::post('/profileattributionscore', 'ResumeController@profileattributionscore');

        Route::post('/resume/delete/{id}', 'ResumeController@destroy');

        Route::post('/resume/download/{id}', 'ResumeController@download');

        Route::get('/getresumelist', 'ResumeController@getresumelist');

        Route::post('/hold/delete/{id}', 'OrganizationsHoldResumeController@destroy');

        Route::get('/profileminer', 'CandidateController@profiledatabase');

        Route::any('/profileminersearch', 'CandidateController@profiledbsearch');

        Route::get('/profiledatabase', 'CandidateController@index');

        // Route::any('/profiledbsearch', 'CandidateController@search');

        Route::any('/candidatesearch', 'CandidateController@candidatesearch');

        Route::any('/candidatesearch_new', 'CandidateController@candidatesearch_new');

        // Route::any('/candidatesearchminer', 'CandidateController@candidatesearchminer');

        Route::post('/profile/delete/{id}', 'CandidateController@destroy');

        Route::post('/profile/addtojob/{id}', 'CandidateController@addtojob');

        Route::get('profile/{profile}', 'CandidateController@show');

        Route::post('/profile/removefromjob/{id}', 'CandidateController@removefromjob');

        Route::get('/profilepopup/popupget', 'CandidateController@popupget');

        Route::post('/profilepopup/popupgetbyjob', 'CandidateController@popupgetbyjob');

        Route::get('/profilepopup/popupgetsearch', 'CandidateController@popupgetsearch');

        Route::get('/resume/{resumeid}', 'ResumeController@getAttributesApi');

        Route::get('invoices', 'InvoiceController@index');

        Route::get('invoice/{invoice}', 'InvoiceController@show');

        Route::get('list-invoices', 'InvoiceController@list')->name('invoices.list');

        Route::get('/myprofile', 'HomeController@myprofileview');

        Route::Post('/myprofile', 'HomeController@updatemyprofile');

        Route::get('/viewfile/{cuid}', 'HomeController@viewfile');

        Route::get('/users', 'UserController@index');

        Route::post('/users', 'UserController@dataTable');

        Route::post('/user/delete/{id}', 'UserController@destroy');

        Route::post('/user/activate/{id}', 'UserController@activate');

        Route::get('/user/create', 'UserController@create');

        Route::post('/user/create', 'UserController@store');

        Route::get('/user/{uuid}/edit', 'UserController@edit');

        Route::post('/user/{uuid}/edit', 'UserController@update');

        Route::get('/organization/edit', 'OrganizationController@edit');

        Route::post('/organization/edit', 'OrganizationController@update');

        Route::get('/organization/edit/{puid}', 'OrganizationController@editwithplan');

        Route::post('/organization/edit/{puid}', 'OrganizationController@updatewithplan');

        Route::post('/getallmatchcandidates', 'CandidateController@getallmatchcandidates');

        Route::get('/getallresumes', 'CandidateController@getallresumes');


        //User activation//

        Route::post('/senduseractivation/{uuid}', 'UserController@senduseractivation');

        Route::post('/makeadminuser/{uuid}', 'UserController@makeadminuser');

        //User activation//
        //download doc
        Route::get('/downloaddoc/{ruid}', 'ResumeController@downloaddoc');

        //download doc
    });
        Route::get('/interview/sourcing', 'JobController@interviewSourcing');
        Route::post('/interviewer/update', 'JobController@updateInterviewer')->name('interviewer.update');

    Route::get('/skill/autocomplete', 'SkillController@index');
    Route::get('/company/autocomplete', 'CompanyController@index');
    Route::get('/name/autocomplete', 'NameController@index');
    Route::post('/scheduled/csv', 'InterviewConfirmationController@scheduledCSV')->name('csv.download');
    Route::get('profile/{profile}', 'CandidateController@show') ->name('candidatedetails.show');
    // Edit Profile
    Route::post('/whatsappFlow', 'CandidateController@whatsappFlow')->name('whatsapp.update');
    Route::get('/export_excel', 'ExcelController@export')->name('export.excel');

    Route::post('/update_candidatedetails/{cuid}', 'CandidateController@update_candidatedetails')->name('candidatedetails.update');
    Route::get('editprofile/{id}', 'CandidateController@edit_candidatedetails');
    Route::get('/candidate/updateDetails/{cuid}', 'CandidateController@editCandidateDetails')->name('candidateDetails.edit');
    Route::any('/start/{id}', 'CandidateController@start');
    Route::post('/comment/{cid}', 'CandidateController@comment');
    Route::post('/candidate/updatecandidate/{cuid}', 'CandidateController@updateshowCandidate')->name('showcandidateProfile.update');
    Route::post('/mandatorySkills', 'JobController@mandatorySkills');
    Route::get('/candidate/updateProfile/{cuid}', 'CandidateController@editCandidateProfile')->name('candidateProfile.edit');
    Route::get('/interview/candidateProfile/{sluid}', 'CandidateController@editInterviewCandidateProfile')->name('interviewCandidateProfile.edit');
    Route::post('/candidate/updateProfile/{cuid}', 'CandidateController@updateCandidateProfile')->name('candidateProfile.update');
    Route::get('/candidate/thankYou', function(){
        $thankyouMsg = 'Thank you, Your profile data has been updated in the system.';
        return view('frontend.interview_thankyou', compact('thankyouMsg'));
    })->name('candidate.thankYou');

    // **************** Interview Public Routes ********************
    Route::get('/interview/weblinksView', 'InterviewConfirmationController@index');
    Route::get('/interview/candidate/timeslots/{cid}', 'InterviewConfirmationController@candidate_timeslots')->name('candidateTimeslot.update');
    Route::post('/storeData/{cid}', 'InterviewConfirmationController@storeCandidateTimeslot')->name('storeData');

    Route::get('/interview/candidateTimeslot/{sluid}', 'InterviewConfirmationController@viewCandidateTimeslot')->name('candidateTimeslot.view');
    // Route::post('/interview/fetchDates/{sluid}', 'InterviewConfirmationController@fetchDates')->name('candidate.fetchDates');
    // Route::post('/interview/fetchTimeslot/{sluid}', 'InterviewConfirmationController@fetchTimeslot')->name('candidate.fetchTimeslot');
    Route::post('/interview/candidateTimeslot/{sluid}', 'InterviewConfirmationController@updateCandidateTimeslot')->name('candidateTimeslot.update');
    Route::get('/interview/thankYou', function(){
        $thankyouMsg = 'Thank you. We will revert back with an invite for the interview.';
        return view('frontend.interview_thankyou', compact('thankyouMsg'));
    })->name('interview.thankYou');
