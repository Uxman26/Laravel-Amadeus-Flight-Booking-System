<div class="sidebar-nav" style="margin-top: 50px;z-index:50">
    <div class="sidebar-nav-body">
        <div class="side-menu-close">
            <i class="la la-times"></i>
        </div>
        <div class="author-content" style="padding-top: 40px !important;">
            <div class="d-flex align-items-center">
                <div class="author-img avatar-sm">
                    <img src="{{ asset('assets/theme/img/user.png') }}" alt="user" style="height:auto">
                </div>
                <div class="author-bio">
                    <h4 class="author__title"><strong style="text-transform:capitalize">{{ auth()->user()->name }}</strong></h4>
                    <span class="author__meta">Welcome Back</span>
                </div>
            </div>
        </div>
        <div class="sidebar-menu-wrap">
            <ul class="sidebar-menu list-items">
                <li class="page-active"><a href="{{ route('admin.dashboard.index') }}" class=" "><i class="la la-dashboard mr-2"></i> Dashboard</a></li>
                <li class=""><a href="{{ route('admin.booking.index') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> My Bookings</a></li>
                <li class=""><a href="{{ route('admin.booking.departure') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> My Departure</a></li>
                <li class=""><a href="{{ route('admin.booking.daily_report') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> Daily Report</a></li>
                <li class=""><a href="{{ route('admin.package.packageBooking') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> Package Bookings</a></li>
                <li class=""><a href="{{ route('admin.passenger.index') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> All Passengers</a></li>
                <li class=""><a href="{{ route('admin.users.index') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> All Users</a></li>
                <li class=""><a href="{{ route('admin.finance.create') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> Add Transaction</a></li>
                <li class=""><a href="{{ route('admin.finance.index') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> Finance History</a></li>
                <li class=""><a href="{{ route('admin.commission.index') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> Commision Setting</a></li>
                <li class=""><a href="{{ route('admin.setting.index') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> Website Setting</a></li>
                <li class=""><a href="{{ route('admin.api.index') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> API Live Mode</a></li>
                <li class=""><a href="{{ route('admin.package.index') }}" class=" "><i class="la la-cube mr-2 text-color-3"></i> Package </a></li>
                <li class=""><a href="{{ route('admin.news.index') }}" class=" "><i class="la la-newspaper mr-2 text-color-3"></i> News </a></li>
                <li class=""><a href="{{ route('admin.email.index') }}" class=" "><i class="la la-newspaper mr-2 text-color-3"></i> Email </a></li>
                <li class=""><a href="{{ route('admin.slider.index') }}" class=" "><i class="la la-images mr-2 text-color-3"></i> Sliders </a></li>
                <li class=""><a href="{{ route('admin.banner.index') }}" class=" "><i class="la la-image mr-2 text-color-3"></i> Banner/Logo </a></li>
                <li class=""><a href="{{ route('admin.promotion.index') }}" class=" "><i class="la la-image mr-2 text-color-3"></i> Promotions </a></li>
                <li class=""><a href="{{ route('admin.footer.settings') }}" class=" "><i class="la la-cog mr-2 text-color-3"></i> Footer </a></li>
            </ul>
        </div>
    </div>
</div>