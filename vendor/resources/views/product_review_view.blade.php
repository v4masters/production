<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>New Orders</title>
    <meta name="description" content="" />
    @include('includes.header_script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        p{margin: 0 !important;border-bottom: 1px solid #ddd;width:auto;}
        .amountdiv{width: fit-content;}
    </style>
</head>
<body>

    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            @include('includes.sidebar')

            <div class="layout-page">

                @include('includes.header')

                <div class="container mt-3">

                    <div class="card mb-4">

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <div class="container">

                            </div>

                        </div>

                        <div class="container">

                            <div class="card">

                                <h5 class="card-header">Product Review Edit</h5>

                                <div class="table-responsive text-nowrap">

                                    <table class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">

                                        <thead>
                                            <tr>
                                               <th>#</th>
                                                <th data-sortable="true">User Id</th>
                                                <th data-sortable="true">Product Id</th>
                                                <th data-sortable="true">Review Comment</th>
                                                <th data-sortable="true">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reviews as $key => $data)
                                            @php
                                            $key++;
                                            @endphp
                                            <tr>
                                                <td>{{$key}}</td>
                                                <td>{{$data->user_id}}</td>
                                                <td>{{$data->product_id}}</td>
                                                <td>{{$data->review_comment}}</td>
                                                <td>
                                                    
                                                    @if($data->status==2)<span class="bg-info text-white p-1">{{'Pending';}}</span>
                                                    @elseif($data->status==1)<span class="bg-success text-white p-1">{{'Approved';}}</span>
                                                    @elseif($data->status==0)<span class="bg-danger text-white p-1">{{'Rejected';}}</span>
                                                    @endif
                                                    <li class="list-inline-item"> <a href="{{url('product_review_edit_view',$data->id)}}" class="btn btn-primary btn-sm"><i class=" bx bx-pencil"></i></a> </li>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




        
                     
                     
                     <!---->
                      <div class="modal" id="order_detail">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        
                                        <div class="row">
                                            <div class="col-md-5">
                                                <h4>Shipping Address</h4>
                                                   <div id="user_info">
                                            
                                                   </div>
                                            </div>
                                             <div class="col-md-7">
                                                 <h4>Order Info</h4>
                                                 <div id="order_info">
                                            
                                                 </div>
                                            </div>
                                        </div>
                                        
                                        <div id="itemdiv">
                                            
                                        </div>
                                        
                                       
                                    </div>
                                    
                                       <div class="divfooter text-left p-3" id="amount_div">
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>



	

                <footer class="default-footer">

                    @include('includes.footer')</footer>

                <div class="content-backdrop fade"></div>

            </div>

        </div>

    </div>
    <div class="layout-overlay layout-menu-toggle"></div>

    @include('includes.footer_script')

<script>
function copy(that){
var inp =document.createElement('input');
document.body.appendChild(inp)
inp.value =that.textContent
inp.select();
document.execCommand('copy',false);
inp.remove();
}


      //getOrderDetail
        function getOrderDetail(Orderid) {
            $(".loader").css("display","block");
            
            
            $("#user_info").html(''); 
            $("#itemdiv").html(''); 
            $("#amount_div").html(''); 
            $("#order_info").html(''); 
            
            
            $.ajax({
                type: "POST",
                url: "{{url('/') }}/get_order_item_details",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": Orderid
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
                // alert(response.item_info[0].);    
                var tabledata=' <table id="table" class="table table-striped"><thead> <tr><th>#</th><th >ItemCode</th><th>Itemname</th><th>Cat<th>Rate</th><th >Qty</th><th>Gst</th><th> Without<br>Gst</th></tr></thead> <tbody>';
                 for(var i=0;i<response.item_info.length;i++)
				 {
				     const id=i+1;
				     tabledata+='<tr><td>'+id+'</td><td>'+response.item_info[i].item_id+'</td><td>'+response.item_info[i].itemname+'</td><td>'+response.item_info[i].cat+'</td><td>'+response.item_info[i].rate+'</td><td>'+response.item_info[i].qty+'</td><td>'+response.item_info[i].gst+'</td><td>'+response.item_info[i].total_without_gst+'</td></tr>';
                  
                 }
                 tabledata+=' </tbody></table>';
                 $('#itemdiv').append(tabledata);
            
                 var amount_div='<div class="row"><div class="col-md-9"><p class="amountdiv"><b>Total Amount: </b>'+response.order_info.total_amount+'</p><p class="amountdiv"><b>Total Amt Without Gst :</b> '+response.order_info.total_wo_gst_amount+'</p><p class="amountdiv"><b>Total Discount : </b>'+response.order_info.total_discount+'</p><p class="amountdiv"><b>Total Shipping Amt :</b> '+response.order_info.total_shipping+'</p></div><div class="col-md-3"><button type="button" onclick="accept_order(`'+response.order_info.invoice_number+'`)" class="btn btn-success">Accept Order</button></div></div>';
                 $('#amount_div').append(amount_div);
                
                 var user_info='<span class="userdiv"><b>'+response.order_info.name+'</b> , '+response.order_info.phone_no+','+response.order_info.alternate_phone+',<br>'+response.order_info.school_name+',('+response.order_info.school_code+')<br>'+response.order_info.state+','+response.order_info.district+'<br>'+response.order_info.city+','+response.order_info.village+'<br>'+response.order_info.address+'<br>'+response.order_info.post_office+'('+response.order_info.pincode+')</span>';
                 $('#user_info').append(user_info);
                 
                 var order_info='<p class="orderdiv"><b>OID-</b> '+response.order_info.invoice_number+'</p><p class="orderdiv"><b>TID-</b> '+response.order_info.transaction_id+'</p><p class="orderdiv"><b>Date-</b> '+response.order_info.transaction_date+'</p><p class="orderdiv"><b>MOD-</b> '+response.order_info.mop+'</p>';
                 $('#order_info').append(order_info);
                
            

                 $(".loader").css("display","none");
                 $('#order_detail').modal('show');
                }
            });
        }
        
   
   
   
   function accept_order(order_id)
   {
       $(".loader").css("display","block");
                $.ajax({
                type: "POST",
                url: "{{url('/') }}/accept_order",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id
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
                // setTimeout(function(){
                    
                    window.location.reload();
                    
                    
                // }, 2000);
                }

                }
            });
   }
   
   
   //cancle_order
    function cancle_order(order_id)
   {
       $(".loader").css("display","block");
                $.ajax({
                type: "POST",
                url: "{{url('/') }}/cancle_order",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id
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
</script>

</body>
</html>

