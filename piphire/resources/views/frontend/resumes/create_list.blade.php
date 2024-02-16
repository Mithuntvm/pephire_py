
<style>
  #rcorners2 {
  /* border-radius: 25px;
  border: 1px solid #73AD21; */
  /* padding: 1px; 
  border: 1px solid #8097b1;
    border-radius: 100px;
  width: auto;
  height: auto;  
  font-size: 10px; */
  float: right;
  /* text-align: right; */
  margin: 5px;
    /* display: inline-block; */
    padding: 2px 8px;
    color: #8097b1;
    border: 1px solid #8097b1;
    border-radius: 100px;
    font-size: 10px;
    
}

/* input[type=checkbox] {
display:none;
}
input[type=checkbox] + label
{
background: #999;
height: 16px;
width: 16px;
display:inline-block;
padding: 0 0 0 0px;
}
input[type=checkbox]:checked + label
{
background: #0080FF;
text-decoration: line-through;
height: 16px;
width: 16px;
display:inline-block;
padding: 0 0 0 0px;
}
input[type=checkbox]:checked + label + label {
    text-decoration: line-through;
}


label p {
  display: inline block;
} */
/* #qwe
{
 
} */

</style>
<?php $cnt = 1; ?>


@if( $resumes )
@foreach($resumes as $val)
  <li class="resumeli_{{$val->id}} filecount">
    <?php
     $skills=explode(',',$val->skills);
    ?> 
    <span>{{$cnt}}</span>

    <?php $username = ($val->candidate->name != '') ? $val->candidate->name : $val->resume->name ?>

    <?php $string = (strlen($username) > 20) ? substr($username,0,15).'...' : $username; ?>
    <span>{{$string}}</span>
    
    	<!-- <input id="selectallblock" type="checkbox" name="selectall">
										<label for="selectallblock"><span>Select All</span></label>
									</span>
									<span><a href="" onclick="deleteSelected()">Not Interested</a></span>
								</h4> -->
  
    <span>
    <!-- <input type="checkbox" id="thing" name="thing" value="" onClick="this.checked=!this.checked;">
    <label for="selectallblock"><span>Select All</span></label> -->
    <!-- <input id="selectlock" type="checkbox" name="selecll">
										<label for="selectallblock"><span></span></label> -->

      <img data-id="{{$val->id}}" data="{{url('/hold/delete/'.$val->id)}}" class="del-resource" src="{{url('/')}}/assets/images/icons/delete-icon.png">
    </span>
  </li>
  
  <!-- {{$val->skills}} -->
<?php $cnt++; ?>	
@endforeach
@else

<p class="alert alert-warning text-center">No records found.</p>

@endif