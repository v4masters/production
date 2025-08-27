<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">



<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>View Sub Sub Category</title>

    <meta name="description" content="" />

    @include('includes.header_script')

<style>
    .sizelist{
     padding:  10px;
    background: rgba(105, 108, 255, 0.16) !important;
    list-style: none;
    font-weight: 700;
    color: #696cff;
    width: 60%;
}
.subcats {
            border: 4px solid #E7E7FF;
            background-color: #E7E7FF;
            color: #696CFF;
        }

        .subcats:hover {
            border: 4px solid #E7E7FF;
            background-color: #E7E7FF;
            color: #696CFF;
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

                                <div class="row">

                                    <div class="col-md-12">
                                        <h5 class="mb-0 btn subcats  btn-md"><b>Category : </b>{{$category->name}}</h5>
                                    </div>

                                </div>

                                <br>

                                <div class="row">

                                    <div class="col-md-12">
                                        <h5 class="mb-0 btn btn-primary btn-md"><b>Sub Category : </b>{{$subcategory->name}}</h5>
                                    </div>

                                </div> <br>

                                <div class="row">

                                    <div class="col-md-12">
                                        <h5 class="mb-0 btn subcats btn-md"><b>Sub Sub Category : </b>{{$subcategory_two->title}}</h5>
                                    </div>
                                   
                                </div>
                                <br>
                                <div class="row">

                                    <div class="col-md-12">
                                        <h5 class="mb-0 btn btn-primary btn-md"><b>Sub Sub Sub Category : </b>{{$subsubsubcategory->title}}</h5>
                                    </div>

                                </div>

                            </div>

                        </div>



                        <div class="container">

                            <div class="card">
                                <div class="row">

                                    <div class="col-md-12">
                                        <h5 class="card-header">Sizes:</h5>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-12 offset-md-2">


                                        <ul>
                                            
                                            @foreach($size_list as $key => $size_listdata)

                                            <li class="sizelist mt-3 "> <i class="bx bx-circle"></i> {{$size_listdata->title}} </li>

                                            @endforeach

                                        </ul>

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