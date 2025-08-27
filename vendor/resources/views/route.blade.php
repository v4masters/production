<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Routes</title>

    <meta name="description" content="" />

    <!-- Headerscript -->

    @include('includes.header_script')
    
    <style>
        #source_map,#destination_map {
            width: 100%;
            height: 400px;
        }
    </style>

</head>

<body>

    <!-- Layout wrapper -->

    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            @include('includes.sidebar')

            <!-- Menu -->

            <!-- Layout container -->

            <div class="layout-page">

                <!-- Navbar -->

                @include('includes.header')

                <!-- Navbar -->

                <!-- Centered Form -->


                <!--Create Routes-->
                <div class="container mt-3">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Create Route</h5>
                        </div>

                        <div class="card-body">
                            <form id="formAuthentication" class="mb-3" action="{{url('/') }}/create_route" method="POST">
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

                                <input type="hidden" name="id" class="form-control" value="" required />

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">School Code</label>
                                            <input type="text" class="form-control" name="schoolcode" value="" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6"></div>
                                    <!--Source-->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Source</label>
                                            <textarea class="form-control" name="source">{{$vendor_source}}</textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Google Source</label>
                                            <textarea class="form-control" name="google_source" id="google_source"></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Source Latitude</label>
                                            <input class="form-control" name="source_latitude" id="source_latitude"></input>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Source Longitude</label>
                                            <input class="form-control" name="source_longitude" id="source_longitude"></input>
                                        </div>
                                        <!--Map-->
                                         <!-- search bar on map -->
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <input id="source_search" class="form-control rounded w-25 mt-3"
                                                    type="text" placeholder="Search Google Map">
                                            </div>
                                        </div>
                                        <!-- add map div -->
                                        <div class='border' id="source_map"></div>
                                    </div>
                                    
                                    <!--Destination-->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Destination</label>
                                            <textarea class="form-control" name="destination"></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Google Destination</label>
                                            <textarea class="form-control" name="google_destination" id="google_destination"></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Destination Latitude</label>
                                            <input class="form-control" name="destination_latitude" id="destination_latitude"></input>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Destination Longitude</label>
                                            <input class="form-control" name="destination_longitude" id="destination_longitude"></input>
                                        </div>
                                        <!--Map-->
                                         <!-- search bar on map -->
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <input id="destination_search" class="form-control rounded w-25 mt-3"
                                                    type="text" placeholder="Search Google Map">
                                            </div>
                                        </div>
                                        <!-- add map div -->
                                        <div class='border' id="destination_map"></div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                
                <!--View Routes-->
                <div class="container mt-3">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="container">
                            </div>
                        </div>
                        <div class="container">
                            <div class="card">
                                <h5 class="card-header">View New Order</h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-striped" data-toggle="table" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="true" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, 500, 1000 ,all]" data-show-footer="true" data-response-handler="responseHandler">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-sortable="true">Route Id</th>
                                                <th data-sortable="true">Source</th>
                                                <th data-sortable="true">Destination</th>
                                                <th data-sortable="true">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($routes_data as $key=>$data)
                                                @php
                                                $key=1;
                                                    $key++;
                                                @endphp
                                                <tr>
                                                    <td>{{$key}}</td>
                                                    <td>{{$data->unique_id}}</td>
                                                    <td>{{$data->source}}</td>
                                                    <td>{{$data->destination}}</td>
                                                    <td>
                                                        <a href="{{ url('route_edit/'.$data->unique_id) }}" class="btn-sm btn btn-primary">Edit</a>
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

                <!-- Footer -->
                <footer class="default-footer">
                    @include('includes.footer')
                    <!-- Footer -->
                    <div class="content-backdrop fade"></div>
                </footer>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- Layout page -->
    </div>
    <!-- Overlay -->

    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Layout wrapper -->
    @include('includes.footer_script')
    <!-- Footerscript -->
    
    
    
    <!--Google Map Api-->
     <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkXHcTsdrUyZ3Rbt8J8u5SD0lSp7Md4AI&libraries=places&callback=initMap">
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkXHcTsdrUyZ3Rbt8J8u5SD0lSp7Md4AI&libraries=places&callback=initMap2">
    </script>

    <!--//Source-->
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('source_map'), {
                center: {
                    lat: 28.7041,
                    lng: 77.1025
                },
                zoom: 8
            });

            var input = document.getElementById('source_search');

            var searchBox = new google.maps.places.SearchBox(input);

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];

            searchBox.addListener('places_changed', function() {

                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                markers.forEach(function(marker) {
                    marker.setMap(null);
                });

                markers = [];

                var bounds = new google.maps.LatLngBounds();

                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    markers.push(new google.maps.Marker({
                        map: map,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }

                });

                map.fitBounds(bounds);

            });



            map.addListener('click', function(e) {
                placeMarkerAndPanTo(e.latLng, map);
            });



            function placeMarkerAndPanTo(latLng, map) {
                clearMarkers();
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map
                });

                markers.push(marker);
                map.panTo(latLng);

                // Update latitude and longitude form fields

                document.getElementById('source_latitude').value = latLng.lat();

                document.getElementById('source_longitude').value = latLng.lng();

            }



            function clearMarkers() {
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];
            }
        }

        initMap();
    </script>
    
    <!--//Destination-->
    <script>
        function initMap2() {
            var map = new google.maps.Map(document.getElementById('destination_map'), {
                center: {
                    lat: 28.7041,
                    lng: 77.1025
                },
                zoom: 8
            });

            var input = document.getElementById('destination_search');

            var searchBox = new google.maps.places.SearchBox(input);

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];

            searchBox.addListener('places_changed', function() {

                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                markers.forEach(function(marker) {
                    marker.setMap(null);
                });

                markers = [];

                var bounds = new google.maps.LatLngBounds();

                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    markers.push(new google.maps.Marker({
                        map: map,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }

                });

                map.fitBounds(bounds);

            });



            map.addListener('click', function(e) {
                placeMarkerAndPanTo(e.latLng, map);
            });



            function placeMarkerAndPanTo(latLng, map) {
                clearMarkers();
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map
                });

                markers.push(marker);
                map.panTo(latLng);

                // Update latitude and longitude form fields
                document.getElementById('destination_latitude').value = latLng.lat();
                document.getElementById('destination_longitude').value = latLng.lng();
            }



            function clearMarkers() {
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];
            }
        }

        initMap2();
    </script>

</body>

</html>