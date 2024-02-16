@extends('layouts.app')

<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img class="brand-logo" alt="modern admin logo" src="{{url('/')}}/assets/images/logo/logo.png">
                        <h3 class="brand-text">{{-- config('app.name', 'PepHire') --}}</h3>
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"></li>
                    <li class="dropdown nav-item mega-dropdown">
                    </li>
                    <li class="nav-item nav-search">
                    </li>
                </ul>

                <div id="sho" style="display:block">
                    <ul class="nav navbar-nav float-right">

                        <li class="dropdown dropdown-user nav-item ">

                            <!-- dropdown dropdown-user nav-item show -->
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="avatar avatar-online">

                                    @if(Auth::user()->profileimage)
                                    <img class="profile_image" src="{{url('/storage/'.Auth::user()->profileimage)}}" alt="avatar" onclick="show()">
                                    @else
                                    <img class="profile_image" src="{{url('/')}}/assets/images/candiate-img.png" alt="avatar" onclick="show()">
                                    @endif

                                </span>
                            </a>


                            <div class="dropdown-menu dropdown-menu-right ">

                                <!-- dropdown-menu dropdown-menu-right show -->

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>


                                <div class="profile-img">
                                    <span>
                                        @if(Auth::user()->profileimage)
                                        <img class="rounded-circle" src="{{url('/storage/'.Auth::user()->profileimage)}}">
                                        @else
                                        <img class="rounded-circle" src="{{url('/')}}/assets/images/candiate-img.png">
                                        @endif
                                    </span>
                                </div>
                                <div class="user-name">
                                    <h4>{{ Auth::user()->name }}</h4>
                                    <p>{{ Auth::user()->designation }}</p>
                                </div>
                                <div class="edit">
                                    <a href="{{url('/myprofile')}}" class="btn btn-primary">Edit profile</a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="account-details">
                                    <span>Role</span>
                                    <?php if (auth()->user()->is_manager == '1') { ?>
                                        <p>Administrator</p>
                                    <?php } else { ?>
                                        <p>HR Executive</p>
                                    <?php } ?>
                                    <span>Email</span>
                                    <p>{{ Auth::user()->email }}</p>
                                    <span>Phone</span>
                                    <p>{{ Auth::user()->phone }}</p>
                                    <span>Twitter</span>
                                    <p>{{ Auth::user()->twitter }}</p>
                                    <span>Location</span>
                                    <p>{{ Auth::user()->location }}</p>
                                    <span>Bio</span>
                                    <p>{{ Auth::user()->bio }}</p>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="ft-power"></i> Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div id="shh" style="display:none">
                    <ul class="nav navbar-nav float-right">

                        <li class="dropdown dropdown-user nav-item show">

                            <!-- dropdown dropdown-user nav-item show -->
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="avatar avatar-online">

                                    @if(Auth::user()->profileimage)
                                    <img class="profile_image" src="{{url('/storage/'.Auth::user()->profileimage)}}" alt="avatar" onclick="show()">
                                    @else
                                    <img class="profile_image" src="{{url('/')}}/assets/images/candiate-img.png" alt="avatar" onclick="show()">
                                    @endif

                                </span>
                            </a>


                            <div class="dropdown-menu dropdown-menu-right show">

                                <!-- dropdown-menu dropdown-menu-right show -->

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>


                                <div class="profile-img">
                                    <span>
                                        @if(Auth::user()->profileimage)
                                        <img class="rounded-circle" src="{{url('/storage/'.Auth::user()->profileimage)}}">
                                        @else
                                        <img class="rounded-circle" src="{{url('/')}}/assets/images/candiate-img.png">
                                        @endif
                                    </span>
                                </div>
                                <div class="user-name">
                                    <h4>{{ Auth::user()->name }}</h4>
                                    <p>{{ Auth::user()->designation }}</p>
                                </div>
                                <div class="edit">
                                    <a href="{{url('/myprofile')}}" class="btn btn-primary">Edit profile</a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="account-details">
                                    <span>Role</span>
                                    <?php if (auth()->user()->is_manager == '1') { ?>
                                        <p>Administrator</p>
                                    <?php } else { ?>
                                        <p>HR Executive</p>
                                    <?php } ?>
                                    <span>Email</span>
                                    <p>{{ Auth::user()->email }}</p>
                                    <span>Phone</span>
                                    <p>{{ Auth::user()->phone }}</p>
                                    <span>Twitter</span>
                                    <p>{{ Auth::user()->twitter }}</p>
                                    <span>Location</span>
                                    <p>{{ Auth::user()->location }}</p>
                                    <span>Bio</span>
                                    <p>{{ Auth::user()->bio }}</p>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="ft-power"></i> Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</nav>



