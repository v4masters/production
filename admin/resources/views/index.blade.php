<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta  name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0"/>
    <title>Dashboard </title>
    <meta name="description" content="" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    
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
              <div class="row">
                <div class="col-lg-8 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                        <!--  <h5 class="card-title text-primary">Congratulations Admin! ðŸŽ‰</h5>
                          <p class="mb-4">
                            You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in
                            your profile.
                          </p>

                          <a href="#" class="btn btn-sm btn-outline-primary">View Badges</a>-->
                          @php
                      use Illuminate\Support\Facades\DB;
                       use Carbon\Carbon;

                      $today = Carbon::today();
                     $yesterday = Carbon::yesterday();

                      $todayOrders = DB::table('orders')
                     ->whereDate('created_at', $today)
                     ->count();

                     $yesterdayOrders = DB::table('orders')
                     ->whereDate('created_at', $yesterday)
                     ->count();

                  if ($yesterdayOrders > 0) {
                    $salesChange = (($todayOrders - $yesterdayOrders) / $yesterdayOrders) * 100;
                } else {
                $salesChange = $todayOrders > 0 ? 100 : 0; // 100% increase if none yesterday but some today
                }

             $salesChangeFormatted = number_format($salesChange, 1); // Format like 72.3%
             $isPositive = $salesChange >= 0;
             @endphp

            <h5 class="card-title text-primary">Congratulations Admin! 🎉</h5>
            <p class="mb-4">You have done  <span class="fw-bold text-{{ $isPositive ? 'success' : 'danger' }}">{{ $salesChangeFormatted }}% </span>{{ $isPositive ? 'more' : 'less' }} sales today compared to yesterday.</p>

                        </div> 
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                         <!-- <img
                            src="../assets/img/illustrations/man-with-laptop-light.png"
                            height="140"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"/>-->
                            <img
                            src="https://freetaxfiler.com/assets/user_panel/assets/img/illustrations/man-with-laptop-light.png"
                            height="140"
                            alt="View Badge User"
                            data-app-dark-img="https://freetaxfiler.com/assets/user_panel/assets/img/illustrations/man-with-laptop-light.png"
                            data-app-light-img="https://freetaxfiler.com/assets/user_panel/assets/img/illustrations/man-with-laptop-light.png"/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 order-1">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <div style="width:70px; height:50px;">
                           <img
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQfwJDYuypoHGn8hVK6uY0sGTaZoXOKNojySw&s"
                            class="rounded w-100 h-100"
                           style="object-fit: contain;"
                           />
                        </div>
                            </div>
                         <!--   <div class="dropdown">
                          <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt3"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                <a class="dropdown-item" href="#">View More</a>
                                <a class="dropdown-item" href="#">Delete</a>
                              </div>
                            </div> -->
                          </div>
          <!--                <span class="fw-semibold d-block mb-1">Profit</span>
                          <h3 class="card-title mb-2">$12,628</h3>
                          <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small> -->
                          <span class="fw-semibold d-block mb-1">Total Vendors</span>
                          <h4>{{ \App\Models\VendorModel::where('del_status', 0)->distinct('id')->count('id') }}<h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                            <!--  <img
                                src="public_html/assets/img/icons/unicons/book-shop.png"
                                class="rounded"
                              />-->
                              <div style="width:70px; height:50px;">
                               <img
                              src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTp6Z01yj0uVAgGaAKWc-j1pluhstY4KVH2aw&s"
                              class="rounded w-100 h-100"
                              style="object-fit: contain;"
                            />
                          </div>
                            </div>
                       <!--     <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt6"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                <a class="dropdown-item" href="#">View More</a>
                                <a class="dropdown-item" href="#">Delete</a>
                              </div>
                            </div> -->
                          </div>
                     <!--     <span>Sales</span>
                          <h3 class="card-title text-nowrap mb-1">$4,679</h3>
                          <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>-->
                          <span  class="fw-semibold d-block mb-1">Total Schools</span>
                          @php
                          $totalSchools = DB::table('school')->where('del_status', 0)->distinct('id')->count('id');
                          @endphp
                         <h4>{{ $totalSchools }}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @php

    $currentYear = request('year', now()->year);
    $currentMonth = request('month', now()->month);

    $selectedDate = Carbon::createFromDate($currentYear, $currentMonth, 1);
    $previousMonthDate = $selectedDate->copy()->subMonth();

    // Current Month Revenue (delivered orders only)
    $currentRevenue = DB::table('orders')
        ->where('del_status', 0)
        ->whereYear('created_at', $selectedDate->year)
        ->whereMonth('created_at', $selectedDate->month)
        ->sum('grand_total');

    // Previous Month Revenue
    $previousRevenue = DB::table('orders')
        ->where('del_status', 0)
        ->whereYear('created_at', $previousMonthDate->year)
        ->whereMonth('created_at', $previousMonthDate->month)
        ->sum('grand_total');

    // Calculate Growth
    if ($previousRevenue > 0) {
        $growthPercent = (($currentRevenue - $previousRevenue) / $previousRevenue) * 100;
    } else {
        $growthPercent = $currentRevenue > 0 ? 100 : 0;
    }

    $growthFormatted = number_format($growthPercent, 1);
    $currentFormatted = number_format($currentRevenue / 1000, 1) . 'k';
    $previousFormatted = number_format($previousRevenue / 1000, 1) . 'k';

    // For Chart (Revenue per Day in Selected Month)
    $dailyRevenue = DB::table('orders')
        ->selectRaw('DAY(created_at) as day, SUM(grand_total) as total')
        ->where('del_status', 0)
        ->whereYear('created_at', $selectedDate->year)
        ->whereMonth('created_at', $selectedDate->month)
        ->groupByRaw('DAY(created_at)')
        ->pluck('total', 'day')
        ->toArray();

    $daysInMonth = $selectedDate->daysInMonth;
    $dailyData = [];
    for ($i = 1; $i <= $daysInMonth; $i++) {
        $dailyData[] = round($dailyRevenue[$i] ?? 0, 2);
    }

    $availableYears = range(now()->year, now()->year - 3); // 4 years
