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
    
      .column {
  float: left;
  width: 25%;
  padding: 0 10px;
}

/* Remove extra left and right margins, due to padding */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 10px;
  text-align: center;
  background-color: #f1f1f1;
  margin-top:4px;
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
        
            <p style="
               margin: 0 0 20px 0;
               font-size: 18px;
               display: inline-block;
               ">Hi,</p>
              <p>There is an error with attribution api for the following resumes</p><br/>
             
              <?php
               foreach ($deletecandidates as $deletecandidate) {
               

                           ?>
                           
  
    <div class="card">
                              
               {{$deletecandidate->delresume->name}}
               </div>
              
              
                           <?php
               }
              ?>
              <br>
               <br>
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

</body>

</html>