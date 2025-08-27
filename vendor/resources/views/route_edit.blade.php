<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Edit Route</title>

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


                <!--Create Routes-->
                <div class="container mt-3">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Edit Route</h5>
                        </div>

                        <div class="card-body">
                            <form id="formAuthentication" class="mb-3" action="{{url('/') }}/route_edit" method="POST">
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

                                <input type="hidden" name="id" class="form-control" value="{{$route_data->unique_id}}" required />

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">School Code</label>
                                            <input type="text" class="form-control" name="schoolcode" value="" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6"></div>

                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Source</label>
                                            <textarea class="form-control" name="source">{{$route_data->source}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"></div>

                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Destination</label>
                                            <textarea class="form-control" name="destination">{{$route_data->destination}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"></div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                
                

                <!-- Footer -->
                <footer class="default-footer">
                    @include('includes.footer')
                </footer>
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