<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView; 
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Product;
use app\models\ProductCategory;
use app\models\Location;
use app\models\Vendor;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dashboard'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="widget red-bg p-lg text-center">
                <div class="row">
                    <div class="col-xs-4 text-center">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <a href="<?= Url::toRoute(['/sales-order/create']) ?>" target="_blank"> <span class="font-bold" style="color: white;"> New Sales </span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="widget navy-bg p-lg text-center ">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-truck fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <a href="<?= Url::toRoute(['/po/create']) ?>" target="_blank"> <span class="font-bold" style="color: white;"> New Purchase </span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="widget lazur-bg p-lg text-center ">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <a href="<?= Url::toRoute(['/customer/create']) ?>" target="_blank"> <span class="font-bold" style="color: white;"> New Customer </span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="widget yellow-bg p-lg text-center">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <a href="<?= Url::toRoute(['/production/create']) ?>" target="_blank"> <span class="font-bold" style="color: white"> New Production </span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">Monthly</span>
                    <h5>Sales</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?= $monthlySales ?></h1>
                    <div class="stat-percent font-bold text-success"><?= $monthlySalesPercentage ?>% <i class="fa fa-bolt"></i></div>
                    <small>Sales</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">Quaterly</span>
                    <h5>Sales</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?= $quaterlySales ?></h1>
                    <div class="stat-percent font-bold text-info"><?= $quaterlySalesPercentage ?>% <i class="fa fa-level-up"></i></div>
                    <small>Sales</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">Weekly</span>
                    <h5>Sales</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?= $weeklySales ?></h1>
                    <div class="stat-percent font-bold text-info"><?= $weeklySalesPercentage ?>% <i class="fa fa-level-up"></i></div>
                    <small>Sales</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">Daily</span>
                    <h5>Sales</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?= $dailySales ?></h1>
                    <div class="stat-percent font-bold text-info"><?= $dailySalesPercentage ?>% <i class="fa fa-level-up"></i></div>
                    <small>Sales</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Total Customers</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?= $totalCustomers ?></h1>
                    <small>Total Customers</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">Today</span>
                    <h5>Top Customer</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?= $highestCustomer ?></h1>
                    <div class="stat-percent font-bold text-info"><?= $highestSalePercentage ?>% <i class="fa fa-level-up"></i></div>
                    <small>Top Customer</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">Week</span>
                    <h5>New Customers</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?= $weeklyTotalCustomers ?></h1>
                    <small>New Customers</small>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>

<script>
    $(document).ready(function() {
        $('.chart').easyPieChart({
            barColor: '#f8ac59',
//                scaleColor: false,
            scaleLength: 5,
            lineWidth: 4,
            size: 80
        });

        $('.chart2').easyPieChart({
            barColor: '#1c84c6',
//                scaleColor: false,
            scaleLength: 5,
            lineWidth: 4,
            size: 80
        });

        var data2 = [
            [gd(2012, 1, 1), 7], [gd(2012, 1, 2), 6], [gd(2012, 1, 3), 4], [gd(2012, 1, 4), 8],
            [gd(2012, 1, 5), 9], [gd(2012, 1, 6), 7], [gd(2012, 1, 7), 5], [gd(2012, 1, 8), 4],
            [gd(2012, 1, 9), 7], [gd(2012, 1, 10), 8], [gd(2012, 1, 11), 9], [gd(2012, 1, 12), 6],
            [gd(2012, 1, 13), 4], [gd(2012, 1, 14), 5], [gd(2012, 1, 15), 11], [gd(2012, 1, 16), 8],
            [gd(2012, 1, 17), 8], [gd(2012, 1, 18), 11], [gd(2012, 1, 19), 11], [gd(2012, 1, 20), 6],
            [gd(2012, 1, 21), 6], [gd(2012, 1, 22), 8], [gd(2012, 1, 23), 11], [gd(2012, 1, 24), 13],
            [gd(2012, 1, 25), 7], [gd(2012, 1, 26), 9], [gd(2012, 1, 27), 9], [gd(2012, 1, 28), 8],
            [gd(2012, 1, 29), 5], [gd(2012, 1, 30), 8], [gd(2012, 1, 31), 25]
        ];

        var data3 = [
            [gd(2012, 1, 1), 800], [gd(2012, 1, 2), 500], [gd(2012, 1, 3), 600], [gd(2012, 1, 4), 700],
            [gd(2012, 1, 5), 500], [gd(2012, 1, 6), 456], [gd(2012, 1, 7), 800], [gd(2012, 1, 8), 589],
            [gd(2012, 1, 9), 467], [gd(2012, 1, 10), 876], [gd(2012, 1, 11), 689], [gd(2012, 1, 12), 700],
            [gd(2012, 1, 13), 500], [gd(2012, 1, 14), 600], [gd(2012, 1, 15), 700], [gd(2012, 1, 16), 786],
            [gd(2012, 1, 17), 345], [gd(2012, 1, 18), 888], [gd(2012, 1, 19), 888], [gd(2012, 1, 20), 888],
            [gd(2012, 1, 21), 987], [gd(2012, 1, 22), 444], [gd(2012, 1, 23), 999], [gd(2012, 1, 24), 567],
            [gd(2012, 1, 25), 786], [gd(2012, 1, 26), 666], [gd(2012, 1, 27), 888], [gd(2012, 1, 28), 900],
            [gd(2012, 1, 29), 178], [gd(2012, 1, 30), 555], [gd(2012, 1, 31), 993]
        ];


        var dataset = [
            {
                label: "Number of orders",
                data: data3,
                color: "#1ab394",
                bars: {
                    show: true,
                    align: "center",
                    barWidth: 24 * 60 * 60 * 600,
                    lineWidth:0
                }

            }, {
                label: "Payments",
                data: data2,
                yaxis: 2,
                color: "#1C84C6",
                lines: {
                    lineWidth:1,
                        show: true,
                        fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.2
                        }, {
                            opacity: 0.4
                        }]
                    }
                },
                splines: {
                    show: false,
                    tension: 0.6,
                    lineWidth: 1,
                    fill: 0.1
                },
            }
        ];


        var options = {
            xaxis: {
                mode: "time",
                tickSize: [3, "day"],
                tickLength: 0,
                axisLabel: "Date",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Arial',
                axisLabelPadding: 10,
                color: "#d5d5d5"
            },
            yaxes: [{
                position: "left",
                max: 1070,
                color: "#d5d5d5",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Arial',
                axisLabelPadding: 3
            }, {
                position: "right",
                clolor: "#d5d5d5",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: ' Arial',
                axisLabelPadding: 67
            }
            ],
            legend: {
                noColumns: 1,
                labelBoxBorderColor: "#000000",
                position: "nw"
            },
            grid: {
                hoverable: false,
                borderWidth: 0
            }
        };

        function gd(year, month, day) {
            return new Date(year, month - 1, day).getTime();
        }

        var previousPoint = null, previousLabel = null;

        $.plot($("#flot-dashboard-chart"), dataset, options);
    });
</script>


<script>
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };
        toastr.success('Inventory System for Everybody', 'Welcome to INVEND SYS');

    }, 1300);
</script>