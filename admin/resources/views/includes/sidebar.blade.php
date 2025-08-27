<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{url('/home')}}" class="app-brand-link">

      <img src="{{ asset('assets/img/logo/evyapari-logo-1.png') }}" alt="Logo" width="150">


      <a href="{{url('/home')}}" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
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


    <!-- Layouts -->
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts">Master Data</div>
      </a>


      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('manage_access')}}" class="menu-link">
            <div data-i18n="Without menu">Admin Access</div>
          </a>
        </li>
        
          <li class="menu-item">
          <a href="{{url('courier_partner')}}" class="menu-link">
            <div data-i18n="Without menu">Admin Courier Partner</div>
          </a>
        </li>
        
        
         <li class="menu-item">
          <a href="{{url('managebrand')}}" class="menu-link">
            <div data-i18n="Without menu">Brand</div>
          </a>
        </li>
        
           <li class="menu-item">
          <a href="{{url('manageboard')}}" class="menu-link">
            <div data-i18n="Without menu">Board</div>
          </a>
        </li>
        
              <li class="menu-item">
          <a href="{{url('manageColour')}}" class="menu-link">
            <div data-i18n="Without menu">Colours</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('manageClass')}}" class="menu-link">
            <div data-i18n="Without menu">Classes</div>
          </a>
        </li>
        
       
  
        <li class="menu-item">
          <a href="{{url('manageGST')}}" class="menu-link">
            <div data-i18n="Without menu">GST</div>
          </a>
        </li>
       
      
        <li class="menu-item">
          <a href="{{url('inventoryforms')}}" class="menu-link">
            <div data-i18n="Without menu">Inventory form</div>
          </a>
        </li>
        
          <li class="menu-item">
          <a href="{{url('manageorganisation')}}" class="menu-link">
            <div data-i18n="Without menu">Organisation</div>
          </a>
        </li>
        
          <li class="menu-item">
          <a href="{{url('view_pickup_points')}}" class="menu-link">
            <div data-i18n="Without menu">Pickup Point</div>
          </a>
        </li>
          
          
        <li class="menu-item">
          <a href="{{url('manageqtyunit')}}" class="menu-link">
            <div data-i18n="Without menu">Quantity Unit</div>
          </a>
        </li>
        
         <li class="menu-item">
          <a href="{{url('register')}}" class="menu-link">
            <div data-i18n="Without menu">Register vendor</div>
          </a>
        </li>
         <li class="menu-item">
          <a href="{{url('managegrade')}}" class="menu-link">
            <div data-i18n="Without menu">School Grade</div>
          </a>
        </li>
          <li class="menu-item">
          <a href="{{url('set_type')}}" class="menu-link">
            <div data-i18n="Without menu">Set Type</div>
          </a>
        </li>
          <li class="menu-item">
          <a href="{{url('set_cat')}}" class="menu-link">
            <div data-i18n="Without menu">Set Category</div>
          </a>
        </li>
        
        
        <li class="menu-item">
          <a href="{{url('managesize')}}" class="menu-link">
            <div data-i18n="Without menu">Size</div>
          </a>
        </li>
          <li class="menu-item">
          <a href="{{url('managestream')}}" class="menu-link">
            <div data-i18n="Without menu">Stream</div>
          </a>
        </li>

        <li class="menu-item">
          <a href="{{url('get_vendor_pp')}}" class="menu-link">
            <div data-i18n="Without menu">Vendor Pickup Location</div>
          </a>
        </li>        
        
         
      </ul>
    </li>

<!-- Manage Users -->
<li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts">Manage Users</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('user_student')}}" class="menu-link">
            <div data-i18n="Without menu">Student</div>
          </a>
        </li>
          <li class="menu-item">
          <a href="{{url('user_vendor')}}" class="menu-link">
            <div data-i18n="Without menu">Vendor</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('user_school')}}" class="menu-link">
            <div data-i18n="Without menu">School</div>
          </a>

        </li>

      </ul>
    </li>
<!-- Manage users Ends -->



