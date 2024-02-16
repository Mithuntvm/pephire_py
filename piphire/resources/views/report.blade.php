<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    .btn {
      background-color: DodgerBlue;
      border: none;
      color: white;
      padding: 4px 20px;
      cursor: pointer;
      font-size: 20px;
    }
    .btn:hover {
  background-color: RoyalBlue;
}

        input.custom-control-input {
            width: 20px;
            height: 20px;
        }
    </style>
   
</head>
<body style="background-color: aliceblue;">

<div class="container" >
  <h2 style="text-align: center;">Report</h2>
  <table class="table table-bordered" style="border-collapse: collapse;
  border: 1px solid black;">
    <thead>
        <tr>
            
            <th scope="col">JDID</th>
            <th scope="col">Job Description</th>
            <th scope="col">Candidate Name</th>
            <th scope="col">Experience</th>
            <th scope="col">CTC</th>
            <th scope="col">Location</th>
            <th scope="col">Notice Period</th>
            <th scope="col">Score</th>
            <th scope="col">Stage</th>
            <th scope="col" style="width: 20px;">Download</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($candidates as $ck)
        <tr>
            <td>
                {{ $ck->job_id }}
            </td>
            <td> hi</td>
            <td> {{ $ck->name }}</td>
            <td> {{ $ck->experience }}</td>
            <td> {{ $ck->offered_ctc }}</td>
            <td> {{ $ck->location }}</td>
            <td> {{ $ck->notice_period }}</td>
            <td> {{ $ck->score }}</td>
            <td> stage</td>

            

            
            <td><div class="checkbox-block">
                                                    <input class="profile_check"
                                                       data="{{ url('/resume/download/' . $ck->resume_id) }}"
                                                        id="checkblock_{{ $ck->id }}" type="checkbox"
                                                        name="resume[]" value="{{ $ck->id }}">
                                                    <label for="checkblock_{{ $ck->id }}"></label>
                                                </div></td>
        </tr>
        @endforeach
        
                <tr>
            <td colspan="9"></td>
            <td>
                <button class="btn"><i class="fa fa-download"></i> Download</button>
            </td>
        </tr>
    </tbody>
</table>
</div>

</body>
</html>
