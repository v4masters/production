<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />

  <title>Manage Master Organisation</title>

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

              <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">Add Master Organisation</h5>

              </div>

              <div class="card-body">
                  
                <form action="{{url('/') }}/manageorganisation" method="POST" enctype="multipart/form-data">

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
   
                  <div class="row">
                      
                  <div class="col-sm-6">

                    <div class="form-group mb-3">

                      <label class="form-label">Organisation Name: <span class="required">*</span></label>

                      <input type="text" class="form-control" name="name" required />

                    </div>

                  </div>
                  
                   <div class="col-sm-6">

                    <div class="form-group mb-3">

                      <label class="form-label">Email: <span class="required">*</span></label>

                      <input type="email" class="form-control" name="email"  required/>

                    </div>

                  </div>
                  
                     <div class="col-sm-4">

                    <div class="form-group mb-3">

                      <label class="form-label">Phone Number: <span class="required">*</span></label>

                      <input type="tel" class="form-control" name="phone" required />

                    </div>

                  </div>
                  
                     <div class="col-sm-4">

                    <div class="form-group mb-3">

                      <label class="form-label">Whatsapp Number: <span class="required">*</span></label>

                      <input type="tel" class="form-control" name="whatsapp_number" required />

                    </div>

                  </div>
                  
                       <div class="col-sm-4">

                    <div class="form-group mb-3">

                      <label class="form-label">Zip code: <span class="required">*</span></label>

                      <input type="number" class="form-control" name="zip_code" required />

                    </div>

                  </div>
               
                     <div class="col-sm-4">

                    <div class="form-group mb-3">

                      <label class="form-label">City: <span class="required">*</span></label>

                      <input type="text" class="form-control" name="city" required />

                    </div>

                  </div>
                  
                  
                     <div class="col-sm-4">

                    <div class="form-group mb-3">

                      <label class="form-label">State: <span class="required">*</span></label>

                      <input type="text" class="form-control" name="state" required />

                    </div>

                  </div>
                  
                     <div class="col-sm-4">

                    <div class="form-group mb-3">

                      <label class="form-label">Country: <span class="required">*</span></label>

                      <input type="text" class="form-control" name="country" required />

                    </div>

                  </div>
                  
                  
                     <div class="col-sm-5">

                    <div class="form-group mb-3">

                      <label class="form-label">Address: <span class="required">*</span></label>

                     <textarea class="form-control" name="address"></textarea>
                     
                    </div>

                  </div>
                  
  
                </div>
                
                  <button type="submit" class="btn btn-success">Save </button>

                </form>
              

              </div>

            </div>

            <div class="table-responsive text-nowrap">

              <table class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-show-footer="true" data-response-handler="responseHandler">

                <thead>

                  <tr>

                    <th>#</th>

                    <th>Organisation Name</th>
                    
                    <th>Email</th>
                     
                    <th>Phone number</th>
                    
                    <th data-visible="false" data-sortable="true">Whatsapp number</th>
                    
                    <th data-visible="false" data-sortable="true">Address</th>
                    
                    <th data-visible="false" data-sortable="true">Country</th>
                    
                    <th data-visible="false" data-sortable="true">City</th>
                    
                    <th data-visible="false" data-sortable="true">State</th>
                    
                    <th data-visible="false" data-sortable="true">Zip Code</th>

                    <th>Status</th>

                    <th>Action</th>

                  </tr>

                </thead>

                <tbody>

                  @foreach($pagedata as $key => $data)

                  @php

                  $key++;

                  @endphp

                  <tr>

                    <td>{{$key}}</td>

                    <td>{{$data->name}}</td>
                    
                    <td>{{$data->email}}</td>
                    
                    <td>{{$data->phone}}</td>
                    
                    <td>{{$data->whatsapp_number}}</td>
                    
                    <td>{{$data->address}}</td>
                    
                    <td>{{$data->country}}</td>
                    
                    <td>{{$data->city}}</td>
                    
                    <td>{{$data->state}}</td>
                    
                     <td>{{$data->zip_code}}</td>

                    <td>@if($data->status==1)<span class="btn btn-success btn-xs">Active</span>@else <span class="btn btn-warning btn-xs">Inactive</span>@endif</td>

                    <td>
                        
                      <ul class="list-inline">
                          
                        <li class="list-inline-item"><a href="{{url('editmasterorganisation',$data->id)}}" class="btn btn-primary btn-sm"><i class=" bx bx-pencil"></i></a></li>
                        <li class="list-inline-item">
                            
                          <form class="mb-3" action="{{url('/') }}/deleteorganisation" method="POST" type="button" onsubmit="return confirm('This Organisation will be delete')">

                            @csrf

                            <input type="hidden" name="id" class="form-control" value="{{ $data->id }}" />

                            <button type="submit" class="btn btn-danger btn-sm"><i class=" bx bx-trash"></i></button>
                        </li>

                        </form>
                        
                      </ul>
                      
                    </td>

                  </tr>

                  @endforeach

                </tbody>

              </table>

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

</body>

</html>