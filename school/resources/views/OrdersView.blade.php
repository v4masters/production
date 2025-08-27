<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

    <title>Student View</title>

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

                                <div class="w-25">
                                    <form id="formAuthentication" class="mb-3" action="{{url('/') }}/ordersView" method="POST">
                                        @csrf
                                        <select id='order_status' name='order_status' class="" aria-label="Default select example">
                                            <option selected>Open this select menu</option>
                                            <option value="1">Pending</option>
                                            <option value="2">Placed</option>
                                            <option value="3">In Progress</option>
                                            <option value="4">Delivered</option>
                                            <option value="5">Cancelled</option>
                                        </select>
                                        <button type="submit" class="btn btn-success">Get</button>
                                    </form>
                                </div>



                                <div class="table-responsive text-nowrap">


                                    <table class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-show-footer="true" data-response-handler="responseHandler">

                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Invoice Number</th>
                                                <!--<th>User Id</th>-->
                                                <th>User</th>
                                                <!--<th>Vendor Id</th>-->
                                                <th>Batch Id</th>
                                                <th>Class</th>
                                                <th>Order Total</th>
                                                <th>Grand Total</th>
                                                <th>Discount</th>
                                                <th>Shipping Charge</th>
                                                <th>Mode of Payment</th>
                                                <th>Order Status</th>
                                                <th>Order Time</th>
                                                <!--<th>Delivery Status</th>-->
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>

                                        </thead>

                                        <tbody>
                                            
                                             @php
                                           $totalsale=0;
                                            @endphp
                                            @foreach($students as $key => $data)
                                            @php
                                            $key++;
                                            $totalsale+=$data->grand_total-$data->shipping_charge;
                                            @endphp
                                            <tr>
                                                <td>{{$key}}</td>
                                                <td>{{$data->invoice_number}}</td>
                                                <!--<td>{{$data->user_id}} </td>-->
                                                <td>{{$data->first_name}} {{$data->first_name}}</td>
                                                <!--<td>{{$data->vendor_id}}</td>-->
                                                <td>{{$data->batch_id}}</td>
                                                <td>{{$data->class}}</td>
                                                <td>{{$data->order_total}}</td>
                                                <td>{{$data->grand_total}}</td>
                                                <td>{{$data->discount}}</td>
                                                <td>{{$data->shipping_charge}}</td>
                                                <td>@if($data->mode_of_payment==1) Online @else COD @endif</td>


                                                <td>
                                                    @switch($data->order_status)
                                                    @case(1)
                                                    Pending
                                                    @break

                                                    @case(2)
                                                    Placed
                                                    @break

                                                    @case(3)
                                                    In Process
                                                    @break

                                                    @case(4)
                                                    Delivered
                                                    @break

                                                    @case(5)
                                                    Cancelled
                                                    @break

                                                    @default
                                                    Default case...
                                                    @endswitch
                                                </td>

                                                <td>{{$data->order_time}}</td>
                                                <!--<td>{{$data->delivery_status}}</td>-->

                                                <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>
                                                <td>
                                                    <button type="button" onclick="getOrderDetail(`{{$data->invoice_number}}`)" class="btn-sm btn btn-primary">View</button><br><br>
                                                    <!-- <button type="button" onclick="cancle_order(`{{$data->invoice_number}}`)" class="btn-sm btn btn-danger">Cancle</button> -->
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
        < script type = "text/javascript" >
            $(document).ready(function() {
                $("#filter_type").change(function() {
                    var id = $(this).val();
                    console.log(id);
                    var dataString = 'id=' + id;
                    console.log(dataString);
                    $.ajax({
                        type: "GET",
                        url: "{{url('/users/abc')}}",
                        data: dataString,
                        cache: false,
                        success: function(data) {
                            console.log(data); // I get error and success function does not execute
                        }
                    });

                });

            });
    </script>


    <script>
        function sendData() {
            alert($('#order_status').val());
            $.ajax({
                type: "POST",
                url: '{{url("/")}}/',
                data: {

                    'order_status': $('#order_status').val(),
                    '_token': '{{csrf_token()}}'
                },
                success: function(response) {

                }
            });
        }
    </script>
    <script>
        function getsetitem(set_id) {

            $("#itemdivsetid").html('<h5> SET ID - ' + set_id + '</h5>');
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

                    var tabledata = ' <table id="table" class="table table-striped"><thead> <tr><th>#</th><th > Img </th><th > Itemname </th><th  >ItemCode</th><th > Unit Price</th><th >Qty</th></tr></thead> <tbody>';


                    for (var i = 0; i < response.length; i++) {
                        const id = i + 1;
                        tabledata += '<tr><td>' + id + '</td><td>' + response[i].img + '</td><td>' + response[i].itemname + '</td><td>' + response[i].itemcode + '</td><td>' + response[i].unit_price + '</td><td>' + response[i].qty + '</td></tr>';

                    }
                    tabledata += ' </tbody></table>';

                    $('#itemdiv').append(tabledata);
                    $('#myModal').modal('show');

                }
            });
        }
    </script>
</body>

</html>