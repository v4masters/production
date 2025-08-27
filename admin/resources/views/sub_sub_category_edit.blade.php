<!DOCTYPE html>



<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">



<head>

  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

  <title>manage Sub category</title>

  <meta name="description" content="" />



  <!-- headerscript -->

  @include('includes.header_script')

  <style>
        .subcats {
            border: 4px solid #E7E7FF;
            background-color: #E7E7FF;
            color: #696CFF;
        }

        .subcats:hover {
            border: 4px solid #E7E7FF;
            background-color: #E7E7FF;
            color: #696CFF;
        }
    </style>

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

                <small class="text-muted float-end"></small>

              </div>

              <div class="card-body">

                <div class="row">

                  <div class="col-md-12">
                    <h5 class="mb-0 btn btn-primary btn-md"><b>Category : </b>{{$category->name}}</h5>
                  </div>

                </div> <br>

                <div class="row">

                  <div class="col-md-12">
                    <h5 class="mb-0 btn btn-md subcats"><b>Sub Category : </b>{{$subcategory->name}}</h5>
                  </div>

                </div><br><br>


                <form action="{{url('/') }}/edit_sub_sub_category" method="POST" enctype="multipart/form-data">

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
                    {!! Session::has('success') ? Session::get("success") : '' !!}


                  </div>

                  @endif

                  <input type="hidden" name="cat_id" class="form-control" value="{{$pagedata->cat_id}}" required />
                  <input type="hidden" name="sub_cat_id" class="form-control" value="{{$pagedata->sub_cat_id}}" required />
                  <input type="hidden" name="id" class="form-control" value="{{$pagedata->id}}" required />

                  <div class="row">


                    <div class="col-sm-3">

                      <div class="form-group mb-3">

                        <label class="form-label">Title</label>

                        <input type="text" class="form-control" name="title" value="{{$pagedata->title}}" />

                      </div>

                    </div>


                    <div class="col-sm-2">

                      <div class="form-group mb-3">

                        <label class="form-label">status</label>

                        <select class="form-select" name="status">
                          <option value="1" @if($pagedata->status==1){{'selected';}}@endif>Active</option>
                          <option value="0" @if($pagedata->status==0){{'selected';}}@endif>Inactive</option>
                        </select>

                      </div>

                    </div>

                  </div>


                  <div class="form-group mb-3">



                    <button type="submit" class="btn btn-success">Save</button>

                  </div>

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