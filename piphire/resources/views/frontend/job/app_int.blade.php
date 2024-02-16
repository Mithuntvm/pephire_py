@extends('layouts.app')

@section('header')
@include('partials.frontend.header')
@endsection

@section('content')

@section('sidebar')
@include('partials.frontend.sidebar')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src=https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js></script>

<script src=https://code.jquery.com/jquery-3.6.0.min.js></script>
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
<script src="{{url('/')}}/assets/vendors/js/extensions/jquery.knob.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/js/scripts/extensions/knob.js" type="text/javascript"></script>

<script src="{{url('/')}}/app-assets/js/scripts/forms/validation/jquery.validate.min.js" type="text/javascript"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

<style>
	#rcorners2 {

		float: right;
		margin: 5px;
		padding: 2px 8px;
		color: #8097b1;
		border: 1px solid #8097b1;
		border-radius: 100px;
		font-size: 10px;

	}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>

<script>
	$(".skills").select2({
		placeholder: 'Enter Skills',
		minimumInputLength: 2,
		allowClear: true,
		ajax: {
			url: "/skill/autocomplete",
			dataType: 'json',
			delay: 500,
			data: function(params) {
				return {
					term: params.term, // search term
				};
			},
			processResults: function(data, params) {
				return {
					results: $.map(data, function(skill) {
						return {
							id: skill.name,
							text: skill.name
						};
					})
				};
			},
			cache: true,
		}
	});



	$(document).ready(function() {
		$('.knob').trigger('configure', {
			max: 100,
			thickness: 0.1,
			fgColor: '#2CC2A5',
			width: 50,
			height: 50
		});

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		setTimeout(function() {
			$("#alert_message").hide();
		}, 10000);
	});

	$(document).on('click', ".active-color", function() {
		//if(!$(this).children('.icon-box').children('.color-icon').hasClass('rec_color')){
		$(this).children('.icon-box').children('.color-icon').click();
		//}
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.fitment-form .form-control').on('keyup', function() {
			if ($(this).val().trim() != '') {
				$(this).attr('data-valid', 'valid');
			} else {
				$(this).removeAttr('data-valid');
			}
		});
		$("#updatejobdetails").validate({
			rules: {
				jobtitle: {
					required: true
				},
				jobdescription: {
					required: true
				},
				joining_date: {
					required: true
				},
				max_experience: {
					required: true,
					// min: 0
				},
				min_experience: {
					required: true,

				},
				location: {
					required: true
				},
				job_role: {
					required: true
				},
				// job_role_category: {
				// 	required : true
				// },
				offered_ctc: {
					required: true,
					min: 0
				}
			},
			messages: {
				jobtitle: {
					required: "Please enter job title"
				},
				jobdescription: {
					required: "Please enter description of your job"
				},
				joining_date: {
					required: "Please enter Joining Date"
				},
				max_experience: {
					required: "Please enter Max Experience",
					min: "Please enter a number greater than or equal to 0"
				},
				min_experience: {
					required: "Please enter Min Experience",
					// min: "Please enter a number greater than or equal to 0"
				},
				location: {
					required: "Please enter Location"
				},
				job_role: {
					required: "Please enter Job Role"
				},
				offered_ctc: {
					required: "Please enter Offered CTC",
					min: "Please enter a number greater than or equal to 0"
				}
			},
		});

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	});
</script>

<script type="text/javascript">


</script>

<script type="text/javascript">
	$(document).ready(function() {

		$("#job_role").select2({
			placeholder: 'Select Job Role',
			allowClear: true,
		});

		$("#job_role_category").select2({
			placeholder: 'Select Job Role Category',
			allowClear: true,
		});


		$("#joining_date").flatpickr({
			// minDate: new Date(),
			minDate: "today",
		});

	});
</script>

@if(Session::has("warningAlert"))
<script type="text/javascript">
	jQuery(document).ready(function() {
		swal("Alert", '{{ Session::get("warningAlert") }}', "error");
	});
</script>
@endif

@endpush

