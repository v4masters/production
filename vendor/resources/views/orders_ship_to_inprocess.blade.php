<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title> Move Order to Inprocess</title>
    <meta name="description" content="" />
    @include('includes.header_script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        #order_bill{display:none;}
        .table{border:1px solid #1e1e1e;}
        .table:not(.table-dark) th {color: #1e1e1e;}
        .table>:not(caption)>*>* {
        padding: 0.2rem !important;
        border-width: 1px;
        font-size: 12px;
        color: #1e1e1e;
        }
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

                            <div class="card border">

                            <h5 class="card-header">Move Order to Inprocess</h5>

                               <div class="card-body p-3">
                                   <div class="">
                                   <form method="post" id="myform" action="{{url('/') }}/move_order_ship_to_inprocess"  enctype="multipart/form-data" >
                                        @csrf
                                       
                                       <!--msg-->
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
                                        <!--endmsg-->
                                 
           
                                        <div class="row gx-5">
                                            <div class="col-md-12 my-5">
                                                <div class="card">
                                                    
                                         
                                          
                                             <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Order Id :</label>
                                                    <input type="text" class="form-control" name="order_id"  required />
                                                </div>
                                            </div>
                                             <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                           
                                            
                                        </div>   
                                        </form>
                                  </div>
                             

                            </div>

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

</body>
</html>

