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







          <!-- Centered Form -->
<div class="container mt-3">
  <div class="row d-flex justify-content-start">
    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Manage Category</h5>
          <small class="text-muted float-end">Add new Category</small>
        </div>
        <div class="card-body">
          <form>
            <div class="mb-3">
            <div class="input-group">
                            <select
                              class="form-select"
                              id="inputGroupSelect04"
                              aria-label="Example select with button addon">
                              <option selected>Choose...</option>
                              <option value="1">Order Id</option>
                              <option value="2">Phone Number</option>
                              
                            </select>
                            <button class="btn btn-outline-primary" type="button">Button</button>
                          </div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-default-company">Market Place Fees:</label>
              <input type="text" class="form-control" id="basic-default-company" placeholder="Enter Market Place Fees" />
            </div>
            
            
            <button type="search" class="btn btn-success">search</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container">


<!-- <main id="content-area" class="py-5 pe-4 ms-auto">
  <h1>View Users</h1>
 
      <table id="viewuser"  class="table table-striped">
          <thead>
          <tr>
             <th  data-field="Firstname">Firstname</th>
             <th  data-field="Lastname">Lastname</th>
             <th  data-field="Email">Email</th>
              <th>Action</th>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>
            <input type="submit" class=" btn btn-danger" value="Edit">
            <input type="submit" class=" btn btn-danger" value="Delete">
            </td>
          </tr>
          </thead>
         </table> -->
<!-- 
                       
         <div class="container">

              <div class="card">
                <h5 class="card-header">Display Category</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Market Place Fees</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                       <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
            <input type="submit" class=" btn btn-primary" value="Edit">
            <input type="submit" class=" btn btn-danger" value="Delete">
            </td>
          </tr>
          </thead>
         </table>
      </div>
   </div>
</div>
</div> -->
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