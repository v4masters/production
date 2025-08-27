<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Edit User Student</title>

    <meta name="description" content="" />

    <!-- Headerscript -->

    @include('includes.header_script')

</head>

<body>

    <!-- Layout wrapper -->

    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            @include('includes.sidebar')

            <!-- Menu -->

            <!-- Layout container -->

            <div class="layout-page">

                <!-- Navbar -->

                @include('includes.header')

                <!-- Navbar -->

                <!-- Centered Form -->

                <div class="container mt-3">

                    <div class="card mb-4">

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <h5 class="mb-0">Edit Student</h5>

                        </div>

                        <div class="card-body">

                            <form id="formAuthentication" class="mb-3" action="{{url('/') }}/edit_user_student" method="POST">

                                @csrf

                                @if ($errors->any())

                                <div class="alert alert-danger">

                                    <ul>

                                        @foreach ($errors->all() as $error)

                                        <li>{{ $error }}</li>

                                        @endforeach

                                    </ul>

                                </div>

                                @endif

                                @if(session('success'))

                                <div class="alert alert-primary">

                                    {{ session('success') }}

                                </div>

                                @endif

                                <input type="hidden" name="id" class="form-control" value="{{ $pagedata->id }}" required />

                                <div class="row">

                                    <div class="col-sm-3">

                                        <div class="form-group mb-3">

                                            <label class="form-label">First Name:</label>

                                            <input type="text" class="form-control" name="first_name" value="{{ $pagedata->first_name }}" />

                                        </div>
                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group mb-3">

                                            <label class="form-label">Last Name:</label>

                                            <input type="text" class="form-control" name="last_name" value="{{ $pagedata->last_name }}" />

                                        </div>
                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group mb-3">

                                            <label class="form-label">Email:</label>

                                            <input type="text" class="form-control" name="email" value="{{ $pagedata->email }}" />

                                        </div>
                                    </div>

                                    <!--<div class="col-sm-3">-->

                                    <!--    <div class="form-group mb-3">-->

                                    <!--        <label class="form-label">Password:</label>-->

                                    <!--        <input type="password" class="form-control" name="password" value="{{ $pagedata->password }}" />-->

                                    <!--    </div>-->
                                    <!--</div>-->

                                    <div class="col-sm-3">

                                        <div class="form-group mb-3">

                                            <label class="form-label">Phone number:</label>

                                            <input type="text" class="form-control" name="phone_no" value="{{ $pagedata->phone_no }}" />

                                        </div>
                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group mb-3">

                                            <label class="form-label">Date Of Birth:</label>

                                            <input type="date" class="form-control" name="dob" value="{{ $pagedata->dob }}" />

                                        </div>
                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group mb-3">

                                            <label class="form-label">Country:</label>

                                            <input type="text" class="form-control" name="country" value="{{ $pagedata->country }}" />

                                        </div>
                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group mb-3">

                                            <label class="form-label">State:</label>

                                            <input type="text" class="form-control" name="state" value="{{ $pagedata->state }}" />

                                        </div>
                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group mb-3">

                                            <label class="form-label">District:</label>

                                            <input type="text" class="form-control" name="distt" value="{{ $pagedata->distt }}" />

                                        </div>
                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group mb-3">

                                            <label class="form-label">City:</label>

                                            <input type="text" class="form-control" name="city" value="{{ $pagedata->city }}" />

                                        </div>
                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group mb-3">

                                            <label class="form-label">Landmark:</label>

                                            <input type="text" class="form-control" name="landmark" value="{{ $pagedata->landmark }}" />

                                        </div>
                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group mb-3">

                                            <label class="form-label">Pincode:</label>

                                            <input type="text" class="form-control" name="pincode" value="{{ $pagedata->pincode }}" />

                                        </div>
                                    </div>


                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">status</label>
                                            <select class="form-select" name="status">
                                                <option value="1" @if($pagedata->status==1){{'selected';}}@endif>Active</option>
                                                <option value="0" @if($pagedata->status==0){{'selected';}}@endif>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">COD Status</label>
                                            <select class="form-select" name="cod_status">
                                                <option value="1" @if($pagedata->cod_status==1){{'selected';}}@endif>Active</option>
                                                <option value="0" @if($pagedata->cod_status==0){{'selected';}}@endif>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                     <div class="col-sm-9">

                                        <div class="form-group mb-3">

                                            <label class="form-label">Address:</label>

                                            <textarea class="form-control" name="address">{{ $pagedata->address }}</textarea>

                                        </div>

                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success">Update</button>

                            </form>

                        </div>

                    </div>

                </div>

                <!-- Footer -->

                <footer class="default-footer">

                    @include('includes.footer')

                    <!-- Footer -->

                    <div class="content-backdrop fade"></div>

            </div>

            <!-- Content wrapper -->

        </div>

        <!-- Layout page -->

    </div>

    <!-- Overlay -->

    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Layout wrapper -->

    @include('includes.footer_script')

    <!-- Footerscript -->

</body>

</html>