<div class="app-content content">
	<div class="content-wrapper">



		<div class="content-header row">
		</div>
		<div class="content-body">
			<div class=" " style="display: flex;"><button style="background-color: #fff; color: #3498db; padding: 10px; border: none; cursor: pointer; border-radius: 10px;" onclick="review()">
					Submit Form &nbsp; <b><i class="fa fa-chevron-right" style="font-size: 20px;vertical-align: middle;"></i></b>
				</button> 
				
				 <button style="background-color: #438ec8; color: #fff; padding: 10px; border: none; cursor: pointer; border-radius: 10px; width: 100px;margin-left:10px;" onclick=app_create(event)>
									<i class="fa fa-upload"></i> Publish
								</button></div>
								<div class="alert-box success">Successful !!!</div>
							<div class="alert-box failure">Failure !!!</div>
			<!-- Revenue, Hit Rate & Deals -->
			<form method="post" enctype="multipart/form-data" id="jobapp">
				@csrf
				<div class="row">
					<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
						<div class="common-section">
							<div class="common-form fitment-form">

								<div class="form-section">
									<label class="control-label">Job title</label>
									<input class="form-control " type="text" id="jobtitle" name="jobtitle" placeholder="Add Job Title here" value="">
									<img src="{{url('/')}}/assets/images/icons/tick.png">
								</div>
								<div class="form-section">
									<label class="control-label">Job description</label>
									<textarea class="form-control " type="text" placeholder="Add Job Description here" id="jobdescription" name="jobdescription" rows="10"></textarea>
									<img src="{{url('/')}}/assets/images/icons/tick.png">
								</div>

								<div class="form-section">
									<div class="row">
										<div class="col-md-6">
											<label class="control-label">Joining Date</label>
											<input class="form-control" type="text" id="joining_date" name="joining_date" placeholder="Joining Date" value="" required>
											<!-- <img src="{{url('/')}}/assets/images/icons/tick.png"> -->
										</div>
										<div class="col-md-6">
											<label class="control-label">Location</label>
											<input class="form-control " type="text" id="location" name="location" placeholder="Location" value="">
											<img src="{{url('/')}}/assets/images/icons/tick.png" style="margin-right: 5%">
										</div>
									</div>
								</div>
								<div class="form-section">
									<div class="row">
										<div class="col-md-6">
											<label class="control-label">Min Experience</label>
											<input class="form-control " type="number" id="min_experience" name="min_experience" placeholder="Min Experience" oninput="this.value = Math.abs(this.value)" required>
											<img src="{{url('/')}}/assets/images/icons/tick.png" style="margin-right: 5%">
										</div>
										<div class="col-md-6">
											<label class="control-label">Max Experience</label>
											<input class="form-control" type="number" id="max_experience" name="max_experience" placeholder="Max Experience" value="" oninput="this.value = Math.abs(this.value)">
											<img src="{{url('/')}}/assets/images/icons/tick.png" style="margin-right: 5%">
										</div>

									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
						<div class="common-section">
							<div class="common-form fitment-form">

								<div class="form-section">
									<label class="control-label">Job Role</label>
									<select class="form-control" name="job_role" id="job_role">
										<option value=""> -- Select Job Role -- </option>
										@foreach($job_roles as $job_role)
										<option value="{{ $job_role }}">
											{{ ucfirst($job_role) }}
										</option>
										@endforeach
									</select>
									<img src="{{url('/')}}/assets/images/icons/tick.png">
								</div>
								<div class="form-section">
									<label class="control-label">Company Logo (choose file)</label>
									<input class="form-control" type="file" id="company_logo" name="company_logo">
								</div>

								<div class="form-section">
									<label class="control-label">Company Name</label>
									<input class="form-control" type="text" id="company_name" name="company_name" placeholder="Add Company Name here">
								</div>
								<div class="form-section">
									<label class="control-label">Company Details</label>
									<textarea class="form-control" id="company_details" name="company_details" placeholder="Add Company Details here"></textarea>
								</div>
								<div class="form-section">
									<div class="row">

										<div class="col-md-6">
											<label class="control-label">Offered CTC</label>
											<input class="form-control" type="number" id="offered_ctc" name="offered_ctc" placeholder="Offered CTC" value="" oninput="this.value = Math.abs(this.value)">
											<img src="{{url('/')}}/assets/images/icons/tick.png" style="margin-right: 5%">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">

						<div class="common-section">
							

							<div style="text-align:center;">
								
							</div>

							<div id="preview-section">

								<div id="mobile-frame" style="position: fixed; top:140px; z-index: 1000;">
								

									<div id="mobile-header" style="display: flex; align-items: center; justify-content:  flex-start;">
										<div id="back-arrow" onclick="closeMobilePreview"><i class="fa fa-arrow-left" aria-hidden="true"></i></div>
										<div id="job-title">Jobs</div>
									</div>
									<div class="input-group rounded" id="search_job">
										<input type="search" class="form-control rounded" placeholder="Search Jobs" aria-label="Search" aria-describedby="search-addon" />
									</div>
									<div id="preview-card">
										<div id="job-details">
											<div id="company-logo">
												<img src="{{url('/')}}/assets/images/logo/company_logo.jpg" name="preview-image" id="preview-image" alt="image"> <!-- Show the selected company logo -->
											</div>
											<div style="margin-left: 8px;">
												<div id="job-title-text" style="">Job title...</div>
												<div id="timestamp">Company Name...</div> <!-- Replace "UST" with the entered company name -->
											</div>
										</div>
										<div id="job-description" style="font-size: 9px;"></div>
									</div>
									<div class="bottom-buttons" style="display: flex;justify-content: space-evenly;position: absolute;bottom: 5px;width: 100%;">
										<span class="fa fa-square"></span>
										<span class="fa fa-dot-circle-o"></span>
										<span class="fa fa-caret-left" style="font-size: 20px;"></span>
									</div>

								</div>

							</div>


						</div>
					</div>
				</div>
			</form>

		</div>
	</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->
