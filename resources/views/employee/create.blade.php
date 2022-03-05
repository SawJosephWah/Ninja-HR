@extends('layouts.app')
@section('title','EMPLOYEE')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('employee.store')}}" id="StoreEmployee" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                 <!-- employee id -->
                           <div class="md-form">
                                <input id="employee_id" type="text" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id"
                                value="{{ old('employee_id') }}"  autofocus>
                                <label for="materialLoginFormEmail">Employee Id</label>

                                @error('employee_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                           <!-- Name -->
                            <div class="md-form">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}"  autocomplete="email" >
                                <label for="materialLoginFormEmail">Name</label>

                                @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>


                           <!-- Phone -->
                            <div class="md-form">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                value="{{ old('phone') }}" >
                                <label for="materialLoginFormEmail">Phone</label>

                                @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                          <!-- email -->
                            <div class="md-form">
                                <input id="emaila" type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}"   >
                                <label for="materialLoginFormEmail">Email</label>

                                @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                               <!-- pincode -->
                            <div class="md-form">
                                <input id="pin_code" type="number" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code"
                                value="{{ old('pin_code') }}" >
                                <label for="materialLoginFormEmail">Pin Code</label>

                                @error('pin_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                             <!-- password -->
                            <div class="md-form">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                                value="{{ old('password') }}" >
                                <label for="materialLoginFormEmail">Password</label>

                                @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                          <!-- NRC number -->
                            <div class="md-form">
                                <input id="nrc_number" type="text" class="form-control @error('nrc_number') is-invalid @enderror" name="nrc_number"
                                value="{{ old('nrc_number') }}"  >
                                <label for="materialLoginFormEmail">NRC Number</label>

                                @error('nrc_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                         <!-- Gender -->
                            <div class="form-group">
                                {{-- <label for="">Gender</label> --}}
                                <select name="gender" class="form-control  @error('gender') is-invalid @enderror" aria-label="Default select example">
                                    <option value="" selected>Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                               <!-- Birthday -->
                            <div class="md-form">
                                <input id="birthday" type="text" class="form-control @error('birthday') is-invalid @enderror" name="birthday"
                                value="{{ old('birthday') }}" autocomplete="off" >
                                <label for="materialLoginFormEmail">Birthday</label>

                                @error('birthday')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            </div>

                            <div class="col-md-6">
                                  <!-- Image -->
                                  <div>
                                      <div class="row">
                                          <div class="col-md-6">
                                            <label for="materialLoginFormEmail">Profile Image</label>
                                            <input id="image"  type="file" class="form-control p-1  @error('image') is-invalid @enderror" name="image"
                                            value="{{ old('image') }}">
                                            @error('image')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                          </div>
                                          <div class="col-md-6">
                                              <img id="uploadPreview" src="{{asset('img/user_demo.png')}}" class="w-100" style="height: 180px;border-radius:5px;">
                                          </div>
                                      </div>

                                </div>


                                <!-- address-->
                                <div class="md-form">
                                    <textarea id="form7" class="md-textarea form-control @error('address') is-invalid @enderror" name="address" rows="3"></textarea>
                                    <label for="form7">Address</label>
                                    @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                <!--Department -->
                                <label for="">Department</label>
                                <div class="form-group">

                                    <select name="department_id" class="form-control  select2 @error('department_id') is-invalid @enderror" aria-label="Default select example">
                                        <option value="" disabled selected>selecet department</option>
                                        @foreach($departments as $d)
                                        <option value="{{$d->id}}">{{$d->title}}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                <!--Role -->
                                <label for="">Role ( s )</label>
                                <div class="form-group">
                                    <select name="roles[]" class="form-control  select2 @error('roles') is-invalid @enderror" aria-label="Default select example" multiple>

                                        @foreach($roles as $r)
                                        <option value="{{$r->name}}">{{$r->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                <!-- date of join -->
                                <div class="md-form">
                                    <input id="date-of-join" type="text" class="form-control @error('date_of_join') is-invalid @enderror" name="date_of_join"
                                    value="{{ old('birthday') }}"  autocomplete="off">
                                    <label for="materialLoginFormEmail">Date Of Join</label>

                                    @error('date_of_join')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                <!-- Is presnet -->
                                <div class="form-group">

                                    <select name="is_present" class="form-control @error('is_present') is-invalid @enderror" aria-label="Default select example">
                                        <option value="" selected>Is Present?</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    @error('is_present')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <button class="btn btn-theme btn-block" type="submit"><i class="feather-user-plus mr-3"></i>Create</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


        </div>
    </div>

</div>


@section('custom-script')
{{-- {!! JsValidator::formRequest('App\Http\Requests\StoreEmployee','#StoreEmployee') !!} --}}
    <script>

        $(document).ready(function() {
            $('#birthday').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "maxDate": moment(),
                autoUpdateInput: false,
                "locale": {
                    "format": "YYYY-MM-DD",
                    cancelLabel: 'Clear'
                }
            }).on("apply.daterangepicker", function (e, picker) {
                picker.element.val(picker.startDate.format(picker.locale.format));
            });

            $('#date-of-join').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                autoUpdateInput: false,
                "locale": {
                    "format": "YYYY-MM-DD   "
                }
            }).on("apply.daterangepicker", function (e, picker) {
                picker.element.val(picker.startDate.format(picker.locale.format));
            });

            $("#image").change(function(){
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("image").files[0]);

                oFReader.onload = function (oFREvent) {
                    document.getElementById("uploadPreview").src = oFREvent.target.result;
                };
            });
                        });
    </script>
@endsection

@endsection
