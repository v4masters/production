<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>

  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Edit Master Category Detail</title>

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

              <h5 class="mb-0">Edit Category</h5>

            </div>

            <div class="card-body">

              <div class="row d-flex justify-content-start">

                <div class="col-md-6">

                  <form id="formAuthentication" class="mb-3" action="{{url('/') }}/editset_cat" method="POST">

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
                      <div class="col-sm-6">
                        <div class="form-group mb-3">

                          <label class="form-label" for="basic-icon-default-fullname">Category Name:</label>

                          <input type="text" class="form-control" id="basic-icon-default-fullname" name="title" value="{{ $pagedata->title }}" />

                        </div>
                      </div>


                      <div class="col-sm-5">

                        <div class="form-group mb-3">

                          <label class="form-label">status</label>

                          <select class="form-select" name="status">
                          <option value="1"   @if($pagedata->status==1){{'selected';}}@endif>Active</option>
                            <option value="0"  @if($pagedata->status==0){{'selected';}}@endif>Inactive</option>
                          </select>

                        </div>

                      </div>

                    </div>

                    <button type="submit" class="btn btn-success">update</button>

                  </form>

                </div>

              </div>

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