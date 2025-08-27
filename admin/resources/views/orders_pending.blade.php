<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />
    <title>Pending Orders </title>
    <meta name="description" content="" />
    @include('includes.header_script')
</head>
<body>


    <!-- Layout wrapper -->

    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            @include('includes.sidebar')

            <!-- / Menu -->

            <!-- Layout container -->

            <div class="layout-page">

                <!-- Navbar -->

                @include('includes.header')

                <!-- / Navbar -->

                <!-- Content wrapper -->

                <div class="content-wrapper">

                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">



                        <div class="card mb-4">

                            <div class="card-header d-flex justify-content-between align-items-center">

                                <h5 class="mb-0">Update Pending Order
                                </h5>

                                <small class="text-muted float-end"></small>

                            </div>

                            <div class="card-body">

                                <form action="{{url('/') }}/update_pending_order" method="POST" enctype="multipart/form-data">

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



                                    <div class="col-sm-5">

                                        <div class="form-group mb-3">

                                            <label class="form-label">Order Id: <span class="required">*</span></label>

                                            <input type="text" class="form-control" name="oid" required />

                                        </div>

                                    </div>
                                     <div class="col-sm-5">

                                        <div class="form-group mb-3">

                                            <label class="form-label">Transaction Id: <span class="required">*</span></label>

                                            <input type="text" class="form-control" name="tid" required />

                                        </div>

                                    </div>
                                     <div class="col-sm-5">

                                        <div class="form-group mb-3">

                                            <label class="form-label">Payment Mode: <span class="required">*</span></label>

                                            <input type="text" class="form-control" name="paymode" required />

                                        </div>

                                    </div>
                                     <div class="col-sm-5">

                                        <div class="form-group mb-3">

                                            <label class="form-label">Total Amount: <span class="required">*</span></label>

                                            <input type="number" class="form-control" name="total_amount" required />

                                        </div>

                                    </div>
                                    

                                    <button type="submit" class="btn btn-success">Update </button>

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

        <!-- Footerscript-->

    </div>

    </div>

    </div>

    </div>



</body>



</html>