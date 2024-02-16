            @if(!$candidates->isEmpty())
              @foreach($candidates as $ck)
                  <a href="{{ url('profile/' . $ck->cuid) }}">
                  <div class=" @if($ck->holdstat) organization-hold @endif modal-profileblock filecount resumeli resumeli_{{$ck->id}}">
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

                  @if(!$ck->skills->isEmpty())
						<?php $maxc = 1; ?>
                    @foreach($ck->skills as $mk)
						<?php if($maxc <6){ ?>
                      <span>{{$mk->name}}</span>
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
                    <div id="revert_{{$ck->id}}" @if(!$ck->holdstat) class="add-resource" data="{{url('/profile/addtojob/'.$ck->id)}}" @else class="remove-resource" data="{{url('/profile/removefromjob/'.$ck->id)}}" @endif data-id="{{$ck->id}}">
                      <img data-toggle="tooltip" data-placement="top" title="" data-original-title="Add to job" src="assets/images/icons/p-add-icon.png">
                    </div>
                  </div>
                </a>
                @endforeach

              @else

              <p class="alert alert-warning text-center">No matching profile</p>

              @endif
