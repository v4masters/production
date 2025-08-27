<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <title>Grade Wise Set</title>
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
                    <div class="card">
                        <h5 class="card-header">Display  Grade Wise Set </h5>
                        
                        <div class="card-header  justify-content-between align-items-center">

                            <h5 class="btn btn-primary "><b>Organisation : </b>{{$organisation->name}} </h5>

                        </div>
                        
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
                         
                        <div class="table-responsive text-nowrap">
                            <table id="table" class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Grade </th>
                                        <th>View</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grade as $key => $data)

                                    @php

                                    $key++;

                                    @endphp
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$data->title}}</td>
                                        <td><button type="button" onclick="select_cat(`{{$organisation->id}}`,`{{$data->title}}`,`1`)"  class="btn btn-primary btn-sm">View </button></td>
                                        <td><button type="button" onclick="select_cat(`{{$organisation->id}}`,`{{$data->title}}`,`2`)"  class="btn btn-primary btn-sm"> Edit</button></td>
                                       <td><button type="button" onclick="select_cat(`{{$organisation->id}}`,`{{$data->title}}`,`3`)"  class="btn btn-danger btn-sm"> Delete</button></td>
                                       
                                       
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Centered Form -->






                        <div class="modal" id="myModal">

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">

                                    <!-- Modal Header -->

                                    <div class="modal-header">
                                         <h5 id="modal_header"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                                    </div>
                                    <!-- Modal body -->

                                    <div class="modal-body" id="cardbody">
                                       
                                         <form method="get" id="myform" action="{{url('/') }}/grade_wise_set_ved" enctype="multipart/form-data" novalidate>
                                            @csrf
                                      
                                             <div class="row">

                                              <input type="hidden" name="org" id="org" class="" required>
                                              <input type="hidden" name="grade" id="grade" class="" required>
                                               <input type="hidden" name="action_status" id="action_status" class="" required>
                                              
                                              <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Board</label>

                                                        <select class="form-control" name="set_cat" id="form-select-md-set-cat" data-placeholder="Select" required >

                                                            <option selected disabled value="">--Select--</option>
                                                            <option value="0">N/A </option>
                                                            @foreach($board as $key => $board)

                                                            <option value="{{$board->id}}">{{$board->title}}</option>

                                                            @endforeach

                                                        </select>

                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Set Category</label>

                                                        <select class="form-control" name="set_cat" id="form-select-md-set-cat" data-placeholder="Select" required >

                                                            <option selected disabled value="">--Select--</option>
                                                            <option value="0">N/A </option>
                                                            @foreach($setcat as $key => $set_cat)

                                                            <option value="{{$set_cat->id}}">{{$set_cat->title}}</option>

                                                            @endforeach

                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Set Type</label>
                                                        <select class="form-control"  name="set_type" id="form-select-md-set-type" data-placeholder="Select" required >

                                                            <option selected disabled value="">--Select--</option>
                                                            <option value="0">N/A </option>
                                                            @foreach($settype as $key => $set_type)

                                                            <option value="{{$set_type->id}}">{{$set_type->title}}</option>

                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                
                                                  <div class="col-sm-6">
                                                    <div class="form-group mb-3">

                                                        <label class="form-label">Class</label>
                                                        <select class="form-control"  name="set_class" id="set_class" data-placeholder="Select" required>

                                                            <option selected disabled value="">--Select--</option>
                                                            <option value="0">N/A </option>
                                                            @foreach($allclass as $key => $class)

                                                            <option value="{{$class->id}}">{{$class->title}}</option>

                                                            @endforeach

                                                        </select>

                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div id="submit_btn">
                                         
                                         </div>
                                       </form>



                                    </div>

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

<script>

    function select_cat(oid,gid,status)
    {
        if(status==1)
        {
            $('#modal_header').html('Select Board,Category,Type,Class of set that you want to view.');
            $('#submit_btn').html('<button type="submit"  class="btn btn-primary">View</button>');
            
        }else if(status==2)
        {
            $('#modal_header').html('Select Board,Category,Type,Class of set that you want to Edit.');
            $('#submit_btn').html('<button type="submit"  class="btn btn-success"> Update</button>');
        }
        else if(status==3)
        {
           $('#modal_header').html('Select Board,Category,Type,Class of set that you want to Delete.');
           $('#submit_btn').html('<button type="submit" onclick="submitForm()" class="btn btn-danger">Danger</button>');
        }
        else
        {
            $('#modal_header').html('');
        }
        
       document.getElementById('org').value=oid;
       document.getElementById('grade').value=gid;
       document.getElementById('action_status').value=status;
       
       $('#myModal').modal('show');
    }
    
    
function submitForm() {
  return confirm('Do you really want to delete all selected organization,grade,board,category,set type,set class related set from all school and vendor ?');
}
    
</script>
	