@endphp

                <!-- Total Revenue -->
               <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                  <div class="card p">
                    <div class="row row-bordered g-0">
                      <div class="col-md-8">
                          <form method="GET" class="d-flex align-items-center p-3">
          <select name="month" class="form-select me-2" onchange="this.form.submit()">
            @foreach(range(1, 12) as $m)
              <option value="{{ $m }}" {{ $m == $currentMonth ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
              </option>
            @endforeach
          </select>
          <select name="year" class="form-select" onchange="this.form.submit()">
            @foreach($availableYears as $y)
              <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
          </select>
        </form>
                        <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
                        <div id="totalRevenueChart1" class="px-2"></div>
                      </div>
                      <div class="col-md-4">
                        <div class="card-body">
                          <div class="text-center">
                          <!--  <div class="dropdown">
                              <button
                                class="btn btn-sm btn-outline-primary dropdown-toggle"
                                type="button"
                                id="growthReportId"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                2022
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                <a class="dropdown-item" href="#">2021</a>
                                <a class="dropdown-item" href="#">2020</a>
                                <a class="dropdown-item" href="#">2019</a>
                              </div>
                            </div> -->
                      
                          </div>
                        </div>
                        <div id="growthChart1"></div>
                        <!--<div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>-->
                        {{ $growthFormatted }}% Growth Compared to Last Month

                        <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                          <div class="d-flex">
                            <div class="me-3">
                            <!--  <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>-->
                            </div>
                            <div class="d-flex flex-column">
                                 <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                                <small>This Month</small>
                               <h6 class="mb-0">Rs.{{ $currentFormatted }}</h6>
                               <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                                <small>Last Month</small>
                             <h6 class="mb-0">Rs.{{ $previousFormatted }}</h6>
                              <!--<small>2022</small>
                              <h6 class="mb-0">$32.5k</h6>-->
                            </div>
                          </div>
                          <div class="d-flex">
                            <div class="me-3">
                             <!-- <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>-->
                            </div>
                            <div class="d-flex flex-column">
                              <!--<small>2021</small>
                              <h6 class="mb-0">$41.2k</h6>-->
                           <!--   <small>Last Month</small>
                             <h6 class="mb-0">Rs.{{ $previousFormatted }}</h6>-->
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>



                <!--/ Total Revenue -->
                <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                  <div class="row">
                    <div class="col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                          <!--    <img src="../assets/img/icons/unicons/paypal.png"  class="rounded" />-->
                          <div style="width:70px; height:50px;">
                           <img
                            src="https://static.thenounproject.com/png/209914-200.png"
                            class="rounded w-100 h-100"
                           style="object-fit: contain;"
                           />
                        </div>
                            </div>
                      <!--      <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt4"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                <a class="dropdown-item" href="#">View More</a>
                                <a class="dropdown-item" href="#">Delete</a>
                              </div>
                            </div>  -->
                          </div>
                <!--          <span class="d-block mb-1">Payments</span>
                          <h3 class="card-title text-nowrap mb-2">$2,456</h3>
                          <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small> -->
                           <span class="fw-semibold d-block mb-1">Total Students</span>
                           @php
                           $totalstudents = DB::table('users')->where('del_status', 0)->count('id');
                           @endphp
                          <h4>{{ $totalstudents }}</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                             <!-- <img src="../assets/img/icons/unicons/cc-primary.png" class="rounded" />-->
                              <div style="width:70px; height:50px;">
                           <img
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRQ0JQf8fQHQqPWoPFGtmTTdOz6C0BECpob_w&s"
                            class="rounded w-100 h-100"
                           style="object-fit: contain;"
                           />
                        </div>
                            </div>
                 <!--           <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt1"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                <a class="dropdown-item" href="#">View More</a>
                                <a class="dropdown-item" href="#">Delete</a>
                              </div>
                            </div> -->
                          </div>
                      <!--    <span class="fw-semibold d-block mb-1">Transactions</span>
                          <h3 class="card-title mb-2">$14,857</h3>
                          <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.14%</small>-->
                          <span class="fw-semibold d-block mb-1">Total Orders</span>
                          @php
                          $totalorders = DB::table('orders')->where('del_status', 0)->count('id');
                          @endphp
                        <h4>{{ $totalorders }}</h4>
                        </div>
                      </div>
                    </div>
                    <!-- </div>
    <div class="row"> -->
                  <!--  <div class="col-12 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                              <div class="card-title">
                                <h5 class="text-nowrap mb-2">Profile Report</h5>
                                <span class="badge bg-label-warning rounded-pill">Year 2021</span>
                              </div>
                              <div class="mt-sm-auto">
                                <small class="text-success text-nowrap fw-semibold"
                                  ><i class="bx bx-chevron-up"></i> 68.2%</small
                                >
                                <h3 class="mb-0">$84,686k</h3>
                              </div>
                            </div>
                            <div id="profileReportChart"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>-->
                <div class="col-12 mb-4">
                      <div class="card">
                      <div class="col-12 mb-4">

                <div class="card">
                  <div class="card-body">
                     <span class="card-title">Search Orders</span>
                    <i class="fas fa-search" style="cursor: pointer;"></i>
                    <form method="get" action="{{ url('/') }}/filter_search_order" enctype="multipart/form-data" novalidate>
                      @csrf
                      @if ($errors->any())
                        <div class="alert alert-danger">
                          <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                      @endif
                      <div class="row">
                        <div class="col-sm-12 mb-3">

                          <label class="form-label">Select Search Type:</label>
                          <select class="form-select" name="search_type" required>
                            <option disabled selected hidden>select</option>
                            <option value="1">Order Id</option>
                            <option value="2">Phone Number</option>
                          </select>
                        </div>
                        <div class="col-sm-12 mb-3">
                          <label class="form-label">Enter Search Keyword:</label>
                          <input type="text" class="form-control" name="search_key" required />
                        </div>
                        <div class="col-sm-6 mb-3">
                          <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <!-- Order Statistics -->
                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                      <div class="card-title mb-0">
                      <!--  <h5 class="m-0 me-2">Order Statistics</h5>-->
                         <h3 class="m-0 me-2">Order Statistics</h3>
                     <!--   <small class="text-muted">42.82k Total Sales</small>-->
                      </div>
                   <!--   <div class="dropdown">
                        <button
                          class="btn p-0"
                          type="button"
                          id="orederStatistics"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                          <a class="dropdown-item" href="#">Select All</a>
                          <a class="dropdown-item" href="#">Refresh</a>
                          <a class="dropdown-item" href="#">Share</a>
                        </div>
                      </div>-->
                    </div>
                       @php

                              $today = Carbon::today()->toDateString();
                              $yesterday = Carbon::yesterday()->toDateString();

                              $ordersCount = DB::table('orders')->where('del_status', 0)
                              ->whereDate('created_at', $today)
                            //  ->orWhereDate('created_at', $yesterday)
                              ->count();
                              @endphp
                              
                               @php                          
                               $pendingOrdersCount = DB::table('orders')
                               ->where('order_status', '<', 4)
                               ->whereDate('created_at', $today)
                           //  $query->whereDate('created_at', $today)
                        //   ->orWhereDate('created_at', $yesterday);
                           
                            ->count();
                             @endphp
                             
                             
                               @php                          
                             $DeliveredOrdersCount = DB::table('orders')
                             ->where('order_status', '=', 4)
                             ->whereDate('updated_at', $today)
                           //   $query->whereDate('updated_at', $today);
                            //  ->orWhereDate('updated_at', $yesterday); 
                            ->count();
                             @endphp
                             
                  <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                  <div class="d-flex flex-column align-items-center gap-2">
                   <h2 class="mb-1">{{ $ordersCount  }}</h2>
                   <span>Total Orders</span>
                  </div>

                        <div id="orderStatisticsChart1"></div>
                      </div>
                      <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <!--<span class="avatar-initial rounded bg-label-primary"
                              ><i class="bx bx-mobile-alt"></i
                            ></span>-->
                            <span class="avatar-initial rounded bg-label-primary" title="Total Orders Today"><i class="bx bx-cart"></i></span>

                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                              <h6 class="mb-0">No of orders Per Day</h6>
                            <div class="me-2">
                            <!--  <h6 class="mb-0">Electronic</h6>
                              <small class="text-muted">Mobile, Earbuds, TV</small>-->
                             
                             
                            </div>
                            <div class="user-progress">
                                 <h4>{{ $ordersCount }}</h4>
                             <!-- <small class="fw-semibold">82.5k</small>-->
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <!--<span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>-->
                            <span class="avatar-initial rounded bg-label-warning" title="Pending"><i class="bx bx-time"></i></span>

                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                          <!--    <h6 class="mb-0">Fashion</h6>
                              <small class="text-muted">T-shirt, Jeans, Shoes</small>-->
                              <h6 class="mb-0">Pending Orders Per Day</h6>
                              
                            </div>
                            <div class="user-progress">
                             <!-- <small class="fw-semibold">23.8k</small>-->
                             <h4>{{ $pendingOrdersCount }}</h4>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <!--<span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>-->
                          <span class="avatar-initial rounded bg-label-success" title="Delivered"><i class="bx bx-check-circle"></i></span>

                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                            <!--  <h6 class="mb-0">Decor</h6>
                              <small class="text-muted">Fine Art, Dining</small>-->
                                                 <h6 class="mb-0">Delivered Orders Per Day</h6>
                            
                              
                            </div>
                            <div class="user-progress">
                                 <h4>{{ $DeliveredOrdersCount }}</h4>
                        <!--      <small class="fw-semibold">849k</small> -->
                            </div>
                          </div>
                        </li>
          <!--              <li class="d-flex">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-secondary"
                              ><i class="bx bx-football"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Sports</h6>
                              <small class="text-muted">Football, Cricket Kit</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">99</small>
                            </div>
                          </div>
                        </li> -->
                      </ul>
                    </div>
                  </div>
                </div>
                <!--/ Order Statistics -->

                <!-- Expense Overview -->
                <div class="col-md-6 col-lg-4 order-1 mb-4">
                  <div class="card h-100">
                    <div class="card-header">
                      <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                          <button
                            type="button"
                            class="nav-link active"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-tabs-line-card-income"
                            aria-controls="navs-tabs-line-card-income"
                            aria-selected="true"
                          >
                            Income
                          </button>
                        </li>
                        <li class="nav-item">
                          <button type="button" class="nav-link" role="tab">Expenses</button>
                        </li>
                        <li class="nav-item">
                          <button type="button" class="nav-link" role="tab">Profit</button>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body px-0">
                      <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                          <div class="d-flex p-4 pt-3">
                            <div class="avatar flex-shrink-0 me-3">
                              <img src="../assets/img/icons/unicons/wallet.png" alt="User" />
                            </div>
                            <div>
                              <small class="text-muted d-block">Total Balance</small>
                              <div class="d-flex align-items-center">
                                <h6 class="mb-0 me-1">$459.10</h6>
                                <small class="text-success fw-semibold">
                                  <i class="bx bx-chevron-up"></i>
                                  42.9%
                                </small>
                              </div>
                            </div>
                          </div>
                          <div id="incomeChart"></div>
                          <div class="d-flex justify-content-center pt-4 gap-2">
                            <div class="flex-shrink-0">
                              <div id="expensesOfWeek"></div>
                            </div>
                            <div>
                              <p class="mb-n1 mt-1">Expenses This Week</p>
                              <small class="text-muted">$39 less than last week</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Expense Overview -->

                <!-- Transactions -->
                <div class="col-md-6 col-lg-4 order-2 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2">Transactions</h5>
                     <!-- <div class="dropdown">
                        <button
                          class="btn p-0"
                          type="button"
                          id="transactionID"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                          <a class="dropdown-item" href="#">Last 28 Days</a>
                          <a class="dropdown-item" href="#">Last Month</a>
                          <a class="dropdown-item" href="#">Last Year</a>
                        </div>
                      </div>-->
                    </div>
                    <div class="card-body">
                    <!--  <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="text-muted d-block mb-1">Paypal</small>
                              <h6 class="mb-0">Send money</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0">+82.6</h6>
                              <span class="text-muted">USD</span>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="text-muted d-block mb-1">Wallet</small>
                              <h6 class="mb-0">Mac'D</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0">+270.69</h6>
                              <span class="text-muted">USD</span>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/chart.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="text-muted d-block mb-1">Transfer</small>
                              <h6 class="mb-0">Refund</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0">+637.91</h6>
                              <span class="text-muted">USD</span>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/cc-success.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="text-muted d-block mb-1">Credit Card</small>
                              <h6 class="mb-0">Ordered Food</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0">-838.71</h6>
                              <span class="text-muted">USD</span>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/wallet.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="text-muted d-block mb-1">Wallet</small>
                              <h6 class="mb-0">Starbucks</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0">+203.33</h6>
                              <span class="text-muted">USD</span>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/cc-warning.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="text-muted d-block mb-1">Mastercard</small>
                              <h6 class="mb-0">Ordered Food</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0">-92.45</h6>
                              <span class="text-muted">USD</span>
                            </div>
                          </div>
                        </li>
                      </ul>-->
                     @php

              $today = Carbon::today()->toDateString();

            $todayTransactions = DB::table('new_order_processing_data2')
            ->whereDate('transaction_date', $today)
            ->whereRaw('((total_amount - total_discount) + shipping_charge) > 0') // Filter out 0
            ->orderByDesc('transaction_date')
           ->get();
           @endphp

              <ul class="p-0 m-0">
               @forelse ($todayTransactions as $transaction)
               <li class="d-flex mb-4 pb-1">
             <div class="avatar flex-shrink-0 me-3">
        <img src="{{ asset('assets/img/icons/unicons/wallet.png') }}" alt="Transaction" class="rounded" />
             </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
        <div class="me-2">
          <small class="text-muted d-block mb-1">Transaction ID: {{ $transaction->transaction_id }}</small>
        </div>
        <div class="user-progress d-flex align-items-center gap-1">
          <span class="text-muted">Rs</span>
          <h6 class="mb-0">
            {{ number_format(($transaction->total_amount - $transaction->total_discount) + $transaction->shipping_charge, 2) }}
          </h6>
        </div>
      </div>
    </li>
  @empty
    <li class="text-muted">No transactions found for today.</li>
  @endforelse
</ul>

  

                    </div>
                  </div>
                </div>
               

  

                <!--/ Transactions -->
              </div>
            </div>
            <!-- / Content -->

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
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    
   
    
    @include('includes.footer_script')
    
    <script>
    const ordersCount = {{ $ordersCount }};
    const pendingOrdersCount = {{ $pendingOrdersCount }};
    const deliveredOrdersCount = {{ $DeliveredOrdersCount }};
</script>
<script>
  const chartOrderStatistics = document.querySelector('#orderStatisticsChart1');

  if (chartOrderStatistics) {
    const orderChartConfig = {
      chart: {
        height: 250,
        type: 'donut'
      },
      labels: ['Total Orders', 'Pending Orders', 'Delivered Orders'], // Order is correct
      series: [ordersCount, pendingOrdersCount, deliveredOrdersCount],
      colors: ['#696CFF', '#FFAB00', '#71DD37'], // Total = Blue, Pending = Orange, Delivered = Green
      stroke: {
        width: 4
      },
      dataLabels: {
        enabled: false,
        formatter: function (val) {
          return `${Math.round(val)}`;
        }
      },
      legend: {
        position: 'bottom'
      },
      plotOptions: {
        pie: {
          donut: {
            size: '70%',
            labels: {
              show: true,
              total: {
                show: true,
                label: 'Orders',
                formatter: function () {
                  return ordersCount;
                }
              }
            }
          }
        }
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return `${val} Orders`;
          }
        }
      }
    };

    const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
    statisticsChart.render();
  }