<script>
    function show() {

        var targetDiv = document.getElementById("sho");
        var target = document.getElementById("shh");

        if (targetDiv.style.display !== "none") {
            console.log('hloooooo')
            $("#sho").hide();
            $("#shh").show();
        } else {
            console.log('hiiiiiiiiiii')
            $("#sho").show();
            $("#shh").hide();
        }


        // $("#show").show();
        // $("#show1").show();
        //     var targetDiv = document.getElementById("sho");
        //     var target = document.getElementById("shh");

        //   if (targetDiv.style.display !== "none") {
        //     targetDiv.style.display = "none";
        //     target.style.display = "block";
        //   } else {
        //     targetDiv.style.display = "block";
        //     target.style.display = "none";
        //   }




    }
</script>
@section('content')

@section('sidebar')
@include('partials.frontend.sidebar')
@endsection
@push('scripts')



<script src="https://cdn.jsdelivr.net/gh/Dogfalo/materialize@master/extras/noUiSlider/nouislider.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="{{ url('/') }}/assets/vendors/js/extensions/jquery.knob.min.js" type="text/javascript"></script>
<script src="{{ url('/') }}/assets/js/scripts/extensions/knob.js" type="text/javascript"></script>
<script src="{{ url('/') }}/assets/js/range-slider.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
{{-- <script src="{{ url('/') }}/assets/js/scripts/pages/dashboard-sales.js" type="text/javascript"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<script src="{{ url('/') }}/assets/js/jquery-ui.min.js"></script>
<script src="{{ url('/') }}/assets/js/filedrag.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
<script src="{{ url('/') }}/assets/js/interview.js">
    // var dataTable1Items = null;
</script>


<!-- <script src="{{url('/')}}/app-assets/js/scripts/forms/validation/jquery.validate.min.js" type="text/javascript"></script> -->
<script src="{{url('/')}}/js-comment/script.js" type="text/javascript"></script>

<script>
    function chatButtonClick() {

        console.log('hiiiii');

        $('#chatbutton').addClass('d-none');
        $('#chatbox').removeClass('d-none');
    }

    function chatClose() {
        $('#chatbutton').removeClass('d-none');
        $('#chatbox').addClass('d-none');
    }
</script>
@endpush
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{url('/')}}/css-comment/style.css">
<link rel="stylesheet" type="text/css" href="{{url('/')}}/css-comment/demo.css">

<script defer src="{{mix('js/app.js')}}"></script>
<script>
    window.name = '{{ $candidate->name}}'
    window.phoneNumber = '{{ $candidate->phone}}'
</script>
<style type="text/css">
    .profiledetail1 {
        /* padding-top: 30px; */
    }

    .profiledetail-skills>div>p {
        border: none !important;
    }

    .profiledetail-img {
        width: 180px !important;
        height: 180px !important;
    }

    .profiledetail2 ul {
        list-style: none;
    }

    .icon-button {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        color: #333333;
        background: #dddddd;
        border: none;
        outline: none;
        border-radius: 50%;
    }

    .icon-button:hover {
        cursor: pointer;
    }

    .icon-button:active {
        background: #cccccc;
    }

    .icon-button__badge {
        position: absolute;
        /* top: -10px; */
        right: 45px;
        width: auto;
        height: auto;
        background: red;
        color: #ffffff;
        /* display: flex;*/
        justify-content: center;
        align-items: center;
        border-radius: 50%;
    }


    .chatIcon {
        width: 42px;
        height: 42px;
        filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
    }

    .chatIconContainer {
        position: absolute;
        bottom: 60px;
        right: 20px;
        width: fit-content;
        /* background-color: #0d4d00; */
        border-radius: 50%;
        padding: 8px;
        cursor: pointer;
        /* box-shadow:
            0 2.8px 2.2px rgba(0, 0, 0, 0.034),
            0 6.7px 5.3px rgba(0, 0, 0, 0.048),
            0 12.5px 10px rgba(0, 0, 0, 0.06),
            0 22.3px 17.9px rgba(0, 0, 0, 0.072),
            0 41.8px 33.4px rgba(0, 0, 0, 0.086),
            0 100px 80px rgba(0, 0, 0, 0.12) */
    }

    .chatIconContainer2 {
        /* position: absolute;
        top: 100px;
        right: 10px; */
        padding: 10px;
        width: fit-content;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        background-color: #0d4d00;
        border-radius: 10px;
        ;
        padding: 8px;
        cursor: pointer;
        box-shadow:
            0 2.8px 2.2px rgba(0, 0, 0, 0.034),
            0 6.7px 5.3px rgba(0, 0, 0, 0.048),
            0 12.5px 10px rgba(0, 0, 0, 0.06),
            0 22.3px 17.9px rgba(0, 0, 0, 0.072),
            0 41.8px 33.4px rgba(0, 0, 0, 0.086),
            0 100px 80px rgba(0, 0, 0, 0.12)
    }



    .chatContainer {
        position: absolute;
        /* bottom: 60px; */
        top: 90px;
        right: 10px;
        width: 380px;
        height: 700px;
        background-color:
            rgb(212, 212, 212);
        z-index: 8;
        border-radius: 5px;

        overflow: hidden;

    }

    .popout {
        animation: popout 0.5s ease;
        -webkit-animation: popout 0.5s ease;
    }

    .popin {
        animation: popin 1s ease;
        -webkit-animation: popin 1s ease;
    }

    .chatHeader {
        width: 100%;
        height: 45px;
        background-color: rgb(7, 94, 85);
        display: flex;
        flex-direction: row;
        justify-content: start;
        align-content: center;
        padding: 5px;
        padding-left: 10px;


    }

    .chatHeaderIcon {
        width: 35px;
        height: 35px;
        background-color: white;
        border-radius: 50%;
    }

    .header-text-area {
        padding-left: 7px;
        width: 75%;
        height: 35px;
        margin-top: 7px;


    }

    .header-text-area p {
        text-overflow: ellipsis;
        font-size: 14px;
        color: white;
        font-weight: 600;
        text-align: left;
        overflow: hidden;
        white-space: nowrap;
    }

    .chatContent {
        width: 100%;
        height: 100%;
        background-image: url("{{ url('/') }}/assets/images/backgrounds/whatsapp-bg.jpg");
        background-size: cover;

        overflow: hidden;
        overflow-y: scroll;
    }

    .chatClose {
        outline: none;
        border: none;
        background: none;
        cursor: pointer;

    }

    .page {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .marvel-device .screen {
        text-align: left;
    }

    .screen-container {
        height: 100%;
    }

    /* Status Bar */

    .status-bar {
        height: 25px;
        background: #004e45;
        color: #fff;
        font-size: 14px;
        padding: 0 8px;
    }

    .status-bar:after {
        content: "";
        display: table;
        clear: both;
    }

    .status-bar div {
        float: right;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
        margin: 0 0 0 8px;
        font-weight: 600;
    }

    /* Chat */

    .chat {
        height: calc(100% - 69px);
    }

    .chat-container {
        height: 100%;
    }

    /* User Bar */

    .user-bar {
        height: 55px;
        background: #005e54;
        color: #fff;
        padding: 0 8px;
        font-size: 24px;
        position: relative;
        z-index: 1;
    }

    .user-bar:after {
        content: "";
        display: table;
        clear: both;
    }

    .user-bar div {
        float: left;
        transform: translateY(-50%);
        position: relative;
        top: 50%;
    }

    .user-bar .actions {
        float: right;
        margin: 5px 0 0 10px;
    }

    .user-bar .actions img {
        height: 28px;
    }

    .user-bar .actions.more {
        margin: 0 12px 0 20px;
    }

    .user-bar .actions.attachment {
        margin: 0 0 0 20px;
    }

    .user-bar .actions.attachment i {
        display: block;
        /*   transform: rotate(-45deg); */
    }

    .user-bar .avatar {
        margin: 0 0 0 5px;
        width: 36px;
        height: 36px;
    }

    .user-bar .avatar img {
        border-radius: 50%;
        box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1);
        display: block;
        width: 100%;
    }

    .user-bar .name {
        font-size: 17px;
        font-weight: 600;
        text-overflow: ellipsis;
        letter-spacing: 0.3px;
        margin: 0 0 0 8px;
        overflow: hidden;
        white-space: nowrap;
        width: 110px;
    }

    .user-bar .status {
        display: block;
        font-size: 13px;
        font-weight: 400;
        letter-spacing: 0;
    }

    /* Conversation */

    .conversation {
        height: calc(100% - 12px);
        position: relative;
        background: url("https://i.ibb.co/3s1f9Jq/default-wallpaper.png") repeat;
        z-index: 0;
    }

    .conversation ::-webkit-scrollbar {
        transition: all .5s;
        width: 5px;
        height: 1px;
        z-index: 10;
    }

    .conversation ::-webkit-scrollbar-track {
        background: transparent;
    }

    .conversation ::-webkit-scrollbar-thumb {
        background: #b3ada7;
    }

    .conversation .conversation-container {
        height: calc(100% - 68px);
        box-shadow: inset 0 10px 10px -10px #000000;
        overflow-x: hidden;
        padding: 0 16px;
        margin-bottom: 19px;
    }

    .conversation .conversation-container:after {
        content: "";
        display: table;
        clear: both;
    }

    /* Messages */

    .message {
        color: #000;
        clear: both;
        line-height: 18px;
        font-size: 15px;
        padding: 8px;
        position: relative;
        margin: 8px 0;
        max-width: 85%;
        word-wrap: break-word;
        z-index: -1;
    }

    .message:after {
        position: absolute;
        content: "";
        width: 0;
        height: 0;
        border-style: solid;
    }

    .metadata {
        display: inline-block;
        float: right;
        padding: 0 0 0 7px;
        position: relative;
        bottom: -4px;
    }

    .metadata .time {
        color: rgba(0, 0, 0, .45);
        font-size: 11px;
        display: inline-block;
    }

    .metadata .tick {
        display: inline-block;
        margin-left: 2px;
        position: relative;
        top: 4px;
        height: 16px;
        width: 16px;
    }

    .metadata .tick svg {
        position: absolute;
        transition: .5s ease-in-out;
    }

    .metadata .tick svg:first-child {
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform: perspective(800px) rotateY(180deg);
        transform: perspective(800px) rotateY(180deg);
    }

    .metadata .tick svg:last-child {
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform: perspective(800px) rotateY(0deg);
        transform: perspective(800px) rotateY(0deg);
    }

    .metadata .tick-animation svg:first-child {
        -webkit-transform: perspective(800px) rotateY(0);
        transform: perspective(800px) rotateY(0);
    }

    .metadata .tick-animation svg:last-child {
        -webkit-transform: perspective(800px) rotateY(-179.9deg);
        transform: perspective(800px) rotateY(-179.9deg);
    }

    .message:first-child {
        margin: 16px 0 8px;
    }

    .message.received {
        background: #fff;
        border-radius: 0px 5px 5px 5px;
        float: left;
    }

    .message.received .metadata {
        padding: 0 0 0 16px;
    }

    .message.received:after {
        border-width: 0px 10px 10px 0;
        border-color: transparent #fff transparent transparent;
        top: 0;
        left: -10px;
    }

    .message.sent {
        background: #e1ffc7;
        border-radius: 5px 0px 5px 5px;
        float: right;
    }

    .message.sent:after {
        border-width: 0px 0 10px 10px;
        border-color: transparent transparent transparent #e1ffc7;
        top: 0;
        right: -10px;
    }

    /* Compose */

    .conversation-compose {
        display: flex;
        flex-direction: row;
        align-items: flex-end;
        overflow: hidden;
        height: 40px;
        width: 100%;
        z-index: 2;
    }

    .conversation-compose div,
    .conversation-compose input {
        background: #fff;
        height: 100%;
    }

    .conversation-compose .emoji {
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border-radius: 50% 0 0 50%;
        flex: 0 0 auto;
        margin-left: 8px;
        width: 38px;
        height: 38px;
    }

    .conversation-compose .input-msg {
        border: 0;
        flex: 1 1 auto;
        font-size: 14px;
        margin: 0;
        outline: none;
        min-width: 50px;
        height: 36px;
    }

    .conversation-compose .photo {
        flex: 0 0 auto;
        border-radius: 0 30px 30px 0;
        text-align: center;
        width: auto;
        display: flex;
        padding-right: 6px;
        height: 38px;
    }

    .conversation-compose .photo img {
        display: block;
        color: #7d8488;
        font-size: 24px;
        transform: translate(-50%, -50%);
        position: relative;
        top: 50%;
        margin-left: 10px;
    }


    .conversation-compose .send {
        background: transparent;
        border: 0;
        cursor: pointer;
        flex: 0 0 auto;
        margin-right: 8px;
        padding: 0;
        position: relative;
        outline: none;
        margin-left: .5rem;
    }

    .conversation-compose .send .circle {
        background: #008a7c;
        border-radius: 50%;
        color: #fff;
        position: relative;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .conversation-compose .send .circle i {
        font-size: 24px;
        margin-left: 1px;
    }

    /* Small Screens */

    @media (max-width: 768px) {
        .marvel-device.nexus5 {
            border-radius: 0;
            flex: none;
            padding: 0;
            max-width: none;
            overflow: hidden;
            height: 100%;
            width: 100%;
        }

        .marvel-device>.screen .chat {
            visibility: visible;
        }

        .marvel-device {
            visibility: hidden;
        }

        .marvel-device .status-bar {
            display: none;
        }

        .screen-container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .conversation {
            height: calc(100vh - 55px);
        }

        .conversation .conversation-container {
            height: calc(100vh - 120px);
        }
    }

    .profile {
        position: relative;
    }

    .profile img {
        display: block;
    }

    .profile .fa-edit {
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .chatClose:focus {
        border: none;
        outline: none;
    }

    .chatCloseIcon {
        color: white;
        font-weight: 100;

    }

    .chatItem:nth-last-child(1) {
        margin-bottom: 70px;
    }

    .chatItemSender {
        /* width: 80%; */
        padding: 10px;

        height: fit-content;
        margin-top: 20px;
        background-color: white;
        border-radius: 10px;
        margin-left: 10px;
        float: left;
        max-width: 80%;
        min-width: 20px;
    }

    .chatItemReceiver {
        /* width: 80%; */
        padding: 10px;
        /* height: 100px; */
        height: fit-content;
        margin-top: 20px;
        background-color: rgb(226, 255, 199);
        border-radius: 10px;
        margin-right: 10px;
        float: right;
        max-width: 80%;
        min-width: 20px;
    }


    .open-button {
        /* background-color: #555; */
        color: blue;
        /* padding: 16px 20px; */
        /* border: none; */
        /* cursor: pointer;
  opacity: 0.8;
  position: fixed; */
        /* bottom: 23px;
  right: 28px; */
        /* width: 280px; */
    }

    /* The popup chat - hidden by default */
    .chat-popup {
        display: none;
        position: fixed;
        bottom: 0;
        right: 15px;
        overflow-y: scroll;
        /* border: 3px solid #f1f1f1; */
        /* z-index: 9; */
    }

    /* Add styles to the form container */
    .form-container {
        max-width: 500px;
        padding: 10px;
        margin-left: 30px;
        background-color: white;
    }

    /* Full-width textarea */
    .form-container textarea {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        border: none;
        background: #f1f1f1;
        resize: none;
        height: 100px;
    }

    /* When the textarea gets focus, do something */
    .form-container textarea:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Set a style for the submit/send button */
    .form-container .btn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-bottom: 10px;
        opacity: 0.8;
    }

    /* Add a red background color to the cancel button */
    .form-container .cancel {
        background-color: red;
    }

    /* Add some hover effects to buttons */
    .form-container .btn:hover,
    .open-button:hover {
        opacity: 1;
    }


    @keyframes popout {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    @-webkit-keyframes popout {
        from {
            -webkit-transform: scale(0)
        }


        to {
            -webkit-transform: scale(1)
        }
    }

    @-webkit-keyframes popout {
        from {
            -webkit-transform: scale(1)
        }


        to {
            -webkit-transform: scale(0)
        }
    }




    .avatar-upload {
        position: relative;
        max-width: 205px;
        margin: 0px;
        padding-left: 0px;
    }

    .avatar-upload .avatar-edit {
        position: absolute;
        right: 12px;
        z-index: 1;
        top: 10px;
    }

    .copy:hover {
        background-color: #757575;
        color: white;
    }

    .com:hover {
        color: blueviolet;


    }

    .avatar-upload .avatar-edit input {
        display: none;
    }

    .avatar-upload .avatar-edit input+label {
        display: inline-block;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #FFFFFF;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
    }

    .avatar-upload .avatar-edit input+label:hover {
        background: #f1f1f1;
        border-color: #d6d6d6;
    }

    .avatar-upload .avatar-edit input+label:after {
        content: "\f040";
        font-family: 'FontAwesome';
        color: #757575;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        text-align: center;
        margin: auto;
    }

    .avatar-upload .avatar-preview {
        width: 192px;
        height: 192px;
        position: relative;
        border-radius: 100%;
        border: 6px solid #F8F8F8;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
    }

    .avatar-upload .avatar-preview>div {
        width: 100%;
        height: 100%;
        border-radius: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    .badge:after {
        content: "100";
        position: absolute;
        background: rgba(0, 0, 255, 1);
        height: 2rem;
        top: 1rem;
        right: 1.5rem;
        width: 2rem;
        text-align: center;
        line-height: 2rem;
        ;
        font-size: 1rem;
        border-radius: 50%;
        color: white;
        border: 1px solid blue;
    }

    .hovertext {
        position: relative;
        /* border-bottom: 1px dotted black; */
    }

    .hovertext:before {
        content: attr(data-hover);
        visibility: hidden;
        opacity: 0;
        width: 140px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 5px;
        padding: 5px 0;
        transition: opacity 1s ease-in-out;

        position: absolute;
        z-index: 1;
        left: 0;
        top: 110%;
    }

    .hovertext:hover:before {
        opacity: 1;
        visibility: visible;
    }

    .switch {
        position: absolute;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    p {
        font-family: Arial, Helvetica, sans-serif;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        /* -webkit-transition: .4s;
        transition: .4s; */
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }


    /* new style for collapsible text */

    .collapsible {
        /* background-color: #777; */
        /* color: white; */
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
    }

    /* .active, .collapsible:hover { */
    /* background-color: #555; */
    /* } */

    .collapsible:after {
        border-radius: 0px;
        content: '\002B';
        color: white;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .active:after {
        content: "\2212";
    }

    .contentt {
        /* border-radius: 600px; */
        /* padding: 0 18px; */
        max-height: 0;
        overflow: hidden;
        /* transition: max-height 0.2s ease-out; */
        /* background-color: #f1f1f1; */
    }

    /* tooltip for copy profile text */

    .tooltip {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -60px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip .tooltiptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
</style>



<script type="text/javascript">
    function gotoback() {
        history.back();
    }
</script>






<!-- <div class="chatIconContainer2" onclick="chatButtonClick()" id="chatbutton" >
        <img class="chatIcon" style="width: 20px; height: 20px;" src="{{ url('/') }}/assets/images/icons/whatsapp.svg"
            alt="whatsapp">
        <p style="padding-top: 10px; padding-left:10px;color:rgb(228, 228, 228);">Whatsapp</p>
    </div>  -->

<script>
    function chatclick() {
        console.log('hiii');
    }
</script>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row" style="padding-top: 0px;">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class="row" style="padding-top: 0px;">
                <div class="col-3 float-right">
                    <button onclick="gotoback()" type="button" class="btn btn-primary btn-float"><i class="ft-arrow-left" aria-hidden="true"></i></button>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                    <h4 class="titlehead"><span>Profile details</span></h4>
                    <div class="profiledetail-skills presume-btn">
                        <div class="btn btn-primary"><a target="_blank" href="{{ url('/downloaddoc/' . $candidate->resume->ruid) }}"><img src="{{ url('/') }}/assets/images/icons/download_icon.png"> Download Resume</a>
                        </div>

                    </div>
                    <!-- <div class="chatIconContainer2" onclick="chatButtonClick()" id="chatbutton">
                        <img class="chatIcon" style="width: 20px; height: 20px;"
                            src="" alt="whatsapp">
                        <p style="padding-top: 10px; padding-left:10px;color:rgb(228, 228, 228);">Whatsapp</p>
                    </div> -->



                </div>

            </div>


            <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
            <script src="js/script.js"></script>


            <!-- partial -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
            <script src="js/script.js"></script>
            <!-- <button type="button" class="btn cancel" onclick="closeForm()">Close</button> -->


            <div class="common-section ">
                <div class="profiledetail1 ">




                </div>




                <div class="row" style="padding-top: 0px;">
                    <div class="common-profileblock ">
                        <div class="col-md-5">
                            <!-- second block -->
                            <div class="profiledetail2">
                                <ul>
                                    <li>
                                        <p><span>Age (yrs)</span> :
                                            <?php
                                            if ($candidate->dob == '0000-00-00') {
                                            ?>
                                                <span>Nil</span>
                                            <?php
                                            } else {
                                            ?>
                                                <span>{{ \Carbon\Carbon::parse($candidate->dob)->age }}</span>
                                            <?php
                                            }
                                            ?>
                                        </p>
                                        <p><span>Marital Status</span> : <span>{{ ucfirst($candidate->married) }}</span>
                                        </p>
                                        <p><span>Education</span> : <span>{{ ucwords($candidate->education) }}</span></p>
                                        <p><span>Experience</span> : <span>{{ $candidate->experience }}</span></p>

                                        <p><span>Visa Type</span> : <span>{{ $candidate->visatype }}</span></p>
                                        <p><span>Role</span> : <span>{{ ucwords($candidate->role) }}</span></p>
                                        <p><span>Role Category</span> :
                                            <span>{{ ucwords($candidate->role_category) }}</span>
                                        </p>
                                        @if (!empty($candidate->linkedin_id))
                                        <p><span>Linkedin</span> : <span>{{ $candidate->linkedin_id }}</span></p>
                                        @endif



                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="common-firstblock ">


                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <a id="revert_{{ $candidate->id }}" href="{{ url('editprofile/' . $candidate->id) }}"> <input id="imageUpload" />
                                            <label for="imageUpload"></label></a>
                                    </div>
                                    <div class="profiledetail-img">

                                        @if ($candidate->photo == '' && ($candidate->sex == '' || $candidate->sex == 'None'))
                                        <img src="{{ url('/') }}/assets/images/candiate-img.png">

                                        @elseif($candidate->photo == '' && $candidate->sex =='Male')
                                        <img src="{{ url('/') }}/assets/images/male-user.png">

                                        @elseif($candidate->photo == '' && $candidate->sex =='Female')
                                        <img src="{{ url('/') }}/assets/images/woman.png">

                                        @else
                                        <img src="{{ asset('storage/' . $candidate->photo) }}">

                                        @endif

                                    </div>
                                </div>

                                <div class="profiledetail1 " style=" padding-top: 0px;">

                                    <h4> {{ $candidate->name }}</h4>
                                    <p> {{ $candidate->role }} </p>
                                    <p style="line-height: 21px;">
                                        <span>{{ $candidate->email }}</span>
                                        <span>{{ $candidate->phone }}</span>
                                        <span>ID :: {{ $candidate->id }}</span>
                                        <?php
                                        if ($latest != NULL) {
                                        ?>
                                            <span>Last Contacted date :: {{ $latest->Recieved }}</span>
                                        <?php
                                        }
                                        ?>
                                        <span>{{$candidate->datalink}}</span>

                                        <!-- if() -->
                                    </p>


                                    <!-- <button class="open-button" onclick="openForm()"></button> -->
                                    <!-- <span class="badge" style="color: #000;">3</span> -->
                                </div>


                            </div>
                        </div>
                        <span>
                        </span>
                    </div>
                    <div class="row" style="flex-wrap: inherit;">
                        <div style="margin-left:35%;margin-top:10px; flex-wrap: nowrap;">
                            <?php
                            if ($candidate->status == 3) {
                            ?>
                                <span style="color:BLUE"><b style="color: grey">Engagement Status::</b><button style="color:blue;background:yellow;border:yellow">
                                        <B>NOT INTERESTED</B></button></span>



                            <?php
                            }
                            if ($candidate->status == 1) {
                            ?>
                                <span style="color:BLUE"><b style="color: grey">Engagement Status::</b><button style="color:blue;background:yellow;border:yellow">
                                        <B>CONTACTED</B></button></span>



                            <?php
                            }
                            if ($candidate->status == 2) {
                            ?>
                                <span style="color:BLUE"><b style="color: grey">Engagement Status::</b><button style="color:blue;background:yellow;border:yellow">
                                        <B>INTERESTED</B></button></span>



                            <?php
                            }
                            // != 0 && $candidate->status != 1 && $candidate->status != 2

                            if ($candidate->status == 4) {
                            ?>
                                <span style="color:red;margin-left:9px;"><b style="color: grey"> Status::</b><button style="color:red;background:yellow;border:yellow"><B>NOT CONTACTED</B></button></span>
                            <?php                                             }


                            ?>
                            <!-- </div> -->
                            <!-- <br> -->
                            <input type="text" value="<?php echo $candidate->datalink; ?>" id="myInput" readonly style="display: none;" class="js-copytextarea">

                            <button onclick="copyToClip()" style="border-color: white;color:black;margin-top:10px" class="popup_1">
                                <b>Profile Link <i class="fa fa-clipboard" aria-hidden="true" data-copytarget="#link"></i></b></button>
                            <script type="text/javascript">
                                function copyToClip() {
                                    console.log('hii')
                                    var copied = $("#myInput").val()
                                    copyToClipboard(copied);
                                    console.log('Clipboard updated 📥\nNow try pasting!');
                                }


                                const unsecuredCopyToClipboard = (text) => {
                                    const textArea = document.createElement("textarea");
                                    textArea.value = text;
                                    document.body.appendChild(textArea);
                                    textArea.focus();
                                    textArea.select();
                                    try {
                                        document.execCommand('copy')
                                    } catch (err) {
                                        console.error('Unable to copy to clipboard', err)
                                    }
                                    document.body.removeChild(textArea)
                                };

                                /**
                                 * Copies the text passed as param to the system clipboard
                                 * Check if using HTTPS and navigator.clipboard is available
                                 * Then uses standard clipboard API, otherwise uses fallback
                                 */
                                const copyToClipboard = (content) => {
                                    if (window.isSecureContext && navigator.clipboard) {
                                        navigator.clipboard.writeText(content);
                                    } else {
                                        unsecuredCopyToClipboard(content);
                                    }
                                };
                            </script>

                            &nbsp;&nbsp;<img onclick="openForm()" src="https://www.kindpng.com/picc/m/153-1537658_twitter-comment-icon-png-clipart-png-download-topic.png" width="34" height="36" style="margin-left:10px;margin-top:2px"> &nbsp;&nbsp;

                            <?php
                            if ($candidate->flag == '1') {
                            ?><span class="hovertext" data-hover="Adhoc Flow(ON/OFF)">
                                    <label class="switch" style="margin-top:10px">
                                        <input type="checkbox" class="tooltip" checked onclick="window.location='{{ url('/start/' . $candidate->id)  }}'">
                                        <span class="slider round "></span>
                                        <!-- <span> <div class="hide"></div></span> -->

                                        <!-- <span>hiiii</span> -->
                                        <!-- <div class="hide">I am shown when someone hovers over the div above.</div> -->
                                    </label>
                                </span>

                            <?php
                            }
                            ?>
                            <?php
                            if ($candidate->flag == '0' || $candidate->flag == '') {
                            ?>
                                <span class="hovertext" data-hover="Adhoc Flow(ON/OFF)">
                                    <label class="switch" style="margin-top:10px">
                                        <input type="checkbox" onclick="window.location='{{ url('/start/' . $candidate->id)  }}'">
                                        <span class="slider round"></span><br><br>

                                        <!-- <span> <div class="hide">Adhoc flow ON/OFF</div></span> -->
                                    </label>
                                </span>

                            <?php
                            }
                            ?>
                            <div class="chat-popup" id="myForm">

                                <section id="app">
                                    <div class="container" style="margin-top: 60px;">

                                        <div class="row">

                                            <button class="close-button " aria-label="Close alert" type="button" data-close onclick="closeForm()" style="float: right;">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <?php
                                        foreach ($comments as $comment) {


                                        ?>
                                            <div class="row">
                                                <div class="col-6">

                                                    <div class="comment">
                                                        <p style="width: auto;color:#000;width: 31em;    
      
      padding: 10px;    
      word-wrap: break-word;    
      font-size: 13px;  "><b>{{$comment->user_id}}</b>&nbsp;{{$comment->date}}&nbsp;{{$comment->comment}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <form enctype="multipart/form-data" method="post" action="{{ url('/comment/' . $candidate->id) }}">
                                            @csrf
                                            <div class="row">

                                                <div class="col-6">
                                                    <textarea type="text" class="input" placeholder="Write a comment" v-model="newItem" style="width: 400px;" name="comment"></textarea>
                                                    <button v-on:click="" class='primaryContained float-right' type="submit">Add Comment</button>

                                                </div>
                                            </div>
                                    </div>
                                    </form>
                                </section>
                            </div>
                        </div>
                        <div id="whatsapp">
                            <whatsapp-chat></whatsapp-chat>
                            <hello></hello>
                        </div>

                    </div>
                </div>

                <!-- </button> -->


                <script>
                    function openForm() {
                        document.getElementById("myForm").style.display = "block";
                    }

                    function closeForm() {
                        document.getElementById("myForm").style.display = "none";
                    }
                </script>


                <!-- <h4 class="titlehead">
                        </h4> -->
                @php

                $skill = App\Candidate_Skill::where('candidate_id', $candidate->id)



                ->pluck('skillname')->toArray();

                @endphp

                @if (!empty($skill))

                <div class="profiledetail-skills">

                    <h4>Skills</h4>

                    <div class="p-left">

                        @foreach ($skill as $mk)

                        @if ( !in_array(strtolower($mk), $common_words) )

                        <div>

                            <p>{{ ucwords($mk) }}</p>

                        </div>

                        @endif()

                        @endforeach

                    </div>

                </div>

                @endif

                @if ($candidate->companies->count())
                <div class="profiledetail-skills profiledetail3" style="
    margin-top: 30px;
">
                    <h4 style="font-size: 22px; margin-bottom:0px;padding-left: 0;font-weight: 600;">
                        Company History
                    </h4>
                    @foreach ($candidate->companies as $company)
                    <p style="
    margin: 0px;
">{{ $company->name }}</p>
                    @endforeach
                </div>
                @endif
                <style>
                    /* .contentt {
                        display: none;
                    } */
                </style>
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                <script>
                    $(document).ready(function() {
                        $(".collapsible").click(function() {
                            $(this).next(".contentt").slideToggle("slow");
                        });
                    });
                </script>
                <div class="profiledetail-skills profiledetail4">
                    <!-- First collapsible section -->
                    <div class="halfblock" style="padding: 0px 0;">
                        <h4 class="collapsible"><span class="headicon-box"><img src="{{ url('/') }}/assets/images/icons/engage.png"></span> How to Engage with {{ $candidate->name }}</h4>
                        <p class="contentt">{{ $candidate->engage_details }}</p>
                    </div>
                    <div class="halfblock" style="padding: 0px 0;">
                        <h4 class="collapsible"><span class="headicon-box "><img src="{{ url('/') }}/assets/images/icons/patterns.png"></span> Patterns
                            of productivity for {{ $candidate->name }}</h4>
                        <p class="contentt">{{ $candidate->productivity_details }}</p>
                    </div>
                    <div class="halfblock" style="padding: 0px 0;">
                        <h4 class="collapsible"><span class="headicon-box "><img src="{{ url('/') }}/assets/images/icons/corporate.png"></span> How
                            {{ $candidate->name }} will add to the corporate culture
                        </h4>
                        <p class="contentt">{{ $candidate->corporate_culture }}</p>
                    </div>
                    <div class="halfblock" style="padding: 0px 0;">
                        <h4 class="collapsible"><span class="headicon-box "><img src="{{ url('/') }}/assets/images/icons/strength.png"></span> Sensed
                            Strengths of {{ $candidate->name }}'s Character</h4>
                        <p class="contentt">{{ $candidate->strength_details }}</p>
                    </div>
                </div>

                @if ($candidate->behavior != '')
                <h4 class="titlehead "></h4>
                <br />
                <div class="profiledetail3">
                    <h4 class="collapsible">Behavior</h4>
                    <p class="contentt">{{ $candidate->behavior }}</p>
                </div>
                <!-- <div class="line-divider"></div> -->
                @endif

                @if ($candidate->communication != '')
                <h4 class="titlehead"></h4>
                <br />
                <div class="profiledetail3">
                    <h4 class="collapsible">Communication</h4>
                    <p class="contentt">{{ $candidate->communication }}</p>
                </div>
                <!-- <div class="line-divider"></div> -->
                @endif

                @if ($candidate->drains != '')
                <h4 class="titlehead"></h4>
                <br />
                <div class="profiledetail3">
                    <h4 class="collapsible">Drains</h4>
                    <p class="contentt">{{ $candidate->drains }}</p>
                </div>
                <!-- <div class="line-divider"></div> -->
                @endif

                @if ($candidate->meeting != '')
                <h4 class="titlehead"></h4>
                <br />
                <div class="profiledetail3">
                    <h4 class="collapsible">Meeting</h4>
                    <p class="contentt">{{ $candidate->meeting }}</p>
                </div>
                <!-- <div class="line-divider"></div> -->
                @endif

                @if ($candidate->motivations != '')
                <h4 class="titlehead"></h4>
                <br />
                <div class="profiledetail3">
                    <h4 class="collapsible">Motivations</h4>
                    <p class="contentt">{{ $candidate->motivations }}</p>
                </div>
                @endif

                @if ($candidate->profile_details != '')
                <h4 class="titlehead"></h4>
                <br />
                <div class="profiledetail3">
                    <h4 class="collapsible">Profile Details</h4>
                    <p class="contentt">{{ $candidate->profile_details }}</p>
                </div>
                @endif


            </div>
        </div>
    </div>
    <!--/ Revenue, Hit Rate & Deals -->
</div>
</div>
</div>


<!-- 
<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }
</script> -->
@section('footer')
@include('partials.frontend.interview')
@endsection
@endsection
@section('footer')
@include('partials.frontend.footer')
@endsection