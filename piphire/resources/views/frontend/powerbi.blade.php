@extends('layouts.app')

@section('header')
  @include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
  @include('partials.frontend.sidebar')
@endsection

<div class="app-conent h-100 content">
 
    <div class="w-100" style="height: 630px" id="report-container"></div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/powerbi-client/2.14.1/powerbi.min.js"></script>
    <script>
        let models = window["powerbi-client"].models;
        let reportContainer = $("#report-container").get(0);
        let embedUrl = "{!! $result["embedUrl"] !!}";
        let accessToken = "{!! $result['accessToken'] !!}";
      

        powerbi.bootstrap(reportContainer, {
            type: "report"
        });

        

        

       
     
        // AJAX request to get the report details from the API and pass it to the UI
        let reportLoadConfig = {
            type: "report",
            tokenType: models.TokenType.Embed,
            accessToken: "{!! $result["accessToken"] !!}",
            embedUrl: embedUrl,
            // oDataFilter: "SPVDetails/UserID eq 'BSNL_A' ",
            /*
            // Enable this setting to remove gray shoulders from embedded report
            settings: {
                background: models.BackgroundType.Transparent
            }
            */
        };
     

        function createIframe(){
            $('<iframe>')
            $('<iframe>', {
                name: 'frame1',
                id: 'frame1',
                src: "{!! $result["embedUrl"] !!}"
            }).appendTo('#report-container');
        }
     

        // Use the token expiry to regenerate Embed token for seamless end user experience
        // Refer https://aka.ms/RefreshEmbedToken
        tokenExpiry = "{!! $result["expiry"] !!}";

        // Embed Power BI report when Access token and Embed URL are available
        let report = powerbi.embed(reportContainer, reportLoadConfig);
        
        // Clear any other loaded handler events
        report.off("loaded");

        // Triggers when a report schema is successfully loaded
        report.on("loaded", function () {
            console.log("Report load successful");
        });

        // Clear any other rendered handler events
        report.off("rendered");

        // Triggers when a report is successfully embedded in UI
        report.on("rendered", function () {
            console.log("Report render successful");
        });

        // Clear any other error handler events
        report.off("error");

        // Handle embed errors
        report.on("error", function (event) {
            let errorMsg = event.detail;
            console.error(errorMsg);
            return;
        });




    </script>

@section('footer')
@include('partials.frontend.interview')
@endsection
@endsection

@section('footer')
  @include('partials.frontend.footer')
@endsection 