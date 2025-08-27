<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />
  <title>Manage Category</title>
  <meta name="description" content="" />

  <!-- headerscript -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel='stylesheet' href='https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css'>
  <script src='https://code.jquery.com/jquery-3.7.0.js'></script>
  <script src='https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js'></script>
  <script src='https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js'></script>

  <!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
  <script src=" https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script> -->


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
              <small class="text-muted float-end">View Full Inventory</small>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped" id="table" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Image Name</th>
                    <th>category</th>
                    <th>Stream</th>
                    <th>Company Name</th>
                    <th>Class</th>
                    <th>Unit Price( Inc GST )</th>
                    <th>GST ( % )</th>
                    <th>Uploader Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>dfdf</td>
                    <td>gfddfdf</td>
                    <td>df</td>
                    <td>fd</td>
                    <td>dffddf</td>
                    <td>rgrgrr</td>
                    <td>drfdfd</td>
                    <td>dfdffdfd</td>
                    <td>erererer</td>
                    <td>erfddvcf</td>
                    <td>
                      <input type="submit" class="btn btn-primary btn-sm" value="Edit">
                      <input type="submit" class="btn btn-danger btn-sm" value="Delete">
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
  <script>
    $(document).ready(function() {
      $('#table').DataTable({
        //disable sorting on last column
        "columnDefs": [{
          "orderable": false,
          "targets": 5
        }],
        language: {
          //customize pagination prev and next buttons: use arrows instead of words
          'paginate': {
            'previous': '<span class="fa fa-chevron-left"></span>',
            'next': '<span class="fa fa-chevron-right"></span>'
          },
          //customize number of elements to be displayed
          "lengthMenu": 'Display <select class="form-control input-sm">' +
            '<option value="10">10</option>' +
            '<option value="20">20</option>' +
            '<option value="30">30</option>' +
            '<option value="40">40</option>' +
            '<option value="50">50</option>' +
            '<option value="-1">All</option>' +
            '</select> results'
        }
      })
    });

    // $('#table').DataTable({
    //   dom: 'Bfrtip',
    //   buttons: [
    //     'csv', 'excel', 'pdf', 'print', 'colvis'
    //   ]
    // });

  </script>
</body>

</html>