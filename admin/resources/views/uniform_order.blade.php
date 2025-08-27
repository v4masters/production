<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta  name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0"/>
    <title>Manage Category</title>
    <meta name="description" content="" />

    <!-- headerscript -->
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






          <div class="container mt-3">
          <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Manage Inventory</h5>
          <small class="text-muted float-end">View Approved inventory</small>
        </div>
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Image Name</th>
                    
                    <th>category</th>
                    <th>Stream</th>
                    <th>Company Name</th>
                    <th>Class</th>
                    <th>Available Quantity</th>
                    <th>Unit Price ( Inc GST )</th>
                    <th>GST ( % )</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <input type="submit" class="btn btn-primary" value="Edit">
                      
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>


 <!-- Footer -->
 <footer class="default-footer">
 @include('includes.footer')     
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    @include('includes.footer_script')
   <!-- footerscrit -->
  </body>
</html>