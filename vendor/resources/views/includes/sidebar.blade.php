<style>
.activemainlist
{
    color: #696cff !important;
    background-color: rgba(105, 108, 255, 0.16) !important;
    margin: 0.0625rem 0rem 0.0625rem 1rem !important;
    border-radius: 0.375rem !important;
    width: 87% !important;
}
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{url('/home')}}" class="app-brand-link">

      <img src="{{Storage::disk('s3')->url('site_img/evyapari-logo.png')}}" alt="Logo" width="150">


      <a href="#" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item active">
      <a href="{{url('/home')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

<!---inventory start--->
 
   @if(session('user_type')==1)
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts">Manage Inventory</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('category_catalog')}}" class="menu-link">
            <div data-i18n="Without menu">Add Inventory</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_inventory_form')}}" class="menu-link">
            <div data-i18n="Without navbar">View Full Inventory</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_approved_inventory')}}" class="menu-link">
            <div data-i18n="Container">View Approved Inventory</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_pending_inventory')}}" class="menu-link">
            <div data-i18n="Fluid">View Pending Inventory</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_empty_inventory')}}" class="menu-link">
            <div data-i18n="Blank">View Empty Stock</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-header small text-uppercase activemainlist">
      <span class="menu-header-text">Orders</span>
    </li>
   @endif 
    
    
    
    
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div data-i18n="Account Settings">Manage Orders</div>
      </a>
      <ul class="menu-sub">
          @if(session('user_type')==1)
        <li class="menu-item">
          <a href="{{url('new_orders')}}" class="menu-link">
            <div data-i18n="Account">New Orders</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('order_under_process')}}" class="menu-link">
            <div data-i18n="Notifications">Orders In Process <b style="font-size:12px">Online</b></div>
          </a>
        </li>
         <li class="menu-item">
          <a href="{{url('order_under_process_cod')}}" class="menu-link">
            <div data-i18n="Notifications">Orders In Process <b style="font-size:12px">COD</b></div>
          </a>
        </li>
       
        <!--<li class="menu-item">-->
        <!--  <a href="{{url('uniform_order')}}" class="menu-link">-->
        <!--    <div data-i18n="Connections">Uniform Orders UnderProcessing</div>-->
        <!--  </a>-->
        <!--</li>-->
        @endif 
        <li class="menu-item">
          <a href="{{url('bacth_order')}}" class="menu-link">
            <div data-i18n="Connections">Order Under Batch </div>
          </a>
        </li>
        
        @if(session('user_type')==1)
         <li class="menu-item">
          <a href="{{url('orders_cancelled')}}" class="menu-link">
            <div data-i18n="Connections">Cancelled Orders  </div>
          </a>
        </li>
         <li class="menu-item">
          <a href="{{url('move_order_ship_to_inprocess_view')}}" class="menu-link">
            <div data-i18n="Move Order Ship To Inproces">Move Order Ship To Inproces  </div>
          </a>
        </li>
         <li class="menu-item">
          <a href="{{url('all_order')}}" class="menu-link">
            <div data-i18n="Search Orders ">All Orders </div>
          </a>
        </li>
        @endif 
        <li class="menu-item">
          <a href="{{url('search_order')}}" class="menu-link">
            <div data-i18n="Search Orders ">Search Orders </div>
          </a>
        </li>
      </ul>
    </li>
    
    
    
    
    
    
    @if(session('user_type')==1)
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
        <div data-i18n="Manage Route">Manage Route</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('route')}}" class="menu-link">
            <div data-i18n="Create Route">Create Route</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('order_under_route')}}" class="menu-link" >
            <div data-i18n="Order Under Route">Order Under Route</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('completed_route')}}" class="menu-link" >
            <div data-i18n="View All Completed Route">View All Completed Route</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('pending_orders')}}" class="menu-link" >
            <div data-i18n="View All Completed Routes Pending Orders">View All Completed Routes Pending Orders</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('shipped_routes')}}" class="menu-link" >
            <div data-i18n="View All Shipped/Deliverd Routes">View All Shipped/Deliverd Routes</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cube-alt"></i>
        <div data-i18n="View Billing">View Billing</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('view_date_date')}}" class="menu-link">
            <div data-i18n="View Date Date">View Date Date</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_monthwise')}}" class="menu-link">
            <div data-i18n="View Month Wise">View Month Wise</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_yearwise')}}" class="menu-link">
            <div data-i18n="View Year Wise">View Year Wise</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_payments')}}" class="menu-link">
            <div data-i18n="View Payments">View Payments</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cube-alt"></i>
        <div data-i18n="View Billing">Product Review</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('product_review_view')}}" class="menu-link">
            <div data-i18n="View Date Date">View reviews</div>
          </a>
        </li>
      </ul>
    </li>
    @endif 
   
    <li class="menu-header small text-uppercase activemainlist">
      <span class="menu-header-text">Local Pickup Orders</span>
    </li>
     
    
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div data-i18n="Account Settings">Pickup Point Orders</div>
      </a>
      <ul class="menu-sub">
           @if(session('user_type')==1)
        <li class="menu-item">
          <a href="{{url('pp_new_orders')}}" class="menu-link">
            <div data-i18n="Account">PPO New Orders</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('pp_order_under_process')}}" class="menu-link">
            <div data-i18n="Notifications">PPO  In Process <b style="font-size:12px">Online</b></div>
          </a>
        </li>
         <li class="menu-item">
          <a href="{{url('pp_order_under_process_cod')}}" class="menu-link">
            <div data-i18n="Notifications">PPO  In Process <b style="font-size:12px">COD</b></div>
          </a>
        </li>
         @endif 
        
       
        <li class="menu-item">
          <a href="{{url('pp_bacth_order')}}" class="menu-link">
            <div data-i18n="Connections">PPO Under Batch </div>
          </a>
        </li>
        
       
      </ul>
    </li>
    
    
    @if(session('user_type')==1)
    <li class="menu-header small text-uppercase activemainlist">
      <span class="menu-header-text">Billing</span>
    </li>
    <li class="menu-item">
      <a href="" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div data-i18n="Account Settings"> Bill and Payouts</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
            @php  $datefrom=date('Y-m-01');$dateto=date('Y-m-d') @endphp
           <a href="{{url('delivered_orders')}}" class="menu-link">
            <div data-i18n="Account"> Deliver Orders </div>
          </a>
        </li>
        
        <li class="menu-item">
          <a href="{{route('bill_to_pay')}}" class="menu-link">
            <div data-i18n="Notifications">Bill to Pay</div>
          </a>
        </li>
        
         <li class="menu-item">
          <a href="{{url('paid_bill')}}" class="menu-link">
            <div data-i18n="Notifications">Paid Bill </div>
          </a>
        </li>
        
      </ul>
    </li>
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
        <div data-i18n="Manage Route">Manage School Set</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('schoolset')}}" class="menu-link">
            <div data-i18n="Create Route">School Set</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_school_wise_set')}}" class="menu-link" >
            <div data-i18n="Order Under Route">View All School Set</div>
          </a>
        </li>

      </ul>
    </li>
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cube-alt"></i>
        <div data-i18n="View Billing">Manage Sale Report</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('set_item_sale_report')}}" class="menu-link">
            <div data-i18n="View Date Date">Item Sale Report (set)</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('inv_item_sale_report')}}" class="menu-link">
            <div data-i18n="View Date Date">Item Sale Report (Inv)</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('uniform_item_report')}}" class="menu-link">
            <div data-i18n="View Month Wise">Uniform Item Report</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('sale_tax_register')}}" class="menu-link">
            <div data-i18n="View Year Wise">Sale Tax Register</div>
          </a>
        </li>

      </ul>
    </li>
     @endif 
    
  </ul>
</aside>
<!--/ Menu -->