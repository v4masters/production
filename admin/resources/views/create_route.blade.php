<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
  <title>Create Route</title>
  <meta name="description" content="">

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
          <div class="row d-flex justify-content-start">
            <div class="col-md-6">
              <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Create Route</h5>
                </div>
                <div class="card-body">
                  <form>
                    <div class="mb-3">
                      <label class="form-label" for="school-code">School Code</label>
                      <input type="text" class="form-control" id="school-code" placeholder="Enter School Code">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="source">Source</label>
                      <input type="text" class="form-control" id="source" placeholder="TEST , Abc (123456) - 9874561230">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="destination">Destination</label>
                      <input type="text" class="form-control" id="destination" placeholder="Enter Destination">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Route</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <div class="card">
            <h5 class="card-header">Available Categories</h5>
            <div class="table-responsive text-nowrap">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Route Id</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <footer class="default-footer">
          @include('includes.footer')
        </footer>
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
      </div>
      <!-- Content wrapper -->
    </div>
    <!-- Layout page -->
  </div>

  <!-- Overlay and Footer Script -->
  <div class="layout-overlay layout-menu-toggle"></div>
  @include('includes.footer_script')
  <!-- Footerscript -->
</body>
</html>
