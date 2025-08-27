<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

    <title>Manage Master colour</title>

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


                          <h5 class="btn btn-primary "><b>Organisation : </b>{{$organisation->name}} </h5><br>
                          <h5 class="btn btn-primary "><b>School : </b>{{$school->school_name}} </h5>
                        
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
                                       
                                        <th>Market Place Fee</th>
                                          <th>Status</th>
                                        <th>Del</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($allset as $key => $data)

                                    @php

                                    $key++;
                                    
                                    $updated = DB::table('school_set_vendor')->where('org', $organisation->id)->where('school_id',$school->id)->where('set_id', $data->set_id)->get(); 

                                    @endphp

                                    <tr>

                                        <td>{{$key}}</td>
                                        <td>{{$data->set_id}} </td>
                                        <td>{{$data->board}} /<br> {{$data->grade}}</td>
                                        <td>{{$data->cat}} /<br> {{$data->type}}</td>
                                        <td>{{$data->class}} </td>

                                       

                                        <td>
                                            <div class="input-group mb-3">
                                              <input type="number" id="{{'set_id_'.$data->id}}" min="0" class="form-control" value="{{$data->market_place_fee}}" aria-label="Market Fee">
                                              <button type="button" onclick="market_place_fee(`{{'set_id_'.$data->id}}`,`{{$data->set_id}}`)" class=" btn btn-success btn-sm input-group-text">Update</button>
                                            </div>
                                            
                                            </td>
                                            
                                            
                                            
                                             <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif <br>
                                        @if($updated->isEmpty())  
                                           <span class="btn btn-danger btn-xs"> pending </span>
                                        @else  
                                           <span class="btn btn-primary btn-xs"> updated </span>
                                        @endif
                                        
                                        </td>
                                        
                                        
                                            
                                           <td>       
                                            <a href="{{url('get_schoolset_item',[$organisation->id,$school->id,$data->id])}}" class="btn btn-primary btn-sm">View </a> 
                                            <br>
                                       <form class="mt-3" action="{{url('/') }}/delete_school_set" method="POST" type="button" onsubmit="return confirm('This category will be delete')">

                                        @csrf

                                        <input type="hidden" name="id" class="form-control" value="{{ $data->id }}" />

                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>

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

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                                    </div>
                                    <!-- Modal body -->

                                    <div class="modal-body" id="cardbody">
                                       
                                           
                                         

                                    </div>

                                </div>

                            </div>

                        </div>
                        
                        <!--end modal-->


<script>
   
   function market_place_fee(feevalueid,set_id)
   {
      var feevalue=document.getElementById(feevalueid).value;
         
         $(".loader").css("display","block");
                $.ajax({
                type: "POST",
                url: "{{url('/') }}/update_set_market_place_fee",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "feevalue": feevalue,
                    "set_id": set_id,
                   
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
                
              if (response.success==0)
                {
                $.toast({  heading:  "<i class='fa fa-warning' ></i> "+response.msg, position: 'top-right',stack: false})
                $(".loader").css("display","none");
                
                }
                else
                {
                $.toast({ heading: response.msg, position: 'top-right',stack: false,icon: 'success'})
                $(".loader").css("display","none");
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
                }

                }
            });
   }
   
   
    function getsetitem(set_id,school_id)
    {
        
       document.getElementById('cardbody').innerHTML="";
                   
        $(".loader").css("display","block"); 

            $.ajax({
                type: "POST",
                url: "{{url('/') }}/get_schoolset_item",
                data: {"_token": "{{ csrf_token() }}","set_id": set_id,'school_id':school_id},
                dataType: 'json',
                cache: false,
                success: function(response) {
                //   alert(JSON.stringify(response));
                var table="";
                var table='<table id="setitem" class="table"><thead><th>#</th><th>Img</th><th>Itemname</th><th>Itemcode</th><th>Qty</th><th>Price</th> </thead><tbody>';
                
              	for(var i=0;i<response.length;i++)
				 {
				     var sn=i+1;
				     var cover_photo='<img src="uploads/book_cover_photo/'+response[i].cover_photo+'" style="width:50px;height:50px">';
				     table+="<tr> <td>"+sn+"</td> <td>"+cover_photo+"</td> <td>"+response[i].itemname+"</td> <td>"+response[i].itemcode+"</td> <td>"+response[i].qty+"</td> <td>"+response[i].unit_price+"</td></tr>";
                 }
                 
                   
                     table+='</tbody></table>';
                     
                     document.getElementById('cardbody').innerHTML += table;
                     
                    $('#myModal').modal('show');
                  	$(".loader").css("display","none");
                
                }
            });
        
    }
</script>
</body>
</html>