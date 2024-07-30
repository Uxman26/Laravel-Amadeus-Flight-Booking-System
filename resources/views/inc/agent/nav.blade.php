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
                <li class="page-active"><a href="{{ route('agent.dashboard.index') }}" class=" "><i class="la la-dashboard mr-2"></i> Dashboard</a></li>
                <li class=""><a href="{{ route('agent.booking.index') }}" class=" "><i class="la la-dashboard mr-2"></i> My Booking</a></li>
                <li class=""><a href="{{ route('agent.booking.departure') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> My Departure</a></li>
                <li class=""><a href="{{ route('agent.booking.daily_report') }}" class=" "><i class="la la-shopping-cart mr-2 text-color-3"></i> Daily Report</a></li>
            </ul>
        </div>
    </div>
</div>