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
 <style>
/* General Neon Text */
 
.neon {
 position: relative;
  width: 60px;
  height: 60px;
  margin-top: 10px;
}
 .label1 {
  margin-top: 20px;
  text-align: center;
  font-weight: 1000;
  color: #1e2d3b;  /* Dark navy/black shade */
  font-size: 8px;
  line-height: 1.2;
  user-select: none;
  text-shadow: 0 0 0.4px black; /* Optional: adds subtle edge for crispness */
}

.batch-box
{
   border: 2px solid black;
      border-radius: 8px;
      width: 65px;
      height: 65px;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      perspective: 400px;
     margin-bottom:8px; 
}
/* Neon Icon Container */
.neon-icon {
  position: relative;
  width: 40px;          /* Reduced from 60px */
  height: 40px;         /* Reduced from 60px */
  margin-top: -15px;
  margin-bottom:-10px;
}

/* Document Icon */
.document {
  position: absolute;
  width: 30px;          /* Reduced from 40px */
  height: 36px;         /* Reduced from 48px */
  border: 1.8px solid black;
  border-radius: 4px;
  box-shadow: 0 0 4px rgba(26, 188, 156, 0.35);
  top: 12px;
  left: 5px;
  padding: 3px;
  background-color: #fdfefe;
  box-sizing: border-box;
}

/* Lines inside the document */
.line {
  height: 2px;          /* Reduced from 3px */
  background: #696cff;
  margin: 2px 0;
  border-radius: 2px;
  box-shadow: 0 0 1.5px #696cff;
}
.line:nth-child(1) { width: 85%; }
.line:nth-child(2) { width: 70%; }
.line:nth-child(3) { width: 55%; }

/* Badge Circles */
.circle {
  position: absolute;
  width: 18px;           /* Reduced from 24px */
  height: 18px;
  border-radius: 50%;
  box-shadow: 0 0 3px #1abc9c, 0 0.8px 3px rgba(0, 0, 0, 0.15);
  display: flex;
  justify-content: center;
  align-items: center;
  color: #1e2d3b;
  background-color: #ffffff;
  font-size: 10px;       /* Reduced from 13px */
  font-weight: 600;
}

.notification { top: 3px; right: -25px; width: 30px;  /* reduced from 24px */
  height: 30px; font-size:11px;  border: 2px solid black;}
