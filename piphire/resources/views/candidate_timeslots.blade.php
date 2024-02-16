<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PepHire</title>

    <link rel="icon" href="{{url('/')}}/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="{{url('/')}}/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('/')}}/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" integrity="sha512-csNcFYJniKjJxRWRV1R7fvnXrycHP6qDR21mgz1ZP55xY5d+aHLfo9/FcGDQLfn2IfngbAHd8LdfsagcCqgTcQ==" crossorigin="anonymous" referrerpolicy="no-referrer"> </script>
    <style>
        #headerpart {
            background-image: linear-gradient(to right, rgba(245, 246, 252, 0.52), rgb(13 221 223 / 83%)), url('https://www.theforage.com/blog/wp-content/uploads/2023/04/What-Is-a-Panel-Interview.jpg');

            width: 100%;
            background-repeat: no-repeat;
            background-size: cover;
            object-fit: cover;
            text-align: center;
        }

        #slotpart {
            height: auto;
            margin-left: auto;
            margin-right: auto;
            border-radius: 25px;
            background: white;
            width: 98%;
            padding: 15px 25px;
        }

        @media screen and (min-width: 992px) {
            #headerpart {
                padding: 100px;
                height: 85vh;
            }

            #slotpart {
                margin-top: -235px;
            }

            #calander,
            #availability {
                border-right: 1px solid gainsboro;
            }

            .logo {
                position: absolute;
                top: 25;
                left: 25;
            }
        }

        .brand-logo {
            width: 100px;
        }

        #availability label {
            color: grey;
            margin-left: 17px;
            line-height: 30px;
            font-size: 13px;
        }

        #availability small,
        #selectedslots small {
            color: gray;
        }

        .selected-dates {
            font-size: 12px;
            border: 1px solid gainsboro;
            padding: 2px 40px;
            border-radius: 5px;
            color: gray;
        }

        #selectedslots-container {
            padding: 0px 25px;
        }

        #selectedslots-container hr {
            color: #62d1bc;
            opacity: 1;
            margin-top: 5px;
        }

        .selection-times {
            color: gray;
            background: #dcdcdc4a;
            padding: 6px 34px;
            font-size: 12px;
            margin: 15px 9px;
            line-height: 37px;
            border: 1px solid #dcdcdc4a;
        }

        .comments {
            color: grey;
            line-height: 24px;
            font-size: 13px;
            background: #62d1bc59;
            padding: 0px 20px;
        }

        #commentssection {
            margin-top: 13px;
        }

        #availabilitytime-container {
            padding: 20px;
            color: grey;
        }

        .checkbox-round {
            width: 1em;
            height: 1em;
            background-color: white;
            border-radius: 50%;
            vertical-align: middle;
            border: 1px solid #ddd;
            appearance: none;
            -webkit-appearance: none;
            outline: none;
            cursor: pointer;
        }

        .checkbox-round:checked {
            background-color: gray;
        }

        .date-delete {
            font-size: 14px;
            color: gray;
            position: relative;
            margin-left: -12px;
            margin-top: -4px;
            cursor: pointer;
        }

        .time-delete {
            font-size: 12px;
            color: gray;
            position: relative;
            margin-left: -20px;
            margin-top: 0px;
            cursor: pointer;
            font-weight: 600;
        }

        .comment-delete {
            font-size: 14px;
            color: gray;
            position: relative;
            margin-left: -9px;
            cursor: pointer;
        }

        /*!
 * Datepicker for Bootstrap v1.5.0 (https://github.com/eternicode/bootstrap-datepicker)
 *
 * Copyright 2012 Stefan Petre
 * Improvements by Andrew Rowls
 * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */
        .datepicker {
            padding: 4px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            direction: ltr;
        }

        .datepicker-inline {
            /* width: 220px; */
        }

        .datepicker.datepicker-rtl {
            direction: rtl;
        }

        .datepicker.datepicker-rtl table tr td span {
            float: right;
        }

        .datepicker-dropdown {
            top: 0;
            left: 0;
        }

        .datepicker-dropdown:before {
            content: '';
            display: inline-block;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-bottom: 7px solid #999999;
            border-top: 0;
            border-bottom-color: rgba(0, 0, 0, 0.2);
            position: absolute;
        }

        .datepicker-dropdown:after {
            content: '';
            display: inline-block;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 6px solid #ffffff;
            border-top: 0;
            position: absolute;
        }

        .datepicker-dropdown.datepicker-orient-left:before {
            left: 6px;
        }

        .datepicker-dropdown.datepicker-orient-left:after {
            left: 7px;
        }

        .datepicker-dropdown.datepicker-orient-right:before {
            right: 6px;
        }

        .datepicker-dropdown.datepicker-orient-right:after {
            right: 7px;
        }

        .datepicker-dropdown.datepicker-orient-bottom:before {
            top: -7px;
        }

        .datepicker-dropdown.datepicker-orient-bottom:after {
            top: -6px;
        }

        .datepicker-dropdown.datepicker-orient-top:before {
            bottom: -7px;
            border-bottom: 0;
            border-top: 7px solid #999999;
        }

        .datepicker-dropdown.datepicker-orient-top:after {
            bottom: -6px;
            border-bottom: 0;
            border-top: 6px solid #ffffff;
        }

        .datepicker>div {
            display: none;
        }

        .datepicker table {
            margin: 0;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            width: 100%;
        }

        .datepicker td,
        .datepicker th {
            text-align: center;
            width: 20px;
            height: 20px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            border: none;
            color: gray;
            font-weight: 400;
            font-size: 12px;
            font-family: mulish;
        }

        .table-striped .datepicker table tr td,
        .table-striped .datepicker table tr th {
            background-color: transparent;
        }

        .datepicker table tr td.day:hover,
        .datepicker table tr td.day.focused {
            background: #eeeeee;
            cursor: pointer;
        }

        .datepicker table tr td.old,
        .datepicker table tr td.new {
            color: #999999;
        }

        .datepicker table tr td.disabled,
        .datepicker table tr td.disabled:hover {
            background: none;
            color: #999999;
            cursor: default;
        }

        .datepicker table tr td.highlighted {
            background: #d9edf7;
            border-radius: 0;
        }

        .datepicker table tr td.today,
        .datepicker table tr td.today:hover,
        .datepicker table tr td.today.disabled,
        .datepicker table tr td.today.disabled:hover {
            background-color: #fde19a;
            background-image: -moz-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: -ms-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fdd49a), to(#fdf59a));
            background-image: -webkit-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: -o-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fdd49a', endColorstr='#fdf59a', GradientType=0);
            border-color: #fdf59a #fdf59a #fbed50;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #000;
        }

        .datepicker table tr td.today:hover,
        .datepicker table tr td.today:hover:hover,
        .datepicker table tr td.today.disabled:hover,
        .datepicker table tr td.today.disabled:hover:hover,
        .datepicker table tr td.today:active,
        .datepicker table tr td.today:hover:active,
        .datepicker table tr td.today.disabled:active,
        .datepicker table tr td.today.disabled:hover:active,
        .datepicker table tr td.today.active,
        .datepicker table tr td.today:hover.active,
        .datepicker table tr td.today.disabled.active,
        .datepicker table tr td.today.disabled:hover.active,
        .datepicker table tr td.today.disabled,
        .datepicker table tr td.today:hover.disabled,
        .datepicker table tr td.today.disabled.disabled,
        .datepicker table tr td.today.disabled:hover.disabled,
        .datepicker table tr td.today[disabled],
        .datepicker table tr td.today:hover[disabled],
        .datepicker table tr td.today.disabled[disabled],
        .datepicker table tr td.today.disabled:hover[disabled] {
            background-color: #fdf59a;
        }

        .datepicker table tr td.today:active,
        .datepicker table tr td.today:hover:active,
        .datepicker table tr td.today.disabled:active,
        .datepicker table tr td.today.disabled:hover:active,
        .datepicker table tr td.today.active,
        .datepicker table tr td.today:hover.active,
        .datepicker table tr td.today.disabled.active,
        .datepicker table tr td.today.disabled:hover.active {
            background-color: #fbf069 \9;
        }

        .datepicker table tr td.today:hover:hover {
            color: #000;
        }

        .datepicker table tr td.today.active:hover {
            color: #fff;
        }

        .datepicker table tr td.range,
        .datepicker table tr td.range:hover,
        .datepicker table tr td.range.disabled,
        .datepicker table tr td.range.disabled:hover {
            background: #eeeeee;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }

        .datepicker table tr td.range.today,
        .datepicker table tr td.range.today:hover,
        .datepicker table tr td.range.today.disabled,
        .datepicker table tr td.range.today.disabled:hover {
            background-color: #f3d17a;
            background-image: -moz-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: -ms-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f3c17a), to(#f3e97a));
            background-image: -webkit-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: -o-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f3c17a', endColorstr='#f3e97a', GradientType=0);
            border-color: #f3e97a #f3e97a #edde34;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }

        .datepicker table tr td.range.today:hover,
        .datepicker table tr td.range.today:hover:hover,
        .datepicker table tr td.range.today.disabled:hover,
        .datepicker table tr td.range.today.disabled:hover:hover,
        .datepicker table tr td.range.today:active,
        .datepicker table tr td.range.today:hover:active,
        .datepicker table tr td.range.today.disabled:active,
        .datepicker table tr td.range.today.disabled:hover:active,
        .datepicker table tr td.range.today.active,
        .datepicker table tr td.range.today:hover.active,
        .datepicker table tr td.range.today.disabled.active,
        .datepicker table tr td.range.today.disabled:hover.active,
        .datepicker table tr td.range.today.disabled,
        .datepicker table tr td.range.today:hover.disabled,
        .datepicker table tr td.range.today.disabled.disabled,
        .datepicker table tr td.range.today.disabled:hover.disabled,
        .datepicker table tr td.range.today[disabled],
        .datepicker table tr td.range.today:hover[disabled],
        .datepicker table tr td.range.today.disabled[disabled],
        .datepicker table tr td.range.today.disabled:hover[disabled] {
            background-color: #f3e97a;
        }

        .datepicker table tr td.range.today:active,
        .datepicker table tr td.range.today:hover:active,
        .datepicker table tr td.range.today.disabled:active,
        .datepicker table tr td.range.today.disabled:hover:active,
        .datepicker table tr td.range.today.active,
        .datepicker table tr td.range.today:hover.active,
        .datepicker table tr td.range.today.disabled.active,
        .datepicker table tr td.range.today.disabled:hover.active {
            background-color: #efe24b \9;
        }

        .datepicker table tr td.selected,
        .datepicker table tr td.selected:hover,
        .datepicker table tr td.selected.disabled,
        .datepicker table tr td.selected.disabled:hover {
            background-color: #9e9e9e;
            background-image: -moz-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: -ms-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#b3b3b3), to(#808080));
            background-image: -webkit-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: -o-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: linear-gradient(to bottom, #b3b3b3, #808080);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b3b3b3', endColorstr='#808080', GradientType=0);
            border-color: #808080 #808080 #595959;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        }

        .datepicker table tr td.selected:hover,
        .datepicker table tr td.selected:hover:hover,
        .datepicker table tr td.selected.disabled:hover,
        .datepicker table tr td.selected.disabled:hover:hover,
        .datepicker table tr td.selected:active,
        .datepicker table tr td.selected:hover:active,
        .datepicker table tr td.selected.disabled:active,
        .datepicker table tr td.selected.disabled:hover:active,
        .datepicker table tr td.selected.active,
        .datepicker table tr td.selected:hover.active,
        .datepicker table tr td.selected.disabled.active,
        .datepicker table tr td.selected.disabled:hover.active,
        .datepicker table tr td.selected.disabled,
        .datepicker table tr td.selected:hover.disabled,
        .datepicker table tr td.selected.disabled.disabled,
        .datepicker table tr td.selected.disabled:hover.disabled,
        .datepicker table tr td.selected[disabled],
        .datepicker table tr td.selected:hover[disabled],
        .datepicker table tr td.selected.disabled[disabled],
        .datepicker table tr td.selected.disabled:hover[disabled] {
            background-color: #808080;
        }

        .datepicker table tr td.selected:active,
        .datepicker table tr td.selected:hover:active,
        .datepicker table tr td.selected.disabled:active,
        .datepicker table tr td.selected.disabled:hover:active,
        .datepicker table tr td.selected.active,
        .datepicker table tr td.selected:hover.active,
        .datepicker table tr td.selected.disabled.active,
        .datepicker table tr td.selected.disabled:hover.active {
            background-color: #666666 \9;
        }

        .datepicker table tr td.active,
        .datepicker table tr td.active:hover,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active.disabled:hover {
            background-color: #006dcc;
            background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
            background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: linear-gradient(to bottom, #0088cc, #0044cc);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
            border-color: #0044cc #0044cc #002a80;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        }

        .datepicker table tr td.active:hover,
        .datepicker table tr td.active:hover:hover,
        .datepicker table tr td.active.disabled:hover,
        .datepicker table tr td.active.disabled:hover:hover,
        .datepicker table tr td.active:active,
        .datepicker table tr td.active:hover:active,
        .datepicker table tr td.active.disabled:active,
        .datepicker table tr td.active.disabled:hover:active,
        .datepicker table tr td.active.active,
        .datepicker table tr td.active:hover.active,
        .datepicker table tr td.active.disabled.active,
        .datepicker table tr td.active.disabled:hover.active,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active:hover.disabled,
        .datepicker table tr td.active.disabled.disabled,
        .datepicker table tr td.active.disabled:hover.disabled,
        .datepicker table tr td.active[disabled],
        .datepicker table tr td.active:hover[disabled],
        .datepicker table tr td.active.disabled[disabled],
        .datepicker table tr td.active.disabled:hover[disabled] {
            background-color: #0044cc;
        }

        .datepicker table tr td.active:active,
        .datepicker table tr td.active:hover:active,
        .datepicker table tr td.active.disabled:active,
        .datepicker table tr td.active.disabled:hover:active,
        .datepicker table tr td.active.active,
        .datepicker table tr td.active:hover.active,
        .datepicker table tr td.active.disabled.active,
        .datepicker table tr td.active.disabled:hover.active {
            background-color: #003399 \9;
        }

        .datepicker table tr td span {
            display: block;
            width: 23%;
            height: 54px;
            line-height: 54px;
            float: left;
            margin: 1%;
            cursor: pointer;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
        }

        .datepicker table tr td span:hover {
            background: #eeeeee;
        }

        .datepicker table tr td span.disabled,
        .datepicker table tr td span.disabled:hover {
            background: none;
            color: #999999;
            cursor: default;
        }

        .datepicker table tr td span.active,
        .datepicker table tr td span.active:hover,
        .datepicker table tr td span.active.disabled,
        .datepicker table tr td span.active.disabled:hover {
            background-color: #006dcc;
            background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
            background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: linear-gradient(to bottom, #0088cc, #0044cc);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
            border-color: #0044cc #0044cc #002a80;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        }

        .datepicker table tr td span.active:hover,
        .datepicker table tr td span.active:hover:hover,
        .datepicker table tr td span.active.disabled:hover,
        .datepicker table tr td span.active.disabled:hover:hover,
        .datepicker table tr td span.active:active,
        .datepicker table tr td span.active:hover:active,
        .datepicker table tr td span.active.disabled:active,
        .datepicker table tr td span.active.disabled:hover:active,
        .datepicker table tr td span.active.active,
        .datepicker table tr td span.active:hover.active,
        .datepicker table tr td span.active.disabled.active,
        .datepicker table tr td span.active.disabled:hover.active,
        .datepicker table tr td span.active.disabled,
        .datepicker table tr td span.active:hover.disabled,
        .datepicker table tr td span.active.disabled.disabled,
        .datepicker table tr td span.active.disabled:hover.disabled,
        .datepicker table tr td span.active[disabled],
        .datepicker table tr td span.active:hover[disabled],
        .datepicker table tr td span.active.disabled[disabled],
        .datepicker table tr td span.active.disabled:hover[disabled] {
            background-color: #0044cc;
        }

        .datepicker table tr td span.active:active,
        .datepicker table tr td span.active:hover:active,
        .datepicker table tr td span.active.disabled:active,
        .datepicker table tr td span.active.disabled:hover:active,
        .datepicker table tr td span.active.active,
        .datepicker table tr td span.active:hover.active,
        .datepicker table tr td span.active.disabled.active,
        .datepicker table tr td span.active.disabled:hover.active {
            background-color: #003399 \9;
        }

        .datepicker table tr td span.old,
        .datepicker table tr td span.new {
            color: #999999;
        }

        .datepicker .datepicker-switch {
            width: 145px;
            color: gray;
            font-weight: 500;
        }

        .datepicker .datepicker-switch,
        .datepicker .prev,
        .datepicker .next,
        .datepicker tfoot tr th {
            cursor: pointer;
        }

        .datepicker .datepicker-switch:hover,
        .datepicker .prev:hover,
        .datepicker .next:hover,
        .datepicker tfoot tr th:hover {
            background: #eeeeee;
        }

        .datepicker .cw {
            font-size: 10px;
            width: 12px;
            padding: 0 2px 0 5px;
            vertical-align: middle;
        }

        .input-append.date .add-on,
        .input-prepend.date .add-on {
            cursor: pointer;
        }

        .input-append.date .add-on i,
        .input-prepend.date .add-on i {
            margin-top: 3px;
        }

        .input-daterange input {
            text-align: center;
        }

        .input-daterange input:first-child {
            -webkit-border-radius: 3px 0 0 3px;
            -moz-border-radius: 3px 0 0 3px;
            border-radius: 3px 0 0 3px;
        }

        .input-daterange input:last-child {
            -webkit-border-radius: 0 3px 3px 0;
            -moz-border-radius: 0 3px 3px 0;
            border-radius: 0 3px 3px 0;
        }

        .input-daterange .add-on {
            display: inline-block;
            width: auto;
            min-width: 16px;
            height: 18px;
            padding: 4px 5px;
            font-weight: normal;
            line-height: 18px;
            text-align: center;
            text-shadow: 0 1px 0 #ffffff;
            vertical-align: middle;
            background-color: #eeeeee;
            border: 1px solid #ccc;
            margin-left: -5px;
            margin-right: -5px;
        }

        .datepicker-switch {
            color: #007bff !important;
            font-size: 16px !important;
            font-family: mulish;
            font-weight: bolder !important;
        }

        .datepicker-days .table-condensed {
            font-size: 13px;
        }

        #headerpart big {
            font-size: 23px;
            letter-spacing: 1;
        }

        .description {
            padding-top: 15px;
        }

        .description-content {
            font-size: 12px;
            color: black;
            word-spacing: 4px;
            font-family: Mulish;
        }

        .submitbtn {
            border: none;
            color: #007bff ! important;
            width: 100%;
            background: white;
            box-shadow: 1px 5px 5px 1px #ccc;
            margin-top: 10px;
            font-size: 13px;
            font-weight: 600;
        }

        .noselect {
            -webkit-touch-callout: none;
            /* iOS Safari */
            -webkit-user-select: none;
            /* Safari */
            -khtml-user-select: none;
            /* Konqueror HTML */
            -moz-user-select: none;
            /* Old versions of Firefox */
            -ms-user-select: none;
            /* Internet Explorer/Edge */
            user-select: none;
            /* Non-prefixed version, currently
	   supported by Chrome, Opera and Firefox */
        }

        .time-picker {
            display: flex;
            align-items: center;
            margin: 15px auto;
            width: 100%;
            /*justify-content:space-evenly;*/
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 0px;
            background: #dcdcdc26;
        }

        .tp-col {
            display: flex;
            flex-direction: column;
            align-items: inherit;
        }

        .tp-hr>span,
        .tp-min>span {
            border: 1px solid #ccc;
            padding: 0px 0px;
            border-radius: 4px;
            width: 30px;
            text-align: center;
            background: #ccc;
            font-size: 16px;
            font-family: mulish;
            margin: 0px 3px;
            background: #cccccc4a;
        }

        .tp-up-arrow,
        .tp-down-arrow,
        .tp-up-arrow-merdian,
        .tp-down-arrow-merdian {
            cursor: pointer;
            width: 15px;
            height: 12px;
            opacity: 0.4;
        }

        .tp-am-pm {
            cursor: pointer;
            display: block;
            padding: 1px 3px;
            border-radius: 5px;
            margin: 0px 3px;
            background: #cccccc4a;
        }

        .tp-am-pm:hover {
            background: #eaeaea;
        }

        .tp-hr,
        .tp-min {
            
        }
        #addslottime {
            color: gray;
            border: 1px solid gray;
            padding: 1px 8px;
            border-radius: 8px;
            font-size: 13px;
            margin-right: 5px;
            background: #cccccc4a;
        }

        .blueheader {
            font-size: 14px;
            font-family: Mulish;
            font-weight: bolder;
        }
    </style>
</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <div class="main-container">
        <div class="container-fluid" id="headerpart">
            <a class="navbar-brand logo" href="http://pepdemo.westindia.cloudapp.azure.com">
                <img class="brand-logo" alt="modern admin logo" src="http://pepdemo.westindia.cloudapp.azure.com/assets/images/logo/logo.png">
                <h3 class="brand-text"></h3>
            </a>
            <h1 class="text-white">{{$job->name}} Interview</h1>
            <big class="text-white">{{$candidates->name}}, you have been selected for an Interview at UST Global!</big><br>
            <big class="text-white">Please select your prefered time from the available slots.</big>

            <!--<center>
			<br><br>
			 <a class="navbar-brand" href="http://pepdemo.westindia.cloudapp.azure.com">
				<img class="brand-logo" alt="modern admin logo" src="http://pepdemo.westindia.cloudapp.azure.com/assets/images/logo/logo.png">
				<h3 class="brand-text"></h3>
			  </a>
			</center>-->
        </div>
        <div id="slotpart" class="container">
            <h6 style="color: gray;margin-bottom: 15px;">SELECT YOUR SLOTS</h6><br>
            <div class="row">

                <div class="col-lg-4" id="calander">
                    <!--<input id="my-input" style="display: none;">
				<div id="my-datepicker"></div><br>-->
                    <div>
                        <small class="text-primary blueheader"><b>Job Description</b></small><br>
                        <i class="fa fa-download  text-secondary" onclick="CreateTextFile();" style="margin: 10px 0px;"></i><br>
                        <h5 style="font-weight: 700;margin-bottom: 0px;">{{$job->job_role}}</h5>
                        <!-- <span>at Gitlab</span><br>
					<small class="text-secondary">Remote</small> -->
                    </div>
                    <div class="description">
                        <p class="description-content">{{$job->description}}</p>
                        </p>
                    </div>
                </div>

                <div class="col-lg-3" id="availability">

                    <input id="my-input" style="display: none;">
                    <div id="my-datepicker"></div><br>

                    <small class="text-primary blueheader">Availability for <span class="selecteddateslist"></span></small><br>


                    <div class="time-picker">
                        <div class="tp-col tp-hr">
                            <img src="{{url('/')}}/assets/images/chevron-up-svgrepo-com.svg" class="tp-up-arrow" />
                            <span class="noselect" id="hour" tabindex="0*">00</span>
                            <img src="{{url('/')}}/assets/images/chevron-down-alt-svgrepo-com.svg" class="tp-down-arrow" />
                        </div>
                        <div class="tp-col">
                            <span>:</span>
                        </div>
                        <div class="tp-col tp-min">
                            <img src="{{url('/')}}/assets/images/chevron-up-svgrepo-com.svg" class="tp-up-arrow" />
                            <span tabindex="0" id="minute">00</span>
                            <img src="{{url('/')}}/assets/images/chevron-down-alt-svgrepo-com.svg" class="tp-down-arrow" />
                        </div>
                        <div class="tp-col">
                            <img src="{{url('/')}}/assets/images/chevron-up-svgrepo-com.svg" class="tp-up-arrow-merdian tp-am-pm" />
                            <span class="tp-am-pm" id="merdian">AM</span>
                            <img src="{{url('/')}}/assets/images/chevron-down-alt-svgrepo-com.svg" class="tp-down-arrow-merdian tp-am-pm" />
                        </div>
                        <div style="text-align: right;width: inherit;"><i class="fa fa-plus" id="addslottime"></i></div>
                    </div>


                </div>

                <div class="col-lg-5" id="selectedslots">
                    <small class="text-primary blueheader"><b>Selected Slots</b></small><br>
                    <!-- <div style="display:none;">
					<span data-toggle="modal" data-target="#myModal" class="pull-right" style="color: gray;"><i class="fa fa-edit"></i></span>
				</div> -->
                    <div class="container-scroll">
                        <div class="row">
                            <div style="display: flex;overflow: auto;" id="selectedslots-container">

                            </div>
                        </div>
                    </div>
                    <div id="commentssection">
                        <small>Comments for the Interviewer</small><br>
                        <table style="width: 100%;margin: 10px 0px;">
                            <tbody>
                                <tr>
                                    <td><textarea class="" name="newcomment" id="newcomment" placeholder="Add comments..." style="height: 73px;border-radius: 6px;border: 1px solid gainsboro;width: 100%;"></textarea></td>
                                    <!-- <td><button class="btn btn-success" id="addcomment"><span class="fa fa-plus text-white" style="height: 9px;font-size: 12px;"></span></button></td> -->
                                </tr>
                            </tbody>
                        </table>

                        <table style="margin: 10px 0px;">
                            <tbody id="commentstablebody">
                                <!--  -->
                            </tbody>
                        </table>
                        <!--<span class="comments">Lorem ipsum dolor sit amet, consectetur adipiscing </span><span class="comment-delete">x</span><br>-->
                    </div>

                    <div class="row">
                        <div class="col-lg-7"><button type="button" class="submitbtn" onclick="sendDataToController()">SUBMIT SLOTS</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            /*$("#my-datepicker").datepicker().on('changeDate', function (e) {
            	$("#my-input").val(e.format());
            	alert(e.format());
            });*/
            var dateToday = new Date();
            $('#my-datepicker').datepicker({
                format: 'dd-mm-yyyy',
                minDate: dateToday,
                multidate: true,
            });

            $("#my-datepicker").on("change", function() {
                var selected = $(this).val();
                alert(selected);
            });

            $("#addcomment").click(function() {
                var comment = $("#newcomment").val();
                if (comment == "") {
                    alert("No Comment Entered");
                } else {
                    $("#commentstablebody").append("<tr><td><span class='comments'>" + comment + " </span></td><td><span class='' onClick='delete_row(this)'>x</span></td></tr>");
                    $("#newcomment").val("");
                }
            });

        });

        function delete_row(e) {
            e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
        }

        function delete_datetime(elem) {
            document.getElementById(elem).remove();
        }

        $(document).ready(function() {
            $('.date').datepicker({
                multidate: true,
                format: 'dd-mm-yyyy'
            });

            $('#my-datepicker').on('changeDate', function(evt) {
                var selecteddates = $('#my-datepicker').datepicker('getDates');
                var selecteddateslist = ""
                const weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                const month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                if (selecteddates != "") {
                    selecteddates = String(selecteddates);
                    var selecteddatesarray = selecteddates.split(",");
                    var i;
                    for (i = 0; i < selecteddatesarray.length; ++i) {
                        var dateval = new Date(selecteddatesarray[i]);
                        selecteddateslist += (selecteddateslist == "") ? weekday[dateval.getDay()] + " " + month[dateval.getMonth()] + " " + dateval.getDate() : "," + weekday[dateval.getDay()] + " " + month[dateval.getMonth()] + " " + dateval.getDate();
                    }
                }
                $(".selecteddateslist").html(selecteddateslist);
            });

        });



        $("#addslottime").click(function() {
            var availabledates = $(".selecteddateslist").html();
            var hour = $("#hour").html();
            var minute = $("#minute").html();
            var merdian = $("#merdian").html();
            var fullhour = $(merdian == "PM") ? (Number(hour) + 12) : hour;
            var selectedhour = Number(String(fullhour) + String(minute));
            //alert(selectedhour);
            if (availabledates != "") {
                var selecteddates = $('#my-datepicker').datepicker('getDates');
                var selecteddateandslot = ""
                const weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                const month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                const minmonth = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                selecteddates = String(selecteddates);
                var selecteddatesarray = selecteddates.split(",");
                var i;
                var gapmsgs = "";
                for (i = 0; i < selecteddatesarray.length; ++i) {
                    var timeslots = "";
                    var dateval = new Date(selecteddatesarray[i]);
                    var slotcounter = 0;
                    var dateelementid = minmonth[dateval.getMonth()] + dateval.getDate() + dateval.getFullYear().toString().substr(-2);
                    //$(".checkbox-round").each(function(){
                    //if($(this).is(':checked'))
                    if (hour != "" && minute != "" && merdian != "") {
                        //var timeslotarr=$(this).val().split("-");
                        //alert(timeslotarr[0]);
                        var timeelementid = minmonth[dateval.getMonth()] + dateval.getDate() + dateval.getFullYear().toString().substr(-2) + hour + minute + merdian;
                        var timeelementclass = dateval.getDate() + minmonth[dateval.getMonth()] + dateval.getFullYear().toString().substr(-2);
                        if ($("#" + timeelementid).length == 0) {
                            var error = 0;
                            if ($("#" + dateelementid).length != 0) {
                                $("#" + dateelementid + " .timelist").each(function() {
                                    var presenttime = Number($(this).val());
                                    //alert(selectedhour+"-"+(presenttime+100)+"-"+(presenttime-100));
                                    if ((selectedhour < (Number(presenttime + 100))) && (selectedhour > (Number(presenttime - 100)))) {
                                        gapmsgs += (gapmsgs == "") ? dateval.getDate() + " " + minmonth[dateval.getMonth()] + " " + dateval.getFullYear().toString().substr(-2) : "," + dateval.getDate() + " " + minmonth[dateval.getMonth()] + " " + dateval.getFullYear().toString().substr(-2);
                                        error = 1;
                                    }
                                });
                            }

                            if (error == 0) {
                                timeslots += '<div id="' + timeelementid + '" class="' + timeelementclass + '"><span class="selection-times">' + hour + ":" + minute + " " + merdian + '</span><span class="time-delete" onclick=delete_datetime("' + timeelementid + '")>x</span><br><input type="hidden" class="timelist" value="' + fullhour + minute + '"></div>';
                            }

                        } else {
                            alert("Time Slot Already Selected");
                            return false;
                        }
                        slotcounter++;
                    }

                    //});
                    if (slotcounter == 0) {
                        alert("Please Select Slot");
                        return false;
                    }

                    //alert($("#"+dateelementid).length);
                    selecteddateandslotstart = '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding: 10px 0px 0px 0px;" id="' + dateelementid + '">';
                    selecteddateandslot = '<div><span class="selected-dates">' + dateval.getDate() + " " + minmonth[dateval.getMonth()] + " " + dateval.getFullYear().toString().substr(-2) + '</span><span class="date-delete" onclick=delete_datetime("' + dateelementid + '")>x</span><hr></div>' + timeslots;
                    selecteddateandslotend = '</div>';
                    if ($("#" + dateelementid).length == 0) {
                        $("#selectedslots-container").append(selecteddateandslotstart + selecteddateandslot + selecteddateandslotend);
                    } else {
                        //$("#"+dateelementid).append(selecteddateandslot);
                        $("#" + dateelementid).append(timeslots);
                    }
                }

                if (gapmsgs != "") {
                    alert("Slot selection time interval should have a hour gap on " + gapmsgs);
                }

            } else {
                alert("Please Select Date");
            }
            $('#my-datepicker').val("").datepicker("update");
            $(".selecteddateslist").html("");
        })

        $(document).ready(function() {
            var c_time = ct(new Date());
            var hr = parseInt(c_time.split(':')[0]);
            var min = parseInt(c_time.split(':')[1]);
            var meridiem = c_time.split(':')[2];
            $('.tp-min>span').html(min < 10 ? '0' + min : min);
            $('.tp-hr>span').html(hr);
            $('.tp-am-pm').html(meridiem);
            $('.tp-hr>.tp-up-arrow').click(function() {
                hr = parseInt($('.tp-hr>span').html());
                hr = (hr == 1 ? 12 : hr -= 1);
                $('.tp-hr>span').html(hr);
            });
            $('.tp-min>.tp-up-arrow').click(function() {
                min = parseInt($('.tp-min>span').html());
                min = (min == 00 ? 59 : min -= 1);
                $('.tp-min>span').html(min < 10 ? '0' + min : min);
            });
            $('.tp-hr>.tp-down-arrow').click(function() {
                hr = parseInt($('.tp-hr>span').html());
                hr = (hr == 12 ? 1 : hr += 1);
                $('.tp-hr>span').html(hr);
            });
            $('.tp-min>.tp-down-arrow').click(function() {
                min = parseInt($('.tp-min>span').html());
                min = (min == 59 ? 00 : min += 1);
                $('.tp-min>span').html(min < 10 ? '0' + min : min);
            });
            $('.tp-am-pm').click(function() {
                meridiem = meridiem == 'AM' ? 'PM' : 'AM';
                $('.tp-am-pm').html(meridiem);
            });
            $('.tp-hr').on('wheel', function(event) {
                var oEvent = event.originalEvent,
                    delta = oEvent.deltaY || oEvent.wheelDelta;
                if (delta > 0) {
                    hr = (hr == 12 ? 1 : hr += 1);
                } else {
                    hr = (hr == 1 ? 12 : hr -= 1);
                }
                $('.tp-hr>span').html(hr);
            });
            $('.tp-min').on('wheel', function(event) {
                var oEvent = event.originalEvent,
                    delta = oEvent.deltaY || oEvent.wheelDelta;
                if (delta > 0) {
                    min = (min == 59 ? 00 : min += 1);
                } else {
                    min = (min == 00 ? 59 : min -= 1);
                }
                $('.tp-min>span').html(min < 10 ? '0' + min : min);
            });
            $(".tp-hr>span").click(function() {
                this.focus();
                $('.tp-hr>span').html('&nbsp;');
                $(this).keyup(function(e) {
                    console.log(e.keyCode);
                    $('.tp-hr>span').html();
                    if (/[0-9]/.test(e.key)) {
                        var cVal = $('.tp-hr>span').html();
                        if (cVal == '&nbsp;') {
                            $('.tp-hr>span').html(e.key);
                        } else {
                            if (cVal == 0) {
                                $('.tp-hr>span').append(e.key);
                                exitHr(this, $(this));
                            } else if (cVal == 1) {
                                if (/[0-2/]/.test(e.key)) {
                                    $('.tp-hr>span').append(e.key);
                                    exitHr(this, $(this));
                                } else {
                                    $('.tp-hr>span').html(e.key);
                                }
                            } else {
                                $('.tp-hr>span').html(e.key);
                            }
                        }
                    } else if ((/13|9/.test(e.keyCode)) || (/:/.test(e.key))) {
                        exitHr(this, $(this));
                    }
                });
            });

            $(".tp-min>span").click(function() {
                this.focus();
                $('.tp-min>span').html('&nbsp;');
                $(this).keyup(function(e) {
                    $('.tp-min>span').html();
                    if (/[0-9]/.test(e.key)) {
                        var cVal = $('.tp-min>span').html();
                        if ((cVal == '&nbsp;') && (/[0-5]/.test(e.key))) {
                            $('.tp-min>span').html(e.key);
                        } else {
                            $('.tp-min>span').append(e.key);
                            exitMin(this, $(this));
                        }
                    } else if ((/13|9/.test(e.keyCode)) || (/:/.test(e.key))) {
                        exitMin(this, $(this));
                    }
                });
            });
            $('.tp-hr>span').blur(function() {
                var a = $('.tp-hr>span').html();
                if ((a == '') || (a == '&nbsp;')) {
                    var hr = parseInt(ct(new Date()).split(':')[0]);
                    $('.tp-hr>span').html(hr);
                }
            });
            $('.tp-min>span').blur(function() {
                var a = $('.tp-min>span').html();
                if ((a == '') || (a == '&nbsp;')) {
                    var min = parseInt(ct(new Date()).split(':')[1]);
                    $('.tp-min>span').html(min);
                }
            });
        });

        function exitHr(a, b) {
            a.blur();
            b.off('keyup');
            $(".tp-min>span").trigger("click");
        }

        function exitMin(a, b) {
            a.blur();
            b.off('keyup');
        } 

        function ct(date) {
            var hrs = date.getHours();
            var mns = date.getMinutes();
            var mer = hrs >= 12 ? 'PM' : 'AM';
            hrs = hrs % 12;
            hrs = hrs ? hrs : 12;
            mns = mns < 10 ? '0' + mns : mns;
            return (hrs + ':' + mns + ':' + mer);
        }

        function CreateTextFile() {
            var descriptions = document.getElementsByClassName("description-content");
            var content = "";
            for (var i = 0; i < descriptions.length; i++) {
                content += descriptions[i].innerHTML + "\n";
            }
            var blob = new Blob([content], {
                type: "text/plain;charset=utf-8",
            });
            saveAs(blob, "Job_Description.txt");
        }
        // Function to extract and send date and time data to Laravel controller
        // Declare the dateAndTimePairs array at a higher scope, such as at the beginning of your script
        let dateAndTimePairs = [];

        // Function to extract and send date and time data to Laravel controller
        function sendDataToController() {
            var selecteddates = document.getElementsByClassName("selected-dates");
            var selecteddatecontent = "";
            var selecteddateandtime = "";
            for (var i = 0; i < selecteddates.length; i++) {
                selecteddatecontent = selecteddates[i].innerHTML.replaceAll(" ", "");
                selecteddatecontentoriginal = selecteddates[i].innerHTML;

                selecteddateandtime += (selecteddateandtime == "") ? selecteddatecontentoriginal : "~" + selecteddatecontentoriginal;

                var selectedtimes = document.getElementsByClassName(selecteddatecontent);
                //alert(selectedtimes.length);
                var selectedtimecontent = "";
                for (var j = 0; j < selectedtimes.length; j++) {
                    selectedtimecontent += (selectedtimecontent == "") ? selectedtimes[j].textContent.slice(0, -1) : "|" + selectedtimes[j].textContent.slice(0, -1);
                }

                selecteddateandtime += "-" + selectedtimecontent;
            }

            console.log(selecteddateandtime);
            $.ajax({
                url: "{{ URL::route('storeData', $candidates->cuid) }}",
                dataType: 'json',
                type: 'POST',
                data: {
                    selectedDateTimes: selecteddateandtime,
                    candidate_id: "{{ $candidates->id }}",
                    job_id: "{{ $job->id }}",
                    organization_id: "{{ $candidates->organization_id }}",
                    user_id: "{{ $candidates->user_id }}",
                    comment: $("#newcomment").val(),
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    console.log(response)
                    if (response.status) {
                        window.location.href = response.redirect_url;
                        // swal("Success", "Your profile has been updated successfully", "success");
                        // setTimeout(function() {
                        // 	window.location.href = response.redirect_url;
                        // }, 2000);
                    }
                },
                error: function(response) {

                    console.log('inside ajax error handler');
                }
            });
        }
    </script>
</body>

</html>