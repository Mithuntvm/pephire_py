@extends('layouts.auth')

@push('scripts')
  <script src="{{url('/')}}/app-assets/js/scripts/forms/validation/jquery.validate.min.js" type="text/javascript"></script>

  <script type="text/javascript">
    
      $(document).ready(function(){
        $("#orgcreate").validate({
              rules: {
                name: {
                  required : true
                },
                email: {
                  required : true,
                  email : true,
                  remote: {
                    url: "{{url('/checkemailexist')}}",
                    type: "post",
                    data: {
                      email: function(){ return $("#email").val(); }
                    }
                  }                  
                }
              },
              messages: {
                name: {
                  required : "Please enter your name"
                },
                email: {
                  required : "Please enter email",
                  email : "Please enter valid email",
                  remote : "This email is already in use with another organization/user"
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
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">

            @if(session()->has('success'))  
                <div class="col-12 alert alert-success text-center mt-1" id="alert_message">{{ session()->get('success') }}</div>

            @else
            
            <form id="orgcreate" method="POST" action="{{ url('/organization/register') }}">
                @csrf

                {{--
                <div class="form-group row">
                    <label for="organization_name" class="col-md-4 col-form-label text-md-right">{{ __('Organization Name') }}</label>

                    <div class="col-md-6">
                        <input id="organization_name" type="text" class="form-control @error('organization_name') is-invalid @enderror" name="organization_name" value="{{ old('organization_name') }}" required autocomplete="organization_name" autofocus>

                        @error('organization_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="organization_email" class="col-md-4 col-form-label text-md-right">{{ __('Organization E-Mail') }}</label>

                    <div class="col-md-6">
                        <input id="organization_email" type="email" class="form-control @error('organization_email') is-invalid @enderror" name="organization_email" value="{{ old('organization_email') }}" required autocomplete="organization_email">

                        @error('organization_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                --}}

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-mail') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
                    

            @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
