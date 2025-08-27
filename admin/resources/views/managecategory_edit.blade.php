<!DOCTYPE html>



<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">



<head>

  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

  <title>manage category</title>

  <meta name="description" content="" />



  <!-- headerscript -->

  @include('includes.header_script')
  
   <style>
        .imagePreview {
            width: 100%;
            height: 200px;
            background-position: center center;
            background: url(https://tamilnaducouncil.ac.in/wp-content/uploads/2020/04/dummy-avatar.jpg);
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }

        .imgUp {
            margin-bottom: 15px;
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
                <h5 class="mb-5 btn btn-primary btn-md"><b>Category : </b>{{$category->name}} </h5>
                <form action="{{url('/') }}/edit_category" method="POST" enctype="multipart/form-data">

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
                  
                   <div class="row ps-4 pe-5">
                                        <div class="col-md-3 mb-4 imgUp">
                                            <div class="form-group">
                                                <div class="imagePreview"></div>
                                                <label class="form-control btn btn-primary">Category Icon 
                                                    <input class="uploadFile img" type="file" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" name="img" />
                                                </label>
                                                  <span style="color:red;font-size:10px">This will overwrite previous icon</span>
                                                </div>
                                        </div>
                                    </div>

                  <div class="row">

                    <div class="col-sm-3">

                      <div class="form-group mb-3">

                        <label class="form-label">Category</label>

                        <input type="text" class="form-control" name="name" value="{{ $pagedata->name }}" />

                      </div>

                    </div>



                    <div class="col-sm-3">

                      <div class="form-group mb-3">

                        <label class="form-label">Description</label>

                        <input type="text" class="form-control" name="des" value="{{ $pagedata->des }}" />

                      </div>

                    </div>



                    <div class="col-sm-2">

                      <div class="form-group mb-3">

                        <label class="form-label">Market Fee</label>

                        <input type="number" class="form-control" name="market_fee" value="{{ $pagedata->market_fee }}" />

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


<script>
       $(function() {
            $(document).on("change", ".uploadFile", function() {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                    }
                }

            });
        });
   
</script>
</body>

</html>