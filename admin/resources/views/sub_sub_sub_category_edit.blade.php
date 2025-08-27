<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>

  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

  <title>Edit sub sub Sub category</title>

  <meta name="description" content="" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- headerscript -->

  @include('includes.header_script')

  <style>
    .multiselect {
      width: 263px !important;
    }

    .multi_select_dropdown_menu {
      width: -webkit-fill-available !important;
    }

    .multiselect-container>li>a>label {
      padding: 0px !important;
    }

    .multi_select_dropdown_menu {

      overflow-y: scroll !important;
      overflow-x: hidden !important;
    }

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
                    <h5 class="mb-0 btn subcats btn-md"><b>Category : </b>{{$category->name}}</h5>
                  </div>

                </div>

                <br>

                <div class="row">

                  <div class="col-md-12 ">
                    <h5 class="mb-0 btn btn-primary btn-md"><b>Sub Category : {{$subcategory->name}}</b></h5>
                  </div>

                </div> <br>

                <div class="row">

                  <div class="col-md-12 ">
                    <h5 class="mb-0 btn subcats  btn-md"><b>Sub Sub Category : </b>{{$subsubcategory->title}}</h5>
                  </div>

                </div><br><br>


                <form action="{{url('/') }}/edit_sub_sub_sub_category" method="POST" enctype="multipart/form-data">

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

                  <input type="hidden" name="cat_id" class="form-control" value="{{$pagedata->cat_id}}" required />
                  <input type="hidden" name="sub_cat_id" class="form-control" value="{{$pagedata->sub_cat_id}}" required />
                  <input type="hidden" name="sub_cat_id_two" class="form-control" value="{{$pagedata->sub_cat_id_two}}" required />
                  <input type="hidden" name="id" class="form-control" value="{{$pagedata->id}}" required />

                  <div class="row">

                    <div class="col-sm-3">

                      <div class="form-group mb-3">

                        <label class="form-label">Title</label>

                        <input type="text" class="form-control" name="title" value="{{$pagedata->title}}" />

                      </div>

                    </div>

                    <div class="col-sm-4">

                      <div class="form-group">

                        <label class="form-label">Size</label><br>

                        <select name="size[]" class="form-select" multiple="multiple">
                          @foreach($size as $val)

                          @foreach(explode(',',$pagedata->size) as $existsize)
                          @if($existsize==$val->id)
                          <option value="{{$val->id}}" selected>{{$val->title}}</option>
                          @else
                          <option value="{{$val->id}}">{{$val->title}}</option>
                          @endif

                          @endforeach

                          @endforeach
                        </select>

                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group mb-3">
                        <label class="form-label">Select Form </label>

                        <select class="form-select" name="form_id">
                          @foreach($form as $key => $val)


                          @if($pagedata->form_id==$val->id)
                          <option value="{{$val->id}}" selected>{{$val->title}}</option>
                          @else
                          <option value="{{$val->id}}">{{$val->title}}</option>
                          @endif


                          @endforeach


                        </select>
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
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</html>