<!-- Add these styles to your existing stylesheet or in a style tag in the head -->
<!-- Add these styles to your existing stylesheet or in a style tag in the head -->
<style>
	#preview-section {
		margin-top: 0px;
		padding: 20px;
		/* border: 1px solid #ddd;
		border-radius: 10px;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); */
	}

	#mobile-frame {
		width: 320px;
		height: 500px;
		background-color: #fff;
		border: 3px solid #33333394;
		border-radius: 15px;
		overflow: hidden;
		box-shadow: #33333394;
	}

	#mobile-header {
		background-color: #438ec8;
		color: #fff;
		padding: 10px;
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	#back-arrow {
		font-size: 20px;
		cursor: pointer;
	}

	#job-title {
		font-size: 18px;
		margin-left: 10px;
	}

	#search-bar {
		display: flex;
		align-items: center;
		margin-top: 10px;
	}

	#search-icon {
		margin-right: 10px;
		color: #333;
	}

	#search-input {
		flex: 1;
		border: none;
		border-bottom: 2px solid #3498db;
		outline: none;
		padding: 5px;
	}

	#preview-card {
		margin-top: 20px;
		margin: 0 15px;
		padding: 10px;
		/*margin-left: 24px;*/
		border: 1px solid #ddd;
		/* border-radius: 10px; */
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
	}

	#company-logo {

		border-radius: 50%;

	}

	#preview-image {
		height: 40px;
		width: 40px;
		object-fit: cover;
		border-radius: 20px;
	}

	#job-details {
		display: flex;
		align-items: center;
		margin-bottom: 10px;
	}

	#job-title-text {
		/* font-weight: bold; */
		margin-right: 5px;
		font-size: 12px;
		color: #888;
	}

	#timestamp {
		color: #888;
		margin-right: 5px;
		font-size: 12px;
	}

	#job-description {
		margin-top: 10px;
		line-height: 1.2em;
		/* Adjust line height as needed */
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		/* Number of lines to show */
		-webkit-box-orient: vertical;
	}

	.common-section {
		padding: 30px;
	}
</style>

<!-- Add this script after your existing script -->
<script>
	function review() {
		// Trigger the updatePreview function
		updatePreview();

		// Show the mobile preview
		document.getElementById('mobile-frame').style.display = 'block';
		document.getElementById('preview-section').style.display = 'block';

	}

	// Get the input and image elements
	const imageInput = document.getElementById('company_logo');
	const previewImage = document.getElementById('preview-image');

	// Listen for changes in the file input
	imageInput.addEventListener('change', function() {
		const file = imageInput.files[0];

		if (file) {
			// Use FileReader to read the selected file
			const reader = new FileReader();

			reader.onload = function(e) {
				// Set the source of the preview image to the loaded image data
				previewImage.src = e.target.result;
			};

			// Read the file as a data URL
			reader.readAsDataURL(file);
		} else {
			// If no file is selected, reset the preview image
			previewImage.src = '#';
		}
	});

	function updatePreview() {
		// Get values from form fields
		var jobTitle = document.getElementById('jobtitle').value;
		var jobDescription = document.getElementById('jobdescription').value;
		var joiningDate = document.getElementById('joining_date').value;
		var location = document.getElementById('location').value;
		var minExperience = document.getElementById('min_experience').value;
		var maxExperience = document.getElementById('max_experience').value;
		var offeredCTC = document.getElementById('offered_ctc').value;
		var jobRole = document.getElementById('job_role').value;
		var companyName = document.getElementById('company_name').value; // Added to get the entered company name
		var companyLogo = document.getElementById('company_logo').value; // Added to get the selected company logo file
		var lines = jobDescription.split('\n');

		// Get the first two lines
		var firstTwoLines = lines.slice(0, 2).join('<br>');

		// Get the rest of the lines
		var remainingLines = lines.slice(2);

		// Display the first two lines with ellipsis if there are remaining lines
		var displayText = remainingLines.length > 0 ? firstTwoLines + '...' : firstTwoLines;

		// Display in the job-description element
		document.getElementById('job-description').innerHTML = displayText;
		document.getElementById('timestamp').innerHTML = companyName + ' <span style="font-size: 9px;">. Just now</span>';
		document.getElementById('job-title-text').innerHTML = jobRole;
		document.getElementById('job-description').innerHTML = jobDescription;



	}

	// Call the updatePreview function whenever the form fields change
	document.getElementById('jobtitle').addEventListener('input', updatePreview);
	document.getElementById('company_name').addEventListener('input', updatePreview);
	document.getElementById('jobdescription').addEventListener('input', updatePreview);
	document.getElementById('joining_date').addEventListener('input', updatePreview);
	document.getElementById('location').addEventListener('input', updatePreview);
	document.getElementById('min_experience').addEventListener('input', updatePreview);
	document.getElementById('max_experience').addEventListener('input', updatePreview);
	document.getElementById('offered_ctc').addEventListener('input', updatePreview);
	document.getElementById('job_role').addEventListener('change', updatePreview);
	document.getElementById('company_logo').addEventListener('change', updatePreview);

	function closeMobilePreview() {
		// Hide the mobile preview section
		document.getElementById('mobile-frame').style.display = 'none';
	}
