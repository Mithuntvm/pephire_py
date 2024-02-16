@if(!$candidates->isEmpty())
@foreach($candidates as $ck)
<a id="revert_{{$ck->id}}" href="{{ url('profile/' . $ck->cuid) }}">
  <div class="profile-list-db modal-profileblock filecount resumeli resumeli_{{ $ck->id }}">
    <div>
      <div class="avatar-image">
        <span>
          @if($ck->photo == '' && ($ck->sex =='' || $ck->sex =='None'))
          <img class="rounded-circle" src="{{url('/')}}/assets/images/candiate-img.png">
          @elseif($ck->photo == '' && $ck->sex =='Male')
          <img class="rounded-circle" src="{{url('/')}}/assets/images/male-user.png">
          @elseif($ck->photo == '' && $ck->sex =='Female')
          <img class="rounded-circle" src="{{url('/')}}/assets/images/woman.png">
          @else
          <img class="rounded-circle" src="{{ asset('storage/' . $ck->photo) }}">
          @endif
        </span>
      </div>
    </div>
    <div>
      <p>{{$ck->name}}</p>
      <p></p>
      <p><span>Experience:</span> <span>{{$ck->experience}} yrs</span></p>
      <p>{{ \Carbon\Carbon::parse($ck->created_at)->format('d-M-Y') }}</p>
    </div>
    <div>

      @if(count(explode(',',$ck->skills)) != 0)
      <?php $maxc = 1; ?>
      @foreach(explode(',',$ck->skills) as $mk)
      <?php if ($maxc < 6) { ?>
        <span>{{$mk}}</span>
      <?php } ?>
      <?php $maxc++; ?>
      @endforeach
      @else
      <span>No skills</span>
      @endif


    </div>
    <div>
      <p></p>
    </div>
    <div>
      <p></p>
      <p></p>
    </div>

    <div class="checkbox-block">
      <input class="profile_check" data="{{url('/resume/delete/'.$ck->resume_id)}}" id="checkblock_{{$ck->id}}" type="checkbox" name="deleteprofile[]" value="{{$ck->id}}">
      <label for="checkblock_{{$ck->id}}"></label>
    </div>


  </div>
</a>
@endforeach




@endif