<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

    <title>View School Set</title>

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
                                    
                                    <th data-sortable="true"> Set Id </th>
                                    <th data-sortable="true"> Org/Board/Grade </th>
                                    <th data-sortable="true"> Class/Cat/Type </th>
                                     <th data-sortable="true">School Info </th>
                                    <th data-sortable="true"> Qty</th>
                                    <th data-sortable="true"> Action/Status</th>
                               
        
                                </tr>

                            </thead>
                            <tbody>
                             
                             @foreach($all_set as $key => $data)
                                 @php
                                  $key++;
                                  @endphp
                                       
                             <tr>
                                 <td>{{$key}}</td>
                                 <td>{{$data->set_id}}</td>
                                
                                 <td><b>Org-</b>{{$data->org_title}}<br><b>Board-</b>{{$data->board}}<br><b>Grade-</b>{{$data->grade}}</td>
                                 <td><b>Class-</b>{{$data->setclass}}<br><b>Cat-</b>{{$data->cat_title}}<br><b>Type-</b>{{$data->type_title}}</td>
                                 <td><b>{{$data->school_code}}<br>{{$data->school_name}}</b><br>{{$data->state}},{{$data->distt}},{{$data->city}},<br>{{$data->tehsil}},{{$data->post_office}},{{$data->zipcode}}</td>
                                 <td>{{$data->set_qty}}</td>
                                 <td><button type="button" class="btn btn-primary btn-sm" onclick="getsetitem(`{{$data->set_id}}`,`{{$data->shipping_charges}}`,`{{$data->shipping_chr_type}}`)">View </button>
                                 
                                 
                                 <br>
                                 <br>
                                 
                                 
                                   <form class="mb-3" action="{{url('/')}}/delete_vendor_set" method="POST" type="button" onsubmit="return confirm('Do realy want to delete this set permanently!')">
                                    @csrf
                                   <input type="hidden" name="id" class="form-control" value="{{$data->id}}" />
                                   <input type="hidden" name="set_id" class="form-control" value="{{$data->set_id}}" />
                                   <button type="submit" class="btn btn-danger btn-sm"><i class=" bx bx-trash"></i></button>
                                   </form>
                                   
                                    @if($data->stock_status==1)
                                    <button type="button" title="Click to make set out of stock" class="btn-xs btn btn-success" onclick="update_stock_status(`{{$data->id}}`,`{{$data->set_id}}`,`0`)">In Stock</button>
                                     @else
                                     <button type="button" title="Click to make set in of stock" class="btn-xs btn btn-danger" onclick="update_stock_status(`{{$data->id}}`,`{{$data->set_id}}`,`1`)">Out Of Stock</button>
                                    @endif
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

        </div>
        
        
        
           <div class="modal" id="myModal">

                            <div class="modal-dialog modal-lg">

                                <div class="modal-content">

                                    <!-- Modal Header -->

                                    <div class="modal-header">

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                                    </div>


                                    <!-- Modal body -->

                                    <div class="modal-body">
                                        <div id="itemdiv"></div>
                                       <table id="table" class="table table-striped" data-toggle="table"  data-toolbar="#toolbar"  data-show-export="true">
                                           <thead> 
                                           <tr>
                                               <th>#</th>
                                               <th > Img </th>
                                               <th > Itemname </th>
                                               <th  >ItemCode</th>
                                               <th > Unit Price</th>
                                               <th >Qty</th>
                                               <th >Discount%</th>
                                               </tr></thead>
                                        <tbody>
                                                
                                               
                                        </tbody>
                                        </table>
                                        
                                        <div id="tabledataform"></div>

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


    <!-- footerscrit -->
    <script>
// function runningFormatter(value, row, index) {
// return 1+index;
// }



     


        
        
//         //ajaxs
        function getsetitem(set_id,ship_charges,ship_type) {
            $(".loader").css("display","block");
            $("#itemdiv").html('<h5> SET ID - '+set_id+'</h5>');   
            $("#tabledataform").html(''); 
            $('table> tbody:last').html('');   
            
            if(ship_type==1){var oldfrm='selected';}else{var oldfrm='selected';}
            if(ship_type==2){var newfrm='selected';}else{var newfrm='';}
            
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
                  
                var tabledata='';
                                         
                    
                 for(var i=0;i<response.length;i++)
				 {
				     const id=i+1;
				     tabledata+='<tr><td>'+id+'</td><td>'+response[i].img+'</td><td>'+response[i].itemname+'</td><td>'+response[i].itemcode+'</td><td>'+response[i].unit_price+'</td><td>'+response[i].qty+'</td><td>'+response[i].discount+'</td></tr>';
                    
                 }
                  var tabledataform='<form method="post" id="myform" action="{{url('/') }}/update_vendor_set_ship" enctype="multipart/form-data" novalidate>@csrf<input type="hidden" name="set_id" value="'+set_id+'" id="set_id"><div class="form-group p-3"><select class="form-select" data-placeholder="&#xF4FA;" onchange="sel_shipping_chr_type(this.value)" name="shipping_chr_type" required><option disabled="disabled" selected="selected">Select Shipping Type </option><option value="1" '+oldfrm+'>Old  Formula </option><option value="2" '+newfrm+'>New Formula (Less Than ₹1000  ₹20 + 18% GST)</option></select></div><div class="form-group p-3"><label class="form-label">Update Shipping Charges:</label><input type="number" class="form-control" name="shipping_charges" value="'+ship_charges+'" required><br><button type="submit" class="btn btn-primary">Update Shipping</button></div></form>';
                 
                    $('#tabledataform').append(tabledataform);	 
                    $('table> tbody:last').append(tabledata);   
                    $(".loader").css("display","none");
                    $('#myModal').modal('show');
                }
            });
        }


function update_stock_status(id,set_id,status)
{
       $(".loader").css("display","block");
       $.ajax({
                type: "POST",
                url: "{{url('/') }}/update_stock_status",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                     "set_id": set_id,
                      "status": status,
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
                
               
        if(response.success==0)
        {
        $.toast({  heading:  "<i class='fa fa-warning' ></i> "+response.msg, position: 'top-right',stack: false})
        $(".loader").css("display","none");
        }
        else
        {
        $.toast({ heading: response.msg, position: 'top-right',stack: false,icon: 'success'})
        $(".loader").css("display","none");
        setTimeout(function(){window.location.reload();}, 2000);
        }
        
        
        }
        }); 
        
}

    </script>
</body>
</html>