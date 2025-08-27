<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

    <title>School Set</title>

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
        
        #shipping_charges_div
        {
            display:none;
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


                         <form method="post" id="myform" action="{{url('/') }}/add_vendor_set" enctype="multipart/form-data" novalidate>
                             
                             @csrf
                                        
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
                                        
                                        
                             <input type='hidden' name='org_title_id' id="org_title_id">
                             <input type='hidden' name='board_id' id="board_id">
                             <input type='hidden' name='grade_id' id="grade_id">
                             <input type='hidden' name='setclass_id' id="setclass_id">
                             <input type='hidden' name='cat_title_id' id="cat_title_id">
                             <input type='hidden' name='type_title_id' id="type_title_id">
                              <input type='hidden' name='school_id' id="school_id">
                     
                            <div class="card mb-4">

                                <div class="card-header d-flex justify-content-between align-items-center">

                                    <h4 class="" id="heading">

                                       Add School Set

                                    </h4>

                                </div>

                                <div class="card-body">

                                        <div class="row gx-5">

                                            <div class="col-sm-12">

                                                <div class="mb-3">

                                                    <label class="form-label">Set Id:</label>

                                                    <input type="text" class="form-control" name="set_id" id="set_id" required />
                                                     <div class="invalid-feedback">Please select a valid state.</div>
                                                </div>

                                            </div>
                                         </div>
                                          
                                        <button type="button" onclick="getsetdata()" class="btn btn-primary">Get</button>

                                </div>

                            </div>
                            
                        <div style="display:none;" id="content_div">    
                                 <div class="card">
                         <div class="card-header justify-content-between align-items-center">


                        <h5 class="card-header ">Display  Set Item </h5>
                        <h5 class="text-danger" id="set_exist_msg" style="display:none;">Set Already Exist. </h5> 
                  
                          <h4 id="info1" style="color: #696cff;text-align: left;background-color: rgba(105, 108, 255, 0.16) !important;" class="btn">
                          <b>Organisation : </b> <span id="org_title"></span><br>
                          <b>Set Category : </b>  <span id="cat_title"></span><br>
                           <!--<b>School (Code) : </b>  <span id="school_code"></span><br>-->
                        
                        </h4>
                          
                        
                          <h4 id="info2" style="color: #696cff;text-align: left;background-color: rgba(105, 108, 255, 0.16) !important;" class="btn">
                          
                          <b>Set Class : </b> <span id="setclass"></span><br>
                           <b>Set Type : </b> <span id="type_title"></span><br></h4>
                          
                        
                             <h4 id="info3" style="color: #696cff;text-align: left;background-color: rgba(105, 108, 255, 0.16) !important;" class="btn">
                          
                         
                          <b>Set Board : </b> <span id="board"></span><br>
                            <b>Set Grade : </b> <span id="grade"></span></h4>
                          
 <h4 id="info1" style="color: #696cff;text-align: left;background-color: rgba(105, 108, 255, 0.16) !important;" class="btn">
                          <!--<b>Organisation : </b> <span id="org_title"></span><br>-->
                          <!--<b>Set Category : </b>  <span id="cat_title"></span><br>-->
                           <b>School (Code) : </b>  <span id="school_code"></span><br>
                           <b>Total Weight : </b>  <span id="item_weight"></span> Gm<br>
                           
                           
                        
                        </h4>

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
                        data-page-list="[10, 25, 50, 100, 200, 500, 1000 all]"
                        data-show-footer="true" 
                        data-response-handler="responseHandler">

                            <thead>
                                <tr>
                                    <th data-formatter="runningFormatter" class="cell">#</th>
                                    
                                    <th data-field="img"> Img </th>
                                    <th data-field="itemname"> Itemname </th>
                                     <th data-field="itemcode" data-sortable="true">ItemCode</th>
                                    <th data-field="unit_price" data-sortable="true"> Unit Price</th>
                                    <th data-field="qty">Qty</th>
                                    <th data-field="discount">Discount %</th>
                               
                                    
                                </tr>

                            </thead>
                            <tbody>
                             
                            </tbody>
                        </table>
                        
                        
                        
                        
                       
                        
                        
                        <div class="m-5" id="submit_btn" style="display:none;">
                            
                         <div class="form-group p-3">
                              
                                <select class="form-select" data-placeholder="&#xF4FA;" onchange="sel_shipping_chr_type(this.value)" name="shipping_chr_type" required>

                                                        <option disabled="disabled" selected="selected">Select Shipping Type </option>
                                                        
                                                        <option value="1">Old  Formula </option>
                                                        <option value="2">New Formula (Less Than ₹1000  ₹20 + 18% GST)</option>
                                                       

                                </select>
                                                    
                                                    
                        </div>
                        
                            
                        <div class="form-group p-3" id="shipping_charges_div">
                              <label class="form-label">Shipping Charges:</label>
                             <input type='number' class="form-control" name='shipping_charges' id="shipping_charges">
                        </div>
                        
                        <!--  <div class="form-group p-3">=-->
                        <!--        <select class="form-select" data-placeholder="&#xF4FA;" name="pickup_point">-->
                        <!--                                <option disabled="disabled" selected="selected">Select Pickup Point </option>-->
                                                        <!--<option value="not available">N/A </option>-->
                        <!--                                @foreach($pickuppoints as $key => $pickup)-->
                        <!--                                <option value="{{$pickup->id}}">{{$pickup->pickup_point_name}}</option>-->
                        <!--                                @endforeach-->
                        <!--        </select>-->
                                                    
                                                    
                        <!--</div>-->
                        
                         <div class="form-group p-3">
                         <button type="submit" class="btn btn-primary">Add Set</button>
                         </div>
                       </div>
                       
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

        <!-- Overlay -->
        <div class="allimgmodal"></div>
        <div class="layout-overlay layout-menu-toggle"></div>

    </div>




    <!-- / Layout wrapper -->

    @include('includes.footer_script')


    <!-- footerscrit -->
<script>
    
function sel_shipping_chr_type(selval)
{
  if(selval==1)
  {
     $("#shipping_charges_div").css("display","block");
  }
  else
  {
      $("#shipping_charges_div").css("display","none");  
  }
}
    
function runningFormatter(value, row, index) {
return 1+index;
}
        //ajaxs
        function getsetdata() {
           
          var set_id= document.getElementById('set_id').value;

            $.ajax({
                type: "POST",
                url: "{{url('/') }}/get_set_data_by_id",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "set_id": set_id
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
                    
                    // alert(response.isSetExist);
                    if(response.isSetExist==0)
                    {
                        
                    document.getElementById('org_title_id').value=response.setdetail.org_title_id;
                    document.getElementById('cat_title_id').value=response.setdetail.cat_title_id;
                    document.getElementById('type_title_id').value=response.setdetail.type_title_id;
                    document.getElementById('setclass_id').value=response.setdetail.setclass_id;
                    document.getElementById('board_id').value=response.setdetail.board_id;
                    document.getElementById('grade_id').value=response.setdetail.grade_id;
                    document.getElementById('school_id').value=response.setdetail.school_id;
                    
                    
                     $("#submit_btn").css("display","block");  
                     $("#set_exist_msg").css("display","none");  
                     
                    }
                    else
                    {
                       
                       document.getElementById('org_title_id').value='';
                    document.getElementById('cat_title_id').value='';
                    document.getElementById('type_title_id').value='';
                    document.getElementById('setclass_id').value='';
                    document.getElementById('board_id').value='';
                    document.getElementById('grade_id').value='';
                    document.getElementById('school_id').value=''; 
                     $("#submit_btn").css("display","none");  
                       $("#set_exist_msg").css("display","block");  
                    }
                   
                    
                    $('#org_title').html(response.setdetail.org_title);
                    $('#cat_title').html(response.setdetail.cat_title);
                    $('#school_code').html(response.setdetail.school_name+' (Code: '+response.setdetail.school_code+') ');
                    $('#type_title').html(response.setdetail.type_title);
                    $('#setclass').html(response.setdetail.setclass);
                    $('#board').html(response.setdetail.board);
                    $('#grade').html(response.setdetail.grade);
                    $('#item_weight').html(response.item_weight);
                     
                     
                    $('#table').bootstrapTable('load', JSON.parse(JSON.stringify(response.items)));
                    $("#content_div").css("display","block");
                    
                	 
                         
        
                }
            });
        }




    </script>
</body>
</html>