<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

    <title>School Set View</title>

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

                <!-- Content wrapper -->

                <div class="content-wrapper">

                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        
                    <div class="card mb-4">
                        <div class="card-header justify-content-between align-items-center">


                        
                        </div>
                        <div class="card-body">
                            
                        
                        
                        <div class="table-responsive text-nowrap">


                            <table class="table table-striped" 
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
                            data-pagination="true" 
                            data-id-field="id" 
                            data-page-list="[10, 25, 50, 100, all]"
                            data-show-footer="true" 
                            data-response-handler="responseHandler">

                                <thead>

                                    <tr>

                                        <th>#</th>
                                        <th>Set Id</th>
                                        <th>Board/Grade</th>
                                        <th>Category/Type</th>
                                        <th>Class</th>
                                         <th>Status</th>
                                         <th>Action</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($allset as $key => $data)

                                    @php

                                    $key++;

                                    @endphp

                                    <tr>

                                        <td>{{$key}}</td>
                                         <td>{{$data->set_id}} </td>
                                        <td>{{$data->board}} /<br> {{$data->grade}}</td>
                                        <td>{{$data->cat}} /<br> {{$data->type}}</td>
                                        <td>{{$data->class}} </td>

                                        <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>

                                        <td>
                                            <button type="button" class="mb-3 btn btn-primary btn-sm" onclick="getsetitem(`{{$data->set_id}}`)">View </button>
                                 
                                 
                                 <br>
                                  <a href="{{url('/')}}/edit_school_set_view/{{$data->id}}" class="mb-3 btn btn-success btn-sm">Edit </a>
                                 
                                 <br>
                                 
                                 
                                   <form class="mb-3" action="{{url('/')}}/delete_school_set" method="POST" type="button" onsubmit="return confirm('Do realy want to delete this set permanently!')">
                                    @csrf
                                   <input type="hidden" name="id" class="form-control" value="{{$data->id}}" />
                                   <input type="hidden" name="set_id" class="form-control" value="{{$data->set_id}}" />
                                   <button type="submit" class="btn btn-danger btn-sm"><i class=" bx bx-trash"></i></button>
                                   </form>
                                 
                                 </td>
                                 
                                    </tr>

                                    @endforeach

                                </tbody>





                            </table>

                        </div>

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




<!--modal-->
           <div class="modal" id="myModal">

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">

                                    <!-- Modal Header -->

                                    <div class="modal-header">
                                  <h5 id="itemdivsetid"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                     
                                    </div>


                                    <!-- Modal body -->

                                    <div class="modal-body" id="itemdiv">
                                       
                                                
                                               
                             

                                    </div>

                                </div>

                            </div>

                        </div>
                        
                        <!--end modal-->


<script>
   

    
        function getsetitem(set_id) {
            
            $("#itemdivsetid").html('<h5> SET ID - '+set_id+'</h5>');   
            $('#itemdiv').html('');
            $.ajax({
                type: "POST",
                url: "{{url('/') }}/get_set_item",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "set_id": set_id
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
                    
                    // alert(response);
                  
                var tabledata=' <table id="table" class="table table-striped"><thead> <tr><th>#</th><th > Img </th><th > Itemname </th><th  >ItemCode</th><th > Unit Price</th><th >Qty</th></tr></thead> <tbody>';
                                          
                    
                 for(var i=0;i<response.length;i++)
				 {
				     const id=i+1;
				     tabledata+='<tr><td>'+id+'</td><td>'+response[i].img+'</td><td>'+response[i].itemname+'</td><td>'+response[i].itemcode+'</td><td>'+response[i].unit_price+'</td><td>'+response[i].qty+'</td></tr>';
                  
                 }
                  tabledata+=' </tbody></table>';
                 
                 $('#itemdiv').append(tabledata);	 
                 $('#myModal').modal('show');
                                 
                }
            });
        }

</script>
</body>
</html>