.check-circle { bottom:-10px; left: 21px;   border: 2px solid #1e2d3b;}

.checkmark {
  font-size: 9px;        /* Reduced from 12px */
  color: #696cff;
}

/* Light Theme Overrides */
.light-theme .document,
.light-theme .circle {
  background-color: #ffffff;
  border-color: #1e2d3b;
  box-shadow: 0 0 2px #696cff;
  color: #1e2d3b;
}

.light-theme .line {
  background: #696cff;
  box-shadow: 0 0 1.5px #696cff;
}

/* School Icon */
.school-box {
  border: 2px solid black;
      border-radius: 8px;
      width: 65px;
      height: 65px;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      perspective: 400px;
     margin-bottom:8px;
     margin-top:2px;
     padding: 3px;
  
}

.school-icon {
  position: relative;
  width: 30px;
  height: 22px;
  margin: -10px auto -20px; /* Was 6px auto 4px — top margin reduced to move upward */
  border: 1.3px solid black;
  border-radius: 2px;
  box-shadow: 0 0 1.5px rgba(30, 45, 59, 0.3);
  display: flex;
  align-items: flex-end;
  justify-content: center;
}
.label2
{
     margin-top:20px;
     margin-bottom:-20px;
  text-align: center;
  font-weight: 1000;
  color: #1e2d3b;  /* Dark navy/black shade */
  font-size: 7px;
  line-height: 1.2;
  user-select: none;
  text-shadow: 0 0 0.4px black; /* Optional: adds subtle edge for crispness */
}
 


/* Roof - smaller */
.roof {
  position: absolute;
  top: -12px;
  left: -1px;
  border-left: 15px solid transparent;
  border-right: 15px solid transparent;
  border-bottom: 12px solid black;
  z-index: 1;
}

.roof::after {
  content: '';
  position: absolute;
  top: 1px;
  left: -16px;
  border-left: 16px solid transparent;
  border-right: 16px solid transparent;
  border-bottom: 10px solid #696cff;
  z-index: 2;
}

/* Building body */
.building-body {
  width: 100%;
  height: 100%;
  position: relative;
  padding-top: 2px;
  box-sizing: border-box;
}

/* Door - smaller */
.door {
  position: absolute;
  bottom: 0;
  left: 12px;
  width: 5px;
  height: 8px;
  background-color: #696cff;
  border-left: 1px solid black;
  border-right: 1px solid black;
  border-top: 1px solid black;
}

/* Windows - smaller */
.window {
  position: absolute;
  width: 2.5px;
  height: 2.5px;
  border: 0.5px solid black;
}

.window.left-top { top: 3px; left: 4px; }
.window.left-bottom { top: 8px; left: 4px; }
.window.right-top { top: 3px; right: 4px; }
.window.right-bottom { top: 8px; right: 4px; }




/* Badge - scaled */
.circle-badge {
  position: absolute;
  top: -30px;
  right: -25px;
  width: 30px;  /* reduced from 24px */
  height: 30px;
  border-radius: 50%;
  border: 2px solid black;
  background-color: #ffffff;
  color: #1e2d3b;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 5;
  font-size: 11px;
  font-weight: 600;
}


/* Inventory Box */

 .inventory-box {
  position: relative;
  width: 60px; /* reduced from 70px */
  padding: 8px 5px 7px; /* slightly tighter padding */
  border-radius: 6px;
  border: 2px solid black;
  box-shadow:
    0 3px 5px rgba(26, 188, 156, 0.12),
    inset 0 0 4px rgba(26, 188, 156, 0.1);
  text-align: center;
  user-select: none;
  transition: box-shadow 0.3s ease;
  margin-bottom: 6px;
   font-weight: 600;

}
.inventory-box:hover {
  box-shadow:
    0 5px 8px rgba(26, 188, 156, 0.25),
    inset 0 0 5px rgba(26, 188, 156, 0.15);
}

.bookshelf {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  width: 32px; /* reduced from 38px */
  height: 18px; /* reduced from 22px */
  margin: 0 auto 5px;
}

.book {
  width: 5px; /* reduced from 6px */
  border-radius: 1.5px;
  background: #696cff;
  box-shadow:
    0 1px 1.5px #696cff,
    inset 0 0.6px 1.2px #696cff;
  border: none;
}

.book:nth-child(1) { height: 12px; } /* all heights scaled down */
.book:nth-child(2) { height: 14px; }
.book:nth-child(3) { height: 11px; }
.book:nth-child(4) { height: 13px; }

.circle-badge-2 {
  position: absolute;
  top: -9px;
  right: -9px;
  width: 30px;  /* reduced from 24px */
  height: 30px;
  border-radius: 50%;
  background-color: #ffffff;
  color: #1e2d3b;
  font-size: 11px; /* reduced from 13px */
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 1px 2px rgba(26, 188, 156, 0.6);
  user-select: none;
  border: 2px solid black;
  z-index: 5;
}


  .box-text {
   font-weight: 1000;
  color: #1e2d3b;  /* Dark navy/black shade */
  font-size: 8px;
  line-height: 1.2;
  user-select: none;
  text-shadow: 0 0 0.4px black;
    white-space: nowrap;
  }
      .delivered-icon {
      border: 2px solid black;
      border-radius: 8px;
      width: 65px;
      height: 65px;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      perspective: 400px;
     margin-bottom:8px;
    }

    .box {
        
        margin-top:5px;
      position: relative;
      width: 20px;
      height: 20px;
      transform-style: preserve-3d;
      transform: rotateX(-20deg) rotateY(30deg);
    }

    /* Individual faces */
    .face {
      position: absolute;
      width: 20px;
      height: 20px;
      border: 1.5px solid black;
      box-sizing: border-box;
      border-radius: 2px;
      box-shadow: inset 0 1px 3px rgba(0,0,0,0.15);
      background: #696cff;
    }

    .face-front  { transform: translateZ(10px); }
    .face-back   { transform: rotateY(180deg) translateZ(10px); }
    .face-right  { transform: rotateY(90deg) translateZ(10px); border-radius: 0 2px 2px 0; }
    .face-left   { transform: rotateY(-90deg) translateZ(10px); border-radius: 2px 0 0 2px; }
    .face-top    { transform: rotateX(90deg) translateZ(10px); border-radius: 2px 2px 0 0; }
    .face-bottom { transform: rotateX(-90deg) translateZ(10px); border-radius: 0 0 2px 2px; }

    .check {
      width: 15px;
      height: 15px;
      border-radius: 50%;
      position: absolute;
      bottom:30px;
      right: 12px;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 10;
      border: 1.5px solid black;
      box-shadow: 0 1px 2px rgba(0,0,0,0.3);
      color: black;
      font-size: 8px;
      background-color:#ffffff;
    }

    .check::before {
      content: "✔";
      color: green;
      font-size: 8px;
    }


    .label {
      margin-top: 10px;
     margin-right:5px;
      font-weight: 1000;
  color: #1e2d3b;  /* Dark navy/black shade */
  font-size: 8px;
  line-height: 1.2;
  user-select: none;
  text-shadow: 0 0 0.4px black;
    }
.container {
  display: inline-block;
  width: 380px;
}

.bag-wrapper {
  position: relative;
  width: 180px;
  margin-bottom: 25px;
  margin-left: 50px;
}

.handle {
  position: absolute;
  top: -40px;
  left: 48px;
  width: 84px;
  height: 42px;
  border: 5px solid #0d1b2a;
  border-bottom: none;
  border-radius: 40px 40px 0 0;
  background: transparent;
  z-index: 2;
}

.hook {
  position: absolute;
  width: 5px;
  height: 22px;
  background-color: #0d1b2a;
  top: 0;
  border-radius: 3px;
  z-index: 3;
}

.hook.left {
  left: 44px;
}

.hook.right {
  right: 44px;
}

.bag-body {
  position: relative;
  width: 100%;
  height: 115px;
  background: #696cff;
  border: 5px solid #0d1b2a;
  border-radius: 20px;
  box-shadow: 0 8px 16px rgba(0,0,0,0.16);
  z-index: 1;
  clip-path: polygon(20% 0%, 80% 0%, 100% 100%, 0% 100%);
}

.bag-bottom {
  position: absolute;
  bottom: -16px;
  left: 22px;
  width: 132px;
  height: 14px;
  background: #16a085;
  border-radius: 0 0 12px 12px;
  box-shadow: inset 0 3px 3px rgba(255,255,255,0.15);
  z-index: 0;
}

.check-circle-1 {
  position: absolute;
  width: 38px;
  height: 38px;
   background-color:#ffffff;
  border: 5px solid #0d1b2a;
  border-radius: 50%;
  right: -14px;
  bottom: -14px;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2;
}

.check-1 {
  color:black;
  font-size: 25px;
  font-weight: bold;
}

.text {
  margin-top: 14px;
  font-size: 20px;
  font-weight: 600;
  color: #0d1b2a;
}

.text-1 {
  margin-top: -15px;
  font-size: 32px;
  font-weight: 600;
  color: #0d1b2a;
}

.text-2 {

  font-size: 24px;
  font-weight: 600;
  color: #0d1b2a;
}



</style>

   
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
                          <h5 class="card-title text-primary">Congratulations  {{session('username')}}! </h5>
                          <p class="mb-4">
                           
                         <b style="font-size:18px;bg-info">{{$pagedata['new_order']}}</b> New orders, new achievements! Congratulations on the latest success at Evyapari.com. 
</p>

                          <a  href="{{url('new_orders')}}" class="btn btn-sm btn-outline-primary">View New Orders</a>
                        </div> 
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                       <!-- <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="https://www.instamojo.com/blog/wp-content/uploads/2020/11/What-kind-of-books-can-you-sell-online-1024x683.jpg"
                            height="170"
                           />
                        </div>-->
                          <div class="container">
    <div class="bag-wrapper">
      <div class="handle"></div>
      <div class="hook left"></div>
      <div class="hook right"></div>
      <div class="bag-body">
        <div class="text">New</div>
        <div class="text-2">Order</div>
        <div class="text-1">Received</div>
      </div>
      <div class="check-circle-1">
        <div class="check-1">{{$pagedata['new_order']}}</div>
      </div>
    </div>
  </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 order-1">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                      <div class="card" style="min-height: 210px;">

                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                           <!--<div class="avatar flex-shrink-0">
                             <img
  src="https://m.media-amazon.com/images/I/617FaPcp4YL.jpg"
  class="img-fluid rounded"
  style="max-width: 350px; height: 50px;"
/>

                            </div>-->
                       <!--     <div class="dropdown">
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
                     @php
                   use App\Models\InventoryVendorModel;
                   use App\Models\VendorModel;

                // Get the vendor ID from session
                $vendorId = session('id');
                $totalInventory = 0;

                if ($vendorId) {
               // Check if vendor exists
            $vendor = VendorModel::where('unique_id', $vendorId)->first();

                if ($vendor) {
               // Count distinct product_id where vendor_id matches and del_status is 0
                  $totalInventory = InventoryVendorModel::where([
                 'vendor_id' => $vendorId,
                 'del_status' => 0
               ])->distinct('product_id')->count('product_id');
              }
            } 
           @endphp
     <div class="inventory-box" aria-label="Book Inventory Icon with count 12">
    <div class="bookshelf" role="list" aria-label="Books on shelf">
      <div class="book" role="listitem" aria-label="Book 1"></div>
      <div class="book" role="listitem" aria-label="Book 2"></div>
      <div class="book" role="listitem" aria-label="Book 3"></div>
      <div class="book" role="listitem" aria-label="Book 4"></div>
    </div>
    <div class="circle-badge-2" aria-label="Total books in inventory">{{$totalInventory}}</div>
    <div class="box-text">
      BOOK<br />INVENTORY
    </div>
  </div>
                 <a href="{{ url('view_inventory_form') }}">
                   <span class="fw-semibold d-block mb-1">Total <br> Inventory</span>
                           <h3 class="card-title mb-2">{{$totalInventory}}</h3>
                   </a>

                         
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card" style="min-height: 210px;">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                        <!--    <div class="avatar flex-shrink-0">
                              <img
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRocOxooPvbZS0NPmpJMB7yt2lvLY5tj6JxQ&s"
                                class="rounded"
                                 style="max-width: 350px; height: 50px;"
                              />
                            </div>-->
                        <!--    <div class="dropdown">
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
                          @php
        

               $vendorId = session('id');
    $totalDeliveredOrders = 0;

    if ($vendorId) {
        // Check if vendor exists
        $vendor = VendorModel::where('unique_id', $vendorId)->first();

        if ($vendor) {
            // Count completed (delivered) orders for this vendor
            $totalDeliveredOrders = DB::table('orders')
                ->where('order_status', 4)
                ->where('del_status', 0)
                ->where('vendor_id', $vendor->unique_id)
                ->count();
        }
    }
            @endphp
              <div>
    <div class="delivered-icon" aria-label="Delivered Orders Icon">
      <div class="box" role="img" aria-label="3D cube representing delivered orders">
        <div class="face face-front"></div>
        <div class="face face-back"></div>
        <div class="face face-right"></div>
        <div class="face face-left"></div>
        <div class="face face-top"></div>
        <div class="face face-bottom"></div>
      </div>
      <div class="check" aria-hidden="true"></div>
      <div class="circle-badge-2" aria-hidden="true">{{$totalDeliveredOrders}}</div>
      <div class="label">DELIVERED<br>ORDERS</div>
    </div>
    
  </div>
            <a href="{{url('delivered_orders')}}">
                    <span class="fw-semibold d-block mb-1">Total Delivered Orders </span></span>
                          <h3 class="card-title text-nowrap mb-1">{{$totalDeliveredOrders}}</h3>
                   </a>

                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                 @php
                 use Illuminate\Support\Facades\DB;
                use Carbon\Carbon;

                $vendorId = session('id'); // ✅ session-based vendor_name
                $currentYear = request('year', now()->year);
                $currentMonth = request('month', now()->month);

    $selectedDate = Carbon::createFromDate($currentYear, $currentMonth, 1);
    $previousMonthDate = $selectedDate->copy()->subMonth();

    // Current Month Revenue for Vendor
    $currentRevenue = DB::table('sale_tax_register')
        ->where('vendor_id', $vendorId)
        ->where('del_status', 0)
        ->whereYear('created_at', $selectedDate->year)
        ->whereMonth('created_at', $selectedDate->month)
        ->sum('total_amount');

    // Previous Month Revenue for Vendor
    $previousRevenue = DB::table('sale_tax_register')
        ->where('vendor_id', $vendorId)
        ->where('del_status', 0)
        ->whereYear('created_at', $previousMonthDate->year)
        ->whereMonth('created_at', $previousMonthDate->month)
        ->sum('total_amount');

    // Calculate Growth %
    if ($previousRevenue > 0) {
        $growthPercent = (($currentRevenue - $previousRevenue) / $previousRevenue) * 100;
    } else {
        $growthPercent = $currentRevenue > 0 ? 100 : 0;
    }

    $growthFormatted = number_format($growthPercent, 1);
    $currentFormatted = number_format($currentRevenue / 1000, 1) . 'k';
    $previousFormatted = number_format($previousRevenue / 1000, 1) . 'k';

    // Revenue per Day for chart
    $dailyRevenue = DB::table('sale_tax_register')
        ->selectRaw('DAY(created_at) as day, SUM(total_amount) as total')
        ->where('vendor_id', $vendorId)
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

    $availableYears = range(now()->year, now()->year - 3);
@endphp

                <!-- Total Revenue -->
               <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-2">
                  <div class="card"  style="min-height: 300px;">
                    <div class="row row-bordered g-20">
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
                        <div class="card-body"  style="min-height: 100px;">
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
                     <!--   <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>-->
                     {{ $growthFormatted }}% Growth Compared to Last Month


                        <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                          <div class="d-flex">
                            <div class="me-2">
                           <!--   <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>-->
                            </div>
                            <div class="d-flex flex-column">
                        <!--      <small>2022</small>
                              <h6 class="mb-0">$32.5k</h6>-->
                                <span class="badge bg-label-primary p-2"><i class="bx bx-rupee text-primary"></i></span>
                              <small>This Month</small>
                               <h6 class="mb-0">{{ $currentFormatted }}</h6>
                               <span class="badge bg-label-info p-2"><i class="bx bx-rupee text-primary"></i></span>
                                <small>Last Month</small>
                             <h6 class="mb-0">{{ $previousFormatted }}</h6>
                            </div>
                          </div>
                          <div class="d-flex">
                            <div class="me-2">
                             <!-- <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>-->
                            </div>
                            <div class="d-flex flex-column">
                             <!-- <small>2021</small>
                              <h6 class="mb-0">$41.2k</h6>-->
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
                       <div class="card" style="min-height: 210px;">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                              @php
$vendorName = session('username');
$vendor = DB::table('vendor')->where('username', $vendorName)->first();
$vendorId = $vendor?->unique_id;

// Base query for batches of this vendor, active, pp_status=1
$baseBatchQuery = DB::table('order_under_batch')
    ->where('pp_status', 1)
    ->where('status', 0)
    ->where('vendor_id', $vendorId);

// 1. New Orders count (batches with batch_status = 1 and count of orders inside)
$newBatchOrdersCount = DB::table('order_under_batch')
    ->join('sale_tax_register', 'sale_tax_register.batch_id', '=', 'order_under_batch.id')
    ->where('order_under_batch.vendor_id', $vendorId)
    ->where('order_under_batch.pp_status', 1)
    ->where('order_under_batch.status', 0)
    ->where('order_under_batch.batch_status', 1)
    ->count('sale_tax_register.order_id');

// 2. Pending Orders count (orders with status < 4 in batches that are NOT new batches)
$pendingOrdersCount = DB::table('order_under_batch')
    ->join('sale_tax_register', 'sale_tax_register.batch_id', '=', 'order_under_batch.id')
    ->where('order_under_batch.vendor_id', $vendorId)
    ->where('order_under_batch.pp_status', 1)
    ->where('order_under_batch.status', 0)
    ->where('order_under_batch.batch_status', '!=', 1)
    ->where('sale_tax_register.order_status', '<', 4)
    ->count('sale_tax_register.order_id');

// 3. Delivered batches count — batches where all orders have status = 4
$deliveredBatchIds = $baseBatchQuery
    ->where('batch_status', '!=', 1)
    ->pluck('id');

$deliveredBatchCount = 0;

foreach ($deliveredBatchIds as $batchId) {
    $orderStatuses = DB::table('sale_tax_register')
        ->where('batch_id', $batchId)
        ->pluck('order_status');

    if ($orderStatuses->count() > 0 && $orderStatuses->every(fn($status) => $status == 4)) {
        $deliveredBatchCount++;
    }
}
@endphp
                          <!--  <div class="avatar flex-shrink-0">
                              <img src="https://img.freepik.com/free-vector/seo-optimization-concept-illustration_114360-25920.jpg?semt=ais_hybrid&w=740" 
                              class="rounded"
                               style="max-width: 400px; height: 50px;"
                              />
                            </div>-->
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
                            </div> -->




                          </div>
                          <div class="batch-box" aria-label="batch Box">
                          <div class="body1">
                          <div class="neon-icon">
    <div class="document">
      <div class="line"></div>
      <div class="line"></div>
      <div class="line"></div>
    </div>
    <div class="circle notification">{{$pagedata['new_order']}}</div>
    <div class="circle check-circle"><div class="checkmark">&#10003;</div></div>
  </div>
  <div class="label1">ORDERS<br>UNDER BATCH</div>
  </div>
  </div>
   
                               <a href="{{url('bacth_order')}}">
                  <span class="fw-semibold d-block mb-1">Order Under Batch</span>
                   </a>
                          
                        
 <div class="d-flex justify-content-between align-items-center">
  <h6 class="mb-0">New Orders</h6>
  <small class="text-muted">{{ $newBatchOrdersCount }}</small>
</div>
<div class="d-flex justify-content-between align-items-center">
  <h6 class="mb-0">Pending Orders</h6>
   @if ($pendingOrdersCount > 0)
      <small class="text-muted">0</small>
    @else
      <small class="text-success fw-bold">Delivered</small>
    @endif
</div>

                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card" style="min-height: 210px;">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <!--<div class="avatar flex-shrink-0">
                              <img src="https://static.vecteezy.com/system/resources/thumbnails/004/641/880/small_2x/illustration-of-high-school-building-school-building-free-vector.jpg"
                              class="rounded" 
                              style="max-width: 350px; height: 50px;"
                              />
                            </div>-->
                     <!--       <div class="dropdown">
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
              @php
$totalSchools = DB::table('school_set_vendor')
    ->leftJoin('school', 'school.id', '=', 'school_set_vendor.school_id')
    ->leftJoin('pickup_points', 'pickup_points.id', '=', 'school_set_vendor.pickup_point')
    ->where([
        'school_set_vendor.vendor_id' => session('id'),
        'school.status' => 1,
        'school.del_status' => 0
    ])
    ->distinct('school_set_vendor.school_id')
    ->count('school_set_vendor.school_id');
@endphp

      
                          </div>
                          <div class="school-box" aria-label="School Box">
 <div class="school-icon neon">
  <div class="roof"></div>
 
  
  <div class="building-body">
    <div class="window left-top"></div>
    <div class="window left-bottom"></div>
    <div class="window right-top"></div>
    <div class="window right-bottom"></div>
    <div class="door"></div>
  </div>
  <div class="circle-badge neon">{{$totalSchools}}</div>
</div>
<div class="label2">SCHOOLS<br>COLLAB-<br>ORATION</div>
</div>


                          <a href="{{url('view_school_wise_set')}}">
                   <span class="fw-semibold d-block mb-1">Total Schools Collaboration</span>
                         <h3 class="card-title mb-2">{{$totalSchools}}</h3>
                   </a>
                          
                        <!--  <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.14%</small>-->
                        </div>
                      </div>
                    </div>
                    <!-- </div>
    <div class="row"> -->
                   <div class="col-12 mb-3">
                      <div class="card">
                       <!-- <div class="card-body">
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
                        </div>-->
                                      <!--    <div class="card-body">
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
                  </div>-->
                  <div class="card-body">
      <div class="d-flex justify-content-between flex-sm-row flex-column gap-2">
        <div>
          <h5 class="card-title text-nowrap mb-1">🔍 Search Orders</h5>
          <span class="text-muted small">Find orders by ID or phone number</span>
        </div>
        <i class="bx bx-search text-primary fs-3"></i>
      </div>

      <form method="get" action="{{ url('/') }}/filter_search_order" enctype="multipart/form-data" novalidate>
        @csrf
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="mb-3">
          <label class="form-label fw-semibold">Select Search Type</label>
          <select class="form-select" name="search_type" required>
            <option disabled selected hidden>Select</option>
            <option value="1">Order Id</option>
            <option value="2">Phone Number</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Enter Search Keyword</label>
          <input type="text" class="form-control" name="search_key" placeholder="Enter Order ID or Phone Number" required />
        </div>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-search-alt-2 me-1"></i> Search
          </button>
        </div>
      </form>
    </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
              <div class="row">
                <!-- Order Statistics -->
             <!--   <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                      <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Order Statistics</h5>
                        <small class="text-muted">42.82k Total Sales</small>
                      </div>
                      <div class="dropdown">
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
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                          <h2 class="mb-2">8,258</h2>
                          <span>Total Orders</span>
                        </div>
                        <div id="orderStatisticsChart"></div>
                      </div>
                      <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"
                              ><i class="bx bx-mobile-alt"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Electronic</h6>
                              <small class="text-muted">Mobile, Earbuds, TV</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">82.5k</small>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Fashion</h6>
                              <small class="text-muted">T-shirt, Jeans, Shoes</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">23.8k</small>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Decor</h6>
                              <small class="text-muted">Fine Art, Dining</small>
                            </div>
                            <div class="user-progress">
                              <small class="fw-semibold">849k</small>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex">
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
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>-->
@php
$vendorName = session('username'); // ✅ Logged-in vendor's name

// Step 1: Get vendor_id from vendor table using username
$vendor = DB::table('vendor')->where('username', $vendorName)->first();
$vendorId = $vendor?->unique_id;
$selectedYear = request('year') ?? date('Y');

$shipDisplay = []; // Default empty in case vendor not found

if ($vendorId) {
    // Step 2: Fetch shipping address breakdown
   $shipCounts = DB::table('orders')
    ->leftJoin('order_shipping_address', 'order_shipping_address.invoice_number', '=', 'orders.invoice_number')
    ->leftJoin('pickup_points', 'pickup_points.id', '=', 'orders.pp_id')
    ->select(
        DB::raw("COUNT(*) as count"),
        'order_shipping_address.address_type',
        'pickup_points.pickup_point_name'
    )
    ->where('orders.vendor_id', $vendorId)
    ->where('orders.del_status', 0)
    ->whereIn('orders.order_status', [3, 4])
    ->where('orders.order_year', $selectedYear)
    ->groupBy('order_shipping_address.address_type', 'pickup_points.pickup_point_name')
    ->get();

    // Type labels & icons
    $basicTypes = [
        1 => ['label' => 'Home', 'icon' => 'bx-home-alt'],
        2 => ['label' => 'School', 'icon' => 'bx-book'],
    ];

    // Step 3: Format the data
    foreach ($shipCounts as $item) {
        if (in_array($item->address_type, [1, 2])) {
            $shipDisplay[] = [
                'label' => $basicTypes[$item->address_type]['label'],
                'icon' => $basicTypes[$item->address_type]['icon'],
                'count' => $item->count
            ];
        } elseif ($item->address_type == 3 && $item->pickup_point_name) {
            $shipDisplay[] = [
                'label' => $item->pickup_point_name,
                'icon' => 'bx-store-alt',
                'count' => $item->count
            ];
        }
    }
}
@endphp



                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
           
  <div class="card h-100">
 

    <div class="card-header d-flex align-items-center justify-content-between pb-0">
           

      <div class="card-title mb-0">
        <h5 class="m-0 me-2">Order Statistics</h5>
        <small class="text-muted">Based on Shipping Address Type</small>
      </div>
   <!--   <div class="dropdown">
        <button class="btn p-0" type="button" id="orderStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="bx bx-dots-vertical-rounded"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orderStatistics">
          <a class="dropdown-item" href="#">Select All</a>
          <a class="dropdown-item" href="#">Refresh</a>
          <a class="dropdown-item" href="#">Share</a>
        </div>
      </div>-->
    </div>
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex flex-column align-items-center ">
          <h2 class="mb-2">
            {{ array_sum(array_column($shipDisplay, 'count')) }}
          </h2>
          <span>Total Orders</span>
        </div>
        <div id="orderStatisticsChart1"></div>
      </div>

      <ul class="p-0 m-0">
@foreach($shipDisplay as $item)
<li class="d-flex mb-4 pb-1">
  <div class="avatar flex-shrink-0 me-3">
    <span class="avatar-initial rounded bg-label-primary">
      <i class="bx {{ $item['icon'] }}"></i>
    </span>
  </div>
  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between ">
    <div class="me-1">
      <h6 class="mb-0">{{ $item['label'] }}</h6>
      <small class="text-muted">
        {{ $item['icon'] == 'bx-store-alt' ? 'Pickup Point' : 'Shipping to ' . $item['label'] }}
      </small>
    </div>
 
    <div class="user-progress">
      <small class="fw-semibold">{{ $item['count'] }}</small>
    </div>
  </div>
</li>
@endforeach


      </ul>
    </div>
  </div>
</div>

     
           <!--/ Order Statistics -->
         @php
    $vendorName = session('username');
    $selectedYear = request('year') ?? date('Y');

    $vendor = DB::table('vendor')->where('username', $vendorName)->first();
    $vendorId = $vendor?->unique_id;

    $schoolOrderData = DB::table('sale_tax_register')
        ->join('users', 'sale_tax_register.user_id', '=', 'users.unique_id')
        ->join('school', 'users.school_code', '=', 'school.school_code')
        ->join('orders','orders.user_id', '=','users.unique_id')
       ->where('sale_tax_register.vendor_id', $vendorId)
       ->where('sale_tax_register.del_status', 0) 
       ->where('orders.order_year', $selectedYear)
       ->whereIn('orders.order_status', [3, 4])
        ->select('school.school_name as school_name', DB::raw('count(sale_tax_register.id) as order_count'))
        ->groupBy('school.school_name')
        ->get();

    $totalSchools = $schoolOrderData->count();

 
@endphp


                <!-- Expense Overview -->
                <div class="col-md-6 col-lg-4 order-1 mb-4">
               <div class="card h-100">
     <form method="GET" id="yearFilterForm" class="mb-1 mt-2 d-flex justify-content-center">
  <select name="year" id="yearSelect" class="form-select w-50" onchange="document.getElementById('yearFilterForm').submit()">
    @for ($y = date('Y'); $y >= 2021; $y--)
      <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
    @endfor
  </select>
</form>

          <div class="card-header">
              
               <h5 class="card-title mb-0">School Engagement</h5>
          
               <small class="text-muted">Most active schools by order count</small>
              </div>
              <div class="card-body">
                  @if ($schoolOrderData->isNotEmpty())
        <canvas id="schoolEngagementChart1" height="280"></canvas>
      @else
        <p class="text-muted">No school engagement data available.</p>
      @endif
            </div>
         </div>
        </div>

             
              <!--  <div class="col-md-6 col-lg-4 order-1 mb-4">
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
                </div>->
  

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
@php


$today = Carbon::today()->toDateString();
$vendorName = session('username'); // ✅ Logged-in vendor's name

// Step 1: Get vendor_id from vendor_name
$vendor = DB::table('vendor')->where('username', $vendorName)->first();
$vendorId = $vendor?->unique_id; // Use null-safe access if vendor not found

$todayTransactions = [];

if ($vendorId) {
    // Step 2: Use vendor_id in transaction query
    $todayTransactions = DB::table('order_payment')
        ->join('orders', 'orders.user_id', '=', 'order_payment.user_id')
        ->whereDate('order_payment.transaction_date', $today)
       ->where('orders.vendor_id', $vendorId) // ✅ Now using correct vendor_id
        ->where('order_payment.amount', '>', 0)
        ->orderByDesc('order_payment.transaction_date')
        ->select(
            'order_payment.transaction_id',
            'order_payment.transaction_date',
            'order_payment.amount'
        )
        ->distinct()
        ->get();
}
@endphp


<div style="max-height: 400px; overflow-y: auto; overflow-x: auto; scrollbar-width: thin; scrollbar-color:#696cff transparent;">
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
            <h6 class="mb-0">{{ number_format($transaction->amount, 2) }}</h6>
          </div>
        </div>
      </li>
    @empty
      <li class="text-muted">No transactions found for today.</li>
    @endforelse
  </ul>
</div>

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
    
   @php
  // Extract labels and counts from $shipDisplay
  $labels = array_map(fn($item) => $item['label'], $shipDisplay);
  $series = array_map(fn($item) => $item['count'], $shipDisplay);

  // Calculate total orders for total label in donut center
  $totalOrders = array_sum($series);
@endphp

<script>
;
  const chartOrderStatistics = document.querySelector('#orderStatisticsChart1');
  document.getElementById('yearSelect').addEventListener('change', function () {
    document.getElementById('yearFilterForm').submit();
  })

  if (chartOrderStatistics) {
    const orderChartConfig = {
      chart: {
        height: 200,  // Increased height for bigger chart
        type: 'pie'
      },
      labels: @json($labels),
      series: @json($series),
      colors: ['#696CFF', '#FFAB00', '#71DD37', '#00bdae', '#ff4560'],
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
        show: false // <-- Hide legend to remove label/color key below chart
      },
      plotOptions: {
        pie: {
          donut: {
            size: '80%',  // Bigger donut size (thicker ring)
            labels: {
              show: true,
              total: {
                show: true,
                label: 'Orders',
                formatter: function () {
                  return {{ $totalOrders }};
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
          formatter: value => 'Rs.' + value.toFixed(2)
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const schoolLabels = {!! json_encode($schoolOrderData->pluck('school_name')) !!};
  const schoolData = {!! json_encode($schoolOrderData->pluck('order_count')) !!};
 
document.getElementById('yearSelect').addEventListener('change', function () {
    document.getElementById('yearFilterForm').submit();
  });

  const ctx = document.getElementById('schoolEngagementChart1').getContext('2d');

const schoolEngagementChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: schoolLabels,
    datasets: [{
      label: 'Orders',
      data: schoolData,
      fill: false,
      borderColor: '#42a5f5',
      backgroundColor: '#42a5f5',
      tension: 0.3,
      pointRadius: 5,
      pointBackgroundColor: '#1e88e5'
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      tooltip: {
        callbacks: {
          label: tooltipItem => `Orders: ${tooltipItem.raw}`
        }
      }
    },
    scales: {
      x: {
        display: false,  // Hide entire x-axis including labels and ticks
        title: { display: false, text: 'School Name' },
        ticks: {
          maxRotation: 45,
          minRotation: 45,
          autoSkip: false
        }
      },
      y: {
        beginAtZero: true,
        title: { display: true, text: 'Order Count' }
      }
    }
  }
});

</script>



   <!-- footerscrit -->
  </body>
</html>
