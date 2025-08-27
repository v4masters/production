<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
  <title>Manage Sale Report</title>
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
                  <h5 class="mb-0">Manage Sale Report</h5>
                  <small class="text-muted float-end">Uniform Item Wise Sale Report</small>
                </div>
                <div class="card-body">
                  <form>
                    <div class="mb-3 row">
                      <label for="from-date" class="col-md-2 col-form-label">From:</label>
                      <div class="col-md-10">
                        <input class="form-control" type="date" value="2021-06-18" id="from-date">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="to-date" class="col-md-2 col-form-label">To:</label>
                      <div class="col-md-10">
                        <input class="form-control" type="date" value="2021-06-18" id="to-date">
                      </div>
                    </div>
                    <button type="submit" class="btn btn-success">Get Data</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <div class="card">
            <h5 class="card-header">Display Category</h5>
            <div class="table-responsive text-nowrap">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>SKU No.</th>
                    <th>Item Name</th>
                    <th>Class</th>
                    <th>Qty Sold</th>
                    <th>Price</th>
                    <th>Total</th>
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
                  </tr>
                </tbody>
              </table>
              <h5 class="card-header">Total Sale: Rs.0</h5>
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
