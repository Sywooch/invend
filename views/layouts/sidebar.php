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
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Smart Fanis Co.</strong>
                    </span> <span class="text-muted text-xs block">Admin <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="/user/create">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="/site/logout">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    INVEND
                </div>
            </li>
            <li>
                <a href="/dashboard/d2"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Purchasing Orders</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/po/create">New Purchasing Order</a></li>
                    <li><a href="/po/index">Purchasing Order List</a></li>
                    <li><a href="/po-return/create">New Purchasing Return</a></li>
                    <li><a href="/po-return/index">Purchasing Return List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Sales Orders</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/sales-order/create">New Sales Order</a></li>
                    <li><a href="/sales-order/index">Sales Order List</a></li>
                    <li><a href="/sales-order-return/create">New Sales Return</a></li>
                    <li><a href="/sales-order-return/index">Sales Return List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Bill of Materials</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/bom/create">New Bill</a></li>
                    <li><a href="/bom/index">Bill List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Work Orders</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/wo/create">New Woek Order</a></li>
                    <li><a href="/wo/index">Work Order List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Administration</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/product/create">New Product</a></li>
                    <li><a href="/product/index">Product List</a></li>
                    <li><a href="/vendor/create">New Vendor</a></li>
                    <li><a href="/vendor/index">Vendor List</a></li>
                    <li><a href="/customer/create">New Customer</a></li>
                    <li><a href="/customer/index">Customer List</a></li>
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
        </ul>
    </div>
</nav>