<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

    <title>View School</title>

    <meta name="description" content="" />

    <!-- headerscript -->

    @include('includes.header_script')
    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
    <style>
    
    .modal:nth-of-type(even) {
     z-index: 1052 !important;
     }
     
     .modal-backdrop.show:nth-of-type(even) {
      z-index: 1051 !important;
     }
    
    
        #heading {
            background-color: #E7E7FF;
            border: 1px solid #E7E7FF;
            border-radius: 7px;
            padding: 9px 27px 9px 27px;
        }

        .imagePreview {
            width: 100%;
            height: 100px;
            background-position: center center;
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }

        .imgUp {
            margin-bottom: 15px;
        }

        .del {
            position: absolute;
            top: 0px;
            right: 15px;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background-color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
        }

        #imgAdddes {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #696cff;
            color: #fff;
            box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.2);
            text-align: center;
            line-height: 30px;
            margin-top: 0px;
            cursor: pointer;
            font-size: 15px;
        }

        .input-group-text {
            padding: 1px 5px 1px 5px !important;
        }


        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            /*display: inline-block;*/
        }

        .imgbtn {
            border: 1px solid #696cff;
            color: #696cff;
            background-color: white;
            padding: 8px 15px;
            font-size: 15px;
            font-weight: bold;
            width: 100%;
        }

        .imgbtnremove {
            border: 1px solid #696cff;
            color: #696cff;
            background-color: white;
            padding: 8px 15px;
            font-size: 15px;
            font-weight: bold;
            width: 20%;
        }

        .upload-btn-wrapper input[type=file] {
            font-size: 80px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }

        .imgremove {
            position: absolute;
            background: blue;
            color: #fff;
            padding: 5px;
            border-radius: 50%;
            margin-top: -12px;
            margin-left: -7px;
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

                <!-- Centered Form -->

                <div class="container mt-3">

                    <div class="row d-flex justify-content-center">

                        <div class="col-xl">


                        <div style="display:block;" id="content_div">    
                                 <div class="card">
                         <div class="card-header justify-content-between align-items-center">


                        <h5 class="card-header ">Display  Set  </h5>
                   
                  
                                     <select class="selectpicker"       name="pickup_point[]"  multiple aria-label="size 3 select example">
                                                       <option selected disabled value="">Select</option>
                                                       <option value="0">NULL</option>
                                                        @foreach($pp_data as  $pp_data_name)

                                                        <option value="{{$pp_data_name->id}}" >{{$pp_data_name->name}}</option>
                                                       
                                                        @endforeach

                                     </select>



                        </div>
                        <div class="card-body">
                        <table id="table" class="table table-striped"
                        data-toggle="table" 
                        data-toolbar="#toolbar" 
                        data-search="true" 
                        data-show-refresh="true" 
                        data-show-toggle="true" 
                        data-show-fullscreen="false"
                        data-show-columns="true" 
                        data-show-columns-toggle-all="true"
                        data-detail-view="false"
                        data-show-export="true"
                        data-click-to-select="true" 
                        data-detail-formatter="detailFormatter" 
                        data-minimum-count-columns="2"
                        data-show-pagination-switch="true" 
                        data-pagination="false" 
                        data-id-field="id" 
                        data-page-list="[10]"
                        data-show-footer="true" 
                        data-response-handler="responseHandler">

                            <thead>
                                <tr>
                                    <th class="cell">#</th>
                                    
                                    <th data-sortable="true"> School Info</th>
                                     <th data-sortable="true">Pickup Point </th>
                                    <th data-sortable="true"> Action</th>
                               
        
                                </tr>

                            </thead>
                            <tbody>
                             
                             @foreach($all_set as $key => $data)
                                 @php
                                  $key++;
                                  
                                
                                  @endphp
                             <tr>
                                 <td>{{$key}}</td>
                                 <td><b>{{$data->school_code}}<br>{{$data->school_name}}</b><br>{{$data->state}},{{$data->distt}},{{$data->city}},<br>{{$data->tehsil}},{{$data->post_office}},{{$data->zipcode}}</td>
                                 <td>
                                    
                                    @php
                                    
                                    if($data->pickup_point==NULL)
                                    {
                                      $bcolor="ged";
                                      $btn="btn btn-danger";
                                      $name="Add Pickup Point";
                                    }
                                    else
                                    {
                                     $bcolor="green";
                                     $btn="btn btn-success";
                                      $name="View Pickup Point";
                                    }
                                    
                                    @endphp
                                    
                                    
                                    
                                    
                                   
                                      <button type="button" onclick="update_add_pickup_point(`{{$data->pickup_point}}`,`{{$data->id}}`)" class="{{$btn}}" >{{$name}} </button>
                                     

                                     </td>
                                
                                 <td>
                                     <a href="{{url('view_all_schoolset',$data->id)}}" class="btn btn-primary" >View  all Set</a>
                                 
                                 </td>
                                 
                                 
                                         
                             </tr>
                               @endforeach
                            </tbody>
                        </table>
                        
                        
                        </div>
                    </div>
                    </div>
  </form>

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


<!-- Modal structure -->
<div class="modal fade" id="selectpickupoint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Pickup Point</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <form method="post" id="myform"  action="{{url('/') }}/update_add_pickup_point"  enctype="multipart/form-data" >
        @csrf
      <div class="modal-body">
          
        <input type="hidden" name="school_id" id="school_id">
         <select class="selectpicker" id="pickup_point_select" name="pickup_point[]"  multiple aria-label="size 3 select example">
                <option selected disabled value="">Select</option>
                <option value="0">NULL</option>
                 @foreach($pp_data as  $pp_data_name)
                 <option value="{{$pp_data_name->id}}" >{{$pp_data_name->name}}</option>
                 @endforeach

        </select>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-primary">Update </button>
      </div>
      </form>
    </div>
  </div>
</div>

        </div>
        <!-- Overlay -->
        <div class="allimgmodal"></div>
        <div class="layout-overlay layout-menu-toggle"></div>

    </div>
    <!-- / Layout wrapper -->
    



    

@include('includes.footer_script')

<script>

  function update_add_pickup_point(pp_id, school_id) {
    document.getElementById('school_id').value = school_id;
    let selectedIds = pp_id.split(","); 
    let selectElement = document.getElementById('pickup_point_select'); 
    let options = selectElement.querySelectorAll('option');
     options.forEach(function(option) {
        if (selectedIds.includes(option.value)) {
            option.selected = true; // Select the option if its value is in selectedIds
        } else {
            option.selected = false; // Unselect the option if it's not in selectedIds
        }
    });

    $('.selectpicker').selectpicker('refresh'); 
    $('#selectpickupoint').modal('show');
}

    
  $("#myform").on("submit",function(e)
  {    
      e.preventDefault();
        $(".loader").css("display","block");
        $.ajax
        ({
        type: "POST",
        url:  e.target.action,
        data: $('#myform').serialize(),
        success: function (response)
        {
               
       
          if (response.success==0)
                {
                $.toast({  heading:  "<i class='fa fa-warning' ></i> "+response.msg, position: 'top-right',stack: false})
                $(".loader").css("display","none");
                
                }
                else
                {
               
                $.toast({ heading: response.msg, position: 'top-right',stack: false,icon: 'success'})
                $(".loader").css("display","none");
                
                  setTimeout(function() 
    				{
    			       window.location.reload();
    				}, 2000);
                
                }
        
        }
        }); 

});

    
</script>

</body>
</html>