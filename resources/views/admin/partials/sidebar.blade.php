<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <li>
                <a class="active" href="{{ route('home') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-laptop"></i>
                    <span>Product</span>
                </a>
                <ul class="sub">
                    <li><a  href="{{ route('product.index') }}">Index</a></li>
                </ul>
            </li>


        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