</script>
<script>
  const dailyRevenueData = @json($dailyData);
  const days = [...Array({{ $daysInMonth }}).keys()].map(i => i + 1);
  const growthPercentage = {{ round($growthPercent, 2) }};

  if (typeof ApexCharts !== 'undefined') {
    // Revenue Chart (only tooltip values)
    const revenueOptions = {
      chart: {
        type: 'bar',
        height: 250
      },
      series: [{
        name: 'Revenue',
        data: dailyRevenueData
      }],
      xaxis: {
        categories: days,
        title: {
          text: 'Day of Month'
        }
      },
      yaxis: {
        labels: { show: true }
      },
      dataLabels: { enabled: false },
      tooltip: {
        enabled: true,
        y: {
          formatter: value => '$' + value.toFixed(2)
        }
      },
      colors: ['#28c76f']
    };

    new ApexCharts(document.querySelector("#totalRevenueChart1"), revenueOptions).render();

    // Growth Chart (Radial)
 /*  const growthOptions = {
      chart: {
        height: 120,
        type: 'radialBar',
        sparkline: { enabled: true }
      },
      series: [growthPercentage],
      labels: ['Growth'],
      colors: ['#7367F0'],
      plotOptions: {
        radialBar: {
          hollow: { size: '50%' },
          dataLabels: {
            name: {
              offsetY: 0,
              fontSize: '13px'
            },
            value: {
              offsetY: 5,
              fontSize: '18px',
              formatter: val => val + '%'
            }
          }
        }
      }
    }; */
    const growthChart1El = document.querySelector('#growthChart1'),
  growthChart1Options = {
    series: [growthPercentage],
    labels: ['Growth'],
    chart: {
      height: 240,
      type: 'radialBar'
    },
    plotOptions: {
      radialBar: {
        size: 150,
        offsetY: 10,
        startAngle: -150,
        endAngle: 150,
        hollow: {
          size: '55%'
        },
        track: {
          background: '#f2f2f2', // fallback if cardColor isn't defined
          strokeWidth: '100%'
        },
        dataLabels: {
          name: {
            offsetY: 15,
            color: '#5e5873', // fallback if headingColor isn't defined
            fontSize: '15px',
            fontWeight: '600',
            fontFamily: 'Public Sans'
          },
          value: {
            offsetY: -25,
            color: '#5e5873',
            fontSize: '22px',
            fontWeight: '500',
            fontFamily: 'Public Sans',
            formatter: val => val + '%'
          }
        }
      }
    },
    colors: ['#7367F0'],
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        shadeIntensity: 0.5,
        gradientToColors: ['#7367F0'],
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 0.6,
        stops: [30, 70, 100]
      }
    },
    stroke: {
      dashArray: 5
    },
    grid: {
      padding: {
        top: -35,
        bottom: -10
      }
    },
    states: {
      hover: {
        filter: {
          type: 'none'
        }
      },
      active: {
        filter: {
          type: 'none'
        }
      }
    }
  };

if (typeof growthChart1El !== 'undefined' && growthChart1El !== null) {
  const growthChart1 = new ApexCharts(growthChart1El, growthChart1Options);
  growthChart1.render();
}


   // new ApexCharts(document.querySelector("#growthChart1"), growthOptions).render();
  }
</script>



   <!-- footerscrit -->
  </body>
</html>
