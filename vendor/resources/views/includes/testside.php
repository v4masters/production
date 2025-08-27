<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <img src="{{ asset('assets/img/logo/Skype_Picture_2024_03_07T12_51_38_623Z.jpeg') }}" alt="Logo"
                width="200">
            <a href="#" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ (request()->is('welcome')) ? 'active' : '' }}">
            <a href="{{url('welcome')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>



        <li class="menu-item {{ (request()->is('view_vehicle','vehicle','update_time','add_review','rating_view','view_vehicle_model*','edit_vehicle*')) ? 'open active' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fas fa-database"></i>
                <div data-i18n="Layouts">Master Data </div>
            </a>


            <ul class="menu-sub">
                <li class="menu-item {{ (request()->is('view_vehicle','vehicle','view_vehicle_model*','edit_vehicle*')) ? 'open active' : '' }}">
                    <a href="{{url('view_vehicle')}}" class="menu-link">
                        <div data-i18n="Without menu"> Vehicles </div>
                    </a>
                </li>
            </ul>


            <ul class="menu-sub">
                <li class="menu-item {{ (request()->is('update_time')) ? 'open active' : '' }}">
                    <a href="{{url('update_time')}}" class="menu-link">
                        <div data-i18n="Without menu"> Manage Time Slot </div>
                    </a>
                </li>
            </ul>


            <ul class="menu-sub">
                <li class="menu-item {{ (request()->is('rating_view','add_review')) ? 'open active' : '' }}">
                    <a href="{{url('rating_view')}}" class="menu-link">
                        <div data-i18n="Without menu">Review </div>
                    </a>
                </li>
            </ul>



            <!-- <ul class="menu-item {{ (request()->is('update_time' )) ? 'active' : '' }}">
                <a href="{{url('update_time')}}" class="menu-link">
                    <i class="menu-icon bi bi-star"></i>
                    <div data-i18n="Layouts">Manage Time Slot </div>
                </a>
            </ul> -->

<!-- 
            <ul class="menu-item {{ (request()->is('add_review' )) ? 'active' : '' }}">
                <a href="{{url('add_review')}}" class="menu-link">
                    <i class="menu-icon fas fa-clock"></i>
                    <div data-i18n="Layouts">Review</div>
                </a>
            </ul> -->


        </li>


        <li
            class="menu-item {{
            (request()->is('slider_view', 'category_view', 'view_services' ,'slider','category_add','add_services','edit_category*','edit_slider*', 'update_slider*' , 'edit_services*', 'display_service*'   )) ? 'open active' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fas fa-cogs"></i>
                <div data-i18n="Layouts">Manage App</div>
            </a>
            <ul class="menu-sub">
                <li
                    class="menu-item {{ (request()->is('slider_view','slider','edit_slider*',)) ? 'open active' : '' }}">
                    <a href="{{ url('slider_view') }}" class="menu-link">
                        <div data-i18n="Without menu">Slider</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ (request()->is('category_view','category_add','edit_category*', )) ? 'open active' : '' }}">
                    <a href="{{ url('category_view') }}" class="menu-link">
                        <div data-i18n="Without menu">Category</div>
                    </a>
                </li>
                <li
                    class="menu-item {{ (request()->is('view_services','add_services', 'edit_services*', 'display_service*')) ? 'open active' : '' }}">
                    <a href="{{ url('view_services') }}" class="menu-link">
                        <div data-i18n="Without menu">Service</div>
                    </a>
                </li>
            </ul>
        </li>







        <li class="menu-item {{ (request()->is('user_view' ,'display_user*')) ? 'active' : '' }}">
            <a href="{{url('user_view')}}" class="menu-link">
                <i class="menu-icon fas fa-users"></i>
                <div data-i18n="Layouts">Manage User </div>
            </a>
        </li>




        <li
            class="menu-item  {{ (request()->is('view_franchises','add_franchises' ,'edit_franchise*', 'display_franchise*','franchises_time_slot')) ? 'open active' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fas fa-building"></i>
                <div data-i18n="Layouts">Manage Franchises </div>
            </a>

            <ul class="menu-sub">
                <li
                    class="menu-item {{ (request()->is('view_franchises','add_franchises','edit_franchise*', 'display_franchise*')) ? 'active' : '' }}">
                    <a href="{{url('view_franchises')}}" class="menu-link">
                        <div data-i18n="Without menu">Franchises </div>
                    </a>
                </li>
                <li
                    class="menu-item {{ (request()->is('franchises_time_slot')) ? 'active' : '' }}">
                    <a href="{{url('franchises_time_slot')}}" class="menu-link">
                        <div data-i18n="Without menu">Franchises Time Slot</div>
                    </a>
                </li>
            </ul>
        </li>




        <li
            class="menu-item {{ (request()->is('view_booking','update_booking*', 'display_booking*','today_booking','complete_booking','rejected_booking',)) ? 'open active' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fas fa-calendar-alt"></i>
                <div data-i18n="Layouts">Manage Bookings </div>
            </a>

            <ul class="menu-sub">
                 <li
                    class="menu-item {{ (request()->is('today_booking','update_booking*')) ? 'active' : '' }}">
                    <a href="{{url('today_booking')}}" class="menu-link">
                        <div data-i18n="Without menu">Today Bookings </div>
                    </a>
                </li>
                <li
                    class="menu-item {{ (request()->is('complete_booking','update_booking*')) ? 'active' : '' }}">
                    <a href="{{url('complete_booking')}}" class="menu-link">
                        <div data-i18n="Without menu">Complete Bookings </div>
                    </a>
                </li>
                <li
                    class="menu-item {{ (request()->is('view_booking','update_booking*')) ? 'active' : '' }}">
                    <a href="{{url('view_booking')}}" class="menu-link">
                        <div data-i18n="Without menu">Incomplete Bookings </div>
                    </a>
                </li>
                <li
                    class="menu-item {{ (request()->is('rejected_booking','update_booking*')) ? 'active' : '' }}">
                    <a href="{{url('rejected_booking')}}" class="menu-link">
                        <div data-i18n="Without menu">Rejected Bookings </div>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="menu-item {{ (request()->is('washer_performance')) ? 'active' : '' }}">
            <a href="{{url('washer_performance')}}" class="menu-link">
                <i class="menu-icon fas fa-users"></i>
                <div data-i18n="Layouts">Washer Performance</div>
            </a>
        </li>

        <li class="menu-item {{ (request()->is('coupon_view' ,'edit_coupon*','add_coupon' ,'coupon_view_detail*')) ? 'active' : '' }}">
            <a href="{{url('coupon_view')}}" class="menu-link">
                <i class="menu-icon fab fa-codepen"></i>
                <div data-i18n="Layouts">Manage Coupons </div>
            </a>
        </li>





    </ul>
</aside>