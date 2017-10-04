<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> 
                    <span>
                    <img alt="image" class="img-circle" src="<?php echo Yii::getAlias('@web').'/img/profile_small.jpg'; ?>" />
                     </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                    </span> <span class="text-muted text-xs block">Admin <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="user/create">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    INVEND
                </div>
            </li>
            <li class="active">
                <a href="/site/index"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="active"><a href="/dashboard/d1">Inventory</a></li>
                    <li><a href="/dashboard/d2">Purchase Orders</a></li>
                    <li><a href="/dashboard/d3">Sales Orders</a></li>
                    <li><a href="/dashboard/d4">Customers</a></li>
                    <li><a href="/dashboard/d5">Suppliers</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Inventory Reports</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/report/">Inventory Summary</a></li>
                    <li><a href="/report/">Inventory Details Report</a></li>
                    <li><a href="/report/">Inventory by Location</a></li>
                    <li><a href="/report/">Historical Inventory</a></li>
                    <li><a href="/report/">Inventory Movement Summary</a></li>
                    <li><a href="/report/">Inventory Movement Details</a></li>
                    <li><a href="/report/">Stock Reordering Report</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Purchasing Reports</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/report/">Purchasing Order Product Summary</a></li>
                    <li><a href="/report/">Purchasing Order Details</a></li>
                    <li><a href="/report/">Purchasing Order Status</a></li>
                    <li><a href="/report/">Vendor Payment Details</a></li>
                    <li><a href="/report/">Vendor Product List</a></li>
                    <li><a href="/report/">Vendor List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Sales Reports</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/report/">Sales by Product Summary</a></li>
                    <li><a href="/report/">Sales by Product Details</a></li>
                    <li><a href="/report/">Sales Order Summary</a></li>
                    <li><a href="/report/">Sales Order Profit Report</a></li>
                    <li><a href="/report/">Sales Order Operational Report</a></li>
                    <li><a href="/report/">Sales Representative Report</a></li>
                    <li><a href="/report/">Customer Payment Summary</a></li>
                    <li><a href="/report/">Customer Order History</a></li>
                    <li><a href="/report/">Customer List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Purchasing Orders</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/po/create">Receive</a></li>
                    <li><a href="/po-return/">Return</a></li>
                    <li><a href="/po/index">Receive List</a></li>
                    <li><a href="/po-return/index">Return List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Sales Orders</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/sales-order/create">Fulfil</a></li>
                    <li><a href="/sales-order-return/create">Return</a></li>
                    <li><a href="/sales-order/index">Receive List</a></li>
                    <li><a href="/sales-order-return/index">Return List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Bill of Materials</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/bo/create">Create</a></li>
                    <li><a href="/bo/index">List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Work Orders</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/wo/create">Create</a></li>
                    <li><a href="/wo/index">List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Administration</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/product/create">Product</a></li>
                    <li><a href="/vendor/create">Vendor</a></li>
                    <li><a href="/vendor/create">Customer</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>