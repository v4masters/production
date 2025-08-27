<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{url('/home')}}" class="app-brand-link">

      <img src="{{Storage::disk('s3')->url('site_img/evyapari-logo.png')}}" alt="Logo" width="150">


      <a href="{{url('/home')}}"  class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
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
    <!--<li class="menu-item">-->
    <!--  <a href="#" class="menu-link menu-toggle">-->
    <!--    <i class="menu-icon tf-icons bx bx-layout"></i>-->
    <!--    <div data-i18n="Layouts">Master Data</div>-->
    <!--  </a>-->


    <!--  <ul class="menu-sub">-->
      
    <!--       <li class="menu-item">-->
    <!--      <a href="{{url('manageboard')}}" class="menu-link">-->
    <!--        <div data-i18n="Without menu">Board</div>-->
    <!--      </a>-->
    <!--    </li>-->
        
       
    <!--  </ul>-->
    <!--</li>-->

<!-- Shop-->
<li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts">Shop</div>
      </a>

      <!--<ul class="menu-sub">-->
      <!--  <li class="menu-item">-->
      <!--    <a href="{{url('manageCategory')}}" class="menu-link">-->
      <!--      <div data-i18n="Without menu">Add Category</div>-->
      <!--    </a>-->
      <!--  </li>-->
      <!--</ul>-->
    </li>
<!-- Shop Ends -->

    <!--Manage Set-->
  
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
        <div data-i18n="Manage Route"> School Set</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('school_set')}}" class="menu-link">
            <div data-i18n="Create Route">School Set</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{url('school_set_view')}}" class="menu-link" >
            <div data-i18n="Order Under Route">View All School Set</div>
          </a>
        </li>

      </ul>
    </li>
    
    <li class="menu-item">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
        <div data-i18n="Manage Route"> Students</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{url('viewStudents')}}" class="menu-link">
            <div data-i18n="Create Route">View Students</div>
          </a>
        </li>
        <!--<li class="menu-item">-->
        <!--  <a href="{{url('school_set_view')}}" class="menu-link" >-->
        <!--    <div data-i18n="Order Under Route">View All School Set</div>-->
        <!--  </a>-->
        <!--</li>-->
      </ul>
    </li>

    <li class="menu-item">
      <a href="{{url('ordersView')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts">Orders</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="{{url('saleReportView')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts">Get Reports</div>
      </a>

      <!--<ul class="menu-sub">-->
      <!--  <li class="menu-item">-->
      <!--    <a href="{{url('category_catalog')}}" class="menu-link">-->
          
      <!--      <div data-i18n="Without menu">Add Inventory</div>-->
      <!--    </a>-->
      <!--  </li>-->
    
      <!--</ul>-->
    </li>

  
  </ul>
</aside>
<!--/ Menu -->