<!-- Manage Category -->
<li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts">Manage Category</div>
      </a>


      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('manageCategory')}}" class="menu-link">
            <div data-i18n="Without menu">Add Category</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_Category')}}" class="menu-link">
            <div data-i18n="Without menu">View Category</div>
          </a>

        </li>

      </ul>
    </li>
<!-- Manage Category Ends -->

    
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts">Manage Sub Admin</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('add_sub_admin')}}" class="menu-link">
            <div data-i18n="Without menu">Add Sub Admin</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_sub_admin')}}" class="menu-link">
            <div data-i18n="Without navbar">View Sub Admin</div>
          </a>
        </li>
      </ul>
    </li>



<!---inventory start--->
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
        <!--<li class="menu-item">-->
        <!--  <a href="{{url('view_inventory_form')}}" class="menu-link">-->
        <!--    <div data-i18n="Without navbar">View Full Inventory</div>-->
        <!--  </a>-->
        <!--</li>-->
        <li class="menu-item">
          <a href="{{url('view_approved_inventory')}}" class="menu-link">
            <div data-i18n="Container"> Approved Inventory</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_pending_inventory')}}" class="menu-link">
            <div data-i18n="Fluid"> Pending Inventory</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_empty_inventory')}}" class="menu-link">
            <div data-i18n="Blank">View Empty Stock</div>
          </a>
        </li>
      </ul>
    </li>
    
    
    
<!----manage set inventory start---->
<li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts"> Set Inventory</div>
      </a>


      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('inventory')}}" class="menu-link">
            <div data-i18n="Without menu">Add Book Set Inventory</div>
          </a>
        </li>
          <li class="menu-item">
          <a href="{{url('uniform_set_inventory')}}" class="menu-link">
            <div data-i18n="Without menu">Add Uniform Set Inventory</div>
          </a>
        </li>
         <li class="menu-item">
          <a href="{{url('book_set_items')}}" class="menu-link">
            <div data-i18n="Without menu">View Book Set Inventory</div>
          </a>

        </li>
        <li class="menu-item">
          <a href="{{url('set_items')}}" class="menu-link">
            <div data-i18n="Without menu">View Uniform Set Inventory</div>
          </a>

        </li>

      </ul>
    </li>
    <!----manage set inventory end------->



    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Orders</span>
    </li>
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div data-i18n="Account Settings">Manage Orders</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('new_orders')}}" class="menu-link">
            <div data-i18n="Account">New Orders</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('/orders/order-processing-online')}}" class="menu-link">
            <div data-i18n="Notifications">Orders Processing (online)</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('order_processing_cod')}}" class="menu-link">
            <div data-i18n="Connections">Orders Processing (COD)</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('order-processing-payout')}}" class="menu-link">
            <div data-i18n="Connections">Order Processing for Payout</div>
          </a>
        </li>
         <li class="menu-item">
          <a href="{{url('/payoutbill')}}" class="menu-link">
            <div data-i18n="Connections">Payout Bill</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('uniform_order')}}" class="menu-link">
            <div data-i18n="Connections">Uniform Orders UnderProcessing</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('batch_underprocessing')}}" class="menu-link">
            <div data-i18n="Connections">Batch UnderProcessing (COD)</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('orders_cancelled')}}" class="menu-link">
            <div data-i18n="Connections">Cancelled Orders</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('search_order')}}" class="menu-link">
            <div data-i18n="Search Orders ">Search Orders </div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('pending_order')}}" class="menu-link">
            <div data-i18n="Search Orders ">Update Pending Orders </div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
        <div data-i18n="Manage Route">Manage Route</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('create_route')}}" class="menu-link">
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
  <!--  <li class="menu-item">
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
    </li> -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Billing</span>
    </li>
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div data-i18n="Account Settings">View Others Billing</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('view_itemwise')}}" class="menu-link">
            <div data-i18n="Account">View Item Wise</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('view_companywise')}}" class="menu-link">
            <div data-i18n="Notifications">View company Wise</div>
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
          <a href="{{url('school_set_org_wise')}}" class="menu-link" >
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
          <a href="{{url('item_sale_report')}}" class="menu-link">
            <div data-i18n="View Date Date">Item Sale Report</div>
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
  </ul>
</aside>
<!--/ Menu -->