</script>


<style type="text/css">
	/* Add this CSS to customize the preview-section for mobile view */

	#mobile-frame {
		width: 290px;
		height: 67vh;
		background-color: #fff;
		border: 3px solid #33333394;
		border-radius: 15px;
		overflow: hidden;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
		position: relative;
	}

	#preview-section {
		padding: 20px;
	}

	.common-section {
		padding: 30px;
	}

	#search_job {
		/*margin-top: 10px;*/
		width: 90%;
		margin: 5%;
		/*margin-left: 30px;*/
	}

	#mypreload {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		/*background: url("{{url('/assets/images/Blocks-1s-200px.gif')}}") 50% 50% no-repeat rgb(249,249,249);*/
		opacity: .8;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		background: rgba(255, 255, 255, 0.55)
	}

	#mypreload .nb-spinner {
		width: 75px;
		height: 75px;
		margin: 0;
		background: transparent;
		border-top: 4px solid #2E5BFF;
		border-right: 4px solid transparent;
		border-radius: 50%;
		-webkit-animation: 1s spin linear infinite;
		animation: 1s spin linear infinite;
		position: relative;
		z-index: 999;
	}

	#mypreload span {
		position: relative;
		top: -20px;
		color: #000;
		font-size: 24px;
		z-index: 99;
	}

	#ext_skills {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		/*background: url("{{url('/assets/images/Blocks-1s-200px.gif')}}") 50% 50% no-repeat rgb(249,249,249);*/
		opacity: .8;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		background: rgba(255, 255, 255, 0.55)
	}

	#ext_skills .nb-spinner {
		width: 75px;
		height: 75px;
		margin: 0;
		background: transparent;
		border-top: 4px solid #2E5BFF;
		border-right: 4px solid transparent;
		border-radius: 50%;
		-webkit-animation: 1s spin linear infinite;
		animation: 1s spin linear infinite;
		position: relative;
		z-index: 999;
	}

	#ext_skills span {
		position: relative;
		top: -20px;
		color: #000;
		font-size: 24px;
		z-index: 99;
	}



	.success {

		color: #3c763d;

		background-color: #dff0d8;

		border-color: #d6e9c6;

		display: none;

	}



	.failure {

		color: #a94442;

		background-color: #f2dede;

		border-color: #ebccd1;

		display: none;

	}
</style>

<script>
	function app_create(event) {
    event.preventDefault();
    console.log('jjjjjjj');

    var formData = new FormData(); // Use FormData to handle file uploads

    formData.append('company_logo', $('#company_logo')[0].files[0]); // Append the file to the FormData object

    // Add other form data to the FormData object
    formData.append('frm', $("#jobapp").serialize());

    $("#ext_skills").show();

    $.ajax({
        url: "{{ url('/app/jobs') }}",
        type: 'post',
        data: formData,
        processData: false, // Don't process the data
        contentType: false, // Don't set content type

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function (response) {
			$("#jobapp")[0].reset();
            $("#ext_skills").hide();
            // $('.success').fadeIn(300).delay(1500).fadeOut(400);
        },

        error: function (xhr, status, error) {
			$("#jobapp")[0].reset();
            console.log('Error:', error);
            $("#ext_skills").hide();
            // $('.failure').fadeIn(300).delay(1500).fadeOut(400);
        }
    });
}
</script>
<div id="ext_skills" style="display: none;">
	<span style="">Publishing</span>
	<div class="nb-spinner"></div>
</div>



@section('footer')
@include('partials.frontend.interview')
@endsection
@endsection

@section('footer')
@include('partials.frontend.footer')
@endsection