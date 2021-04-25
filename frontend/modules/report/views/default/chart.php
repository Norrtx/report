<?php

use conquer\jvectormap\JVectorMapWidget;
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;
use sjaakp\gcharts\PieChart;
use yii\web\JsExpression;

$filledMap = [];
$selectedRegions = [];
foreach ($dataProvider->query->all() as $key => $model) {
    if ($key < 5) {
        array_push($selectedRegions, 'TH-' . $model->proviceCode);
        array_push($filledMap, [
            'code' => 'TH-' . $model->proviceCode,
            'name' => $model->provinceth,
            'total' => number_format($model->sumtotal, 2),
        ]);
    }
}
AppAsset::register($this);
$this->registerJsVar('filledMap', $filledMap);
$POS_HEAD = <<< JS
    function mouseHoverRegion(e, label, isSelected, selectedRegions) {
        html = '<b>' + label.html() + '</b>';
        filledMap.forEach(function(filled, i) {
            if(filled.code == isSelected) {
                html += '</br><b>Total: </b>' + filled.total + ' THB';
            }
        });
        label.html(html);
    }
JS;
$this->registerJs($POS_HEAD, static::POS_HEAD);
$POS_END = <<< JS
JS;
$this->registerJs($POS_END, static::POS_END);
?>
<div id="wrapper">
    <!-- ################################ -->
    <!-- ######### LIFTMENU  ############ -->
    <!-- ################################ -->
    <nav class="navbar-default navbar-static-side" role="navigation" style="min-height: 1100px;">
        <div class="sidebar-collapse">
            <ul id="side-menu" class="nav metismenu" style="display:block">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="<?= Url::to(['../img/logo-final-ed1.png']) ?>" width="180" />
                        </span>                        
                    </div>
                    <div class="logo-element">
                        <img alt="image" class="img-circle" src="<?= Url::to(['../img/xslogo.png']) ?>" alt="" style="width:60px;margin:-20px 0 -20px;">
                    </div>
                </li>
                <li><a href="/en/dashboard/index" ><i class="fa fa-flag"></i> <span class="nav-label">Dashboard</span></a></li>
                <li><a href="/en/order/order/all"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Orders</span></a></li>
                <li><a href="/en/order/payment/index" ><i class="fa fa-usd"></i> <span class="nav-label">Payment</span></a></li>
                <li><a href="/en/order/return/index"><i class="fa fa-undo"></i> <span class="nav-label">Return Orders</span></a></li>
                <li><a href="/en/order/shipment/index"><i class="fa fa-truck"></i> <span class="nav-label">Shipment</span></a></li>
                <li><a href="javascript:void(0);"><i class="fa fa-barcode"></i> <span class="nav-label">Products</span> <span class="fa arrow"></span></a>
                    <ul class='nav nav-second-level collapse'>
                        <li><a href="/en/category/category/index"><i class="fa fa-angle-double-right"></i> Categories</a></li>
                        <li><a href="/en/product/product/index" ><i class="fa fa-angle-double-right"></i> Products</a></li>
                        <li><a href="/en/product/barcode/index"><i class="fa fa-angle-double-right"></i> Print Barcodes</a></li>
                        <li><a href="/en/product/attribute/index" {fb-event}><i class="fa fa-angle-double-right"></i> Attribute</a></li>
                    </ul>
                </li>
                <li><a href="/en/customer/customer/index" ><i class="fa fa-users"></i> <span class="nav-label">Customers</span></a></li>
                <li><a href="javascript:void(0);"><i class="fa fa-cubes"></i> <span class="nav-label">Inventory</span> <span class="fa arrow"></span></a>
                    <ul class='nav nav-second-level collapse'>
                        <li><a href="/en/purchase/order/index"><i class="fa fa-angle-double-right"></i> Purchase Orders</a></li>
                        <li><a href="/en/inventories/stock/index"><i class="fa fa-angle-double-right"></i> Stock Balance</a></li>
                        <li><a href="/en/inventories/movement/index" ><i class="fa fa-angle-double-right"></i> Movement</a></li>
                        <li><a href="/en/inventories/transfer/index" ><i class="fa fa-angle-double-right"></i> Transfer</a></li>
                        <li><a href="/en/inventories/adjust/index"><i class="fa fa-angle-double-right"></i> Adjustment</a></li>
                        <li><a href="/en/setting/warehouses/index" ><i class="fa fa-angle-double-right"></i> Warehouse</a></li>
                        <li><a href="/en/vendor/vendor/index" ><i class="fa fa-angle-double-right"></i> Supplier</a></li>
                    </ul>
                </li>
                <li><a href="/en/report/summary/index"><i class="fa fa-bar-chart"></i> <span class="nav-label">Reports</span></a></li>
                <li><a href="/en/channel/channel/index"><i class="fa fa-tasks"></i> <span class="nav-label">Channels</span></a></li>
                <li><a href="/en/import_export/import-export/index" ><i class="fa fa-exchange"></i> <span class="nav-label">Import/Export</span></a></li>
                <li><a href="/en/fulfillment/fulfillment/dashboard"><i class="fa fa-paper-plane-o"></i> <span class="nav-label">Fulfillment</span></a></li>
                <li><a href="javascript:void(0);"><i class="fa fa-shopping-basket"></i> <span class="nav-label">Web Catalog</span> <span class="fa arrow"></span></a>
                    <ul class='nav nav-second-level collapse'>
                        <li><a href="/en/tools/catalog/product" > <i class="fa fa-angle-double-right"></i> Product Catalog</a></li>
                        <li><a href="/en/tools/catalog/category"> <i class="fa fa-angle-double-right"></i> Category Catalog</a></li>
                        <li><a href="/en/tools/catalog/setting" > <i class="fa fa-angle-double-right"></i> Setting Catalog</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);"><i class="fa fa-tty"></i> <span class="nav-label">Marketing Tools</span> <span class="fa arrow"></span></a>
                    <ul class='nav nav-second-level collapse'>
                        <li><a href="/en/product/page/index" > <i class="fa fa-angle-double-right"></i> Sale Page</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);"><i class="fa fa-barcode"></i> <span class="nav-label">Serial Number</span> <span class="fa arrow"></span></a>
                    <ul class='nav nav-second-level collapse'>
                        <li><a href="/en/product/serial/index"> <i class="fa fa-angle-double-right"></i> Serial Number</a></li>
                        <li><a href="/en/product/serial/movement" > <i class="fa fa-angle-double-right"></i> Movement</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);"><i class="fa fa-cog"></i> <span class="nav-label">Settings</span> <span class="fa arrow"></span></a>
                    <ul class='nav nav-second-level collapse'>
                        <li><a href="/en/store/settings/view?section=info"><i class="fa fa-info-circle"></i> Store Info</a></li>
                        <li><a href="/en/store/settings/view?section=policy"><i class="fa fa-lock"></i> Store Policy</a></li>
                        <li><a href="/en/store/settings/view?section=order"><i class="fa fa-file-text"></i> Orders &amp; PO</a></li>
                        <li><a href="/en/shipping_setting/shipping-setting/index" ><i class="fa fa-truck"></i> Shipping</a></li>
                        <li><a href="/en/store_payment/store-payment/index"><i class="fa fa-shopping-cart"></i> Payment</a></li>
                        <li><a href="/en/tenant/role/index" ><i class="fa fa-user"></i> User Roles</a></li>
                        <li><a href="/en/tenant/user/index" ><i class="fa fa-users"></i> Users</a></li>
                        <li><a href="/en/document/default"><i class="fa fa-book"></i> Document Template</a></li>
                        <li><a href="/en/message/index" ><i class="fa fa-bell"></i> Notifications</a></li>
                        <li><a href="/en/inventory/sequencenumber/index" ><i class="fa fa-sort-numeric-asc"></i> Sequence Number</a></li>
                        <li><a href="/en/print_lot/print-lot/index" ><i class="fa fa-print"></i> Print Lot</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- ################################ -->
    <div id="page-wrapper" class="gray-bg " style="overflow: hidden; min-height: 465px;">
        <!-- ################################ -->
        <!-- ########## TOPMENU   ########### -->
        <!-- ################################ -->
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" onClick="CollapseMenu()" data-style="mini" href="javascript:void(0)"><i class="fa fa-dedent"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">'
                                        <img alt="image" class="img-circle" src="<?= Url::to(['../img/a7.jpg']) ?>">
                                    </a>
                                    <div class="media-body">
                                        <small class="pull-right">46h ago</small>
                                        <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="<?= Url::to(['../img/a4.jpg']) ?>">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right text-navy">5h ago</small>
                                        <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="<?= Url::to(['../img/profile.jpg']) ?>">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right">23h ago</small>
                                        <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                        <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="mailbox.html">
                                        <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i> <span class="label label-primary">8</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="mailbox.html">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="profile.html">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="grid_options.html">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="notifications.html">
                                        <strong>See All Alerts</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="login.html">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                    <li>
                        <a class="right-sidebar-toggle">
                            <i class="fa fa-tasks"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- ################################ -->
        <!-- ############ Heading ########### -->
        <!-- ################################ -->
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2> <i class="fa fa-shopping-cart"> </i> | Order By Province</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a>Report</a>
                    </li>
                    <li>
                        <a>Order Sales Reports</a>
                    </li>
                    <li class="active">
                        <strong>Order By Province</strong>
                    </li>
                </ol>
            </div>
        </div>
        <!-- ################################ -->
        <!-- ########### Report ############# -->
        <!-- ################################ -->
        <div class="wrapper wrapper-content ">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title no-borders p-sm">
                            <h5 class="no-margins"><i class="fa fa-sliders m-r-xs"></i> Search</h5>
                        </div>
                        <div class="ibox-content">
                            <form action="" id="Search" class="form-horizontal" method="get">                                                         
                                <div class="form-group">
                                    <?php
                                        date_default_timezone_set("Asia/Bangkok");
                                        $datenow = new DateTime();
                                        $dateend = new DateTime();
                                        $dateend->modify('-1 month'); 
                                    ?>   
                                    <label class="col-sm-2 control-label">Date : <i class="fa fa-calendar"></i></label>
                                    <div class="col-sm-4">
                                        <div id="w0-container" class="kv-drp-container ">
                                            <?= DateRangePicker::widget([
                                                'name' => 'date_range_3',
                                                'value' =>$dateend->format('d-m-Y H:i').' - '.$datenow->format('d-m-Y H:i'),                               
                                                'startAttribute' => 'datetime_start',
                                                'endAttribute' => 'datetime_end',
                                                'convertFormat' => true,
                                                'pluginOptions' => [
                                                    'timePicker' => true,
                                                    'timePicker24Hour'=> true,
                                                    'todayHighlight' => true,
                                                    'timePickerIncrement' => 1,
                                                    'locale' => ['format' => 'd-m-Y H:i'],                                                                                                   
                                                ]
                                            ]); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary ladda-button" data-style="expand-right"><i class="fa fa-search m-r-xs"></i>Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ################################ -->
            <!-- ############ Chart ############# -->
            <!-- ################################ -->
            <div class="panel">
                <div class="panel-body">
                    <div class="col-lg-4 text-center">
                        <h3 class=""><i class="fa fa-globe m-r-xs" style="font-size: 14px;"></i>จำนวนจังหวัดที่มีการขายสินค้า</h3>
                        <div class="m-b-xs">
                            <small class="">ยอดขายแบ่งแยกตามจังหวัด</small>
                        </div>
                        <div class="card-body">
                            <?= JVectorMapWidget::widget([
                                'map' => 'th_mill_en',
                                'htmlOptions' => [],
                                'options' => [
                                    'responsive' => true,
                                    'maintainAspectRatio' => false,
                                    'height' => 240,
                                    'regionsSelectable' => false,
                                    'regionStyle' => [
                                        'initial' => [
                                            'fill' => '#1ab394'
                                        ],
                                        'hover' => [
                                            'cursor' => 'pointer'
                                        ],
                                        // 'selected' => [
                                        //     'values'=> $selectedRegions,
                                        //     'attribute'=> 'fill',
                                        //     'scale' =>  [
                                        //        '1'=>'#FEE5D9',
                                        //        '2'=>'#A50F15',
                                        //        '3'=>'#FEE5D9',
                                        //        '4'=>'#A50F15',
                                        //        '5'=>'#FEE5D9',                                               
                                        //     ],
                                        // ],
                                        // 'selected' => [
                                        //     'attribute'=> 'fill',
                                        //     'values'=> 'selectedRegions',
                                        //     'scale'=> ['#C8EEFF', '#0071A4'],
                                        //     'normalizeFunction'=> 'polynomial',
                                        //     'min' => 'jvm.min(selectedRegions)',
                                        //     'max'=> 'jvm.max(selectedRegions)'
                                        // ],
                                        'selected' => [
                                            'fill' => '#f8ac59',
                                            'scale' =>  ['#FEE5D9', '#A50F15'],
                                        ],
                                        'selectedHover' => [
                                            'fill' => 'green'
                                        ]
                                    ],
                                    'selectedRegions' => $selectedRegions,
                                    'onRegionTipShow' => new JsExpression('mouseHoverRegion')
                                ]
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <h3 class=""><i class="fa fa-cubes m-r-xs" style="font-size: 14px;"></i>ลำดับสินค้าที่ขายดีที่สุด</h3>
                        <div class="m-b-xs">
                            <small class="">ยอดขายแบ่งแยกตามจังหวัด</small>
                        </div>
                        <div class="card-body">
                            <?= PieChart::widget([
                                'height' => 240,
                                'options' => [
                                    'height' => 240,
                                    'legend'=>[
                                    'position'=>'bottom',
                                    ],
                                    'fontSize'=> 12,
                                    'chartArea'=>[
                                        'left'=> 0,
                                        'top'=> 0,
                                        'width'=>'100%',
                                        'height'=>'90%',
                                    ],
                                ],
                                'dataProvider' => $Provider,
                                'columns' => [                                    
                                    'ordername:string:' . 'Sale',
                                    [
                                        'attribute' => 'ordersumtotal',
                                        'formatted' => function ($model) {
                                            return $model['ordersumtotal'] < 0 ? 0 :' Total: '.number_format($model['ordersumtotal'], 0) . ' THB';
                                        },
                                    ]
                                ],                               
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <h3 class=""><i class="fa fa-money m-r-xs" style="font-size: 14px;"></i>รูปแบบการชำระเงิน</h3>
                        <div class="m-b-xs">
                            <small class="">รูปแบบการชำระเงิน</small>
                        </div>
                        <div class="card-body">
                            <?= PieChart::widget([
                                'height' => 240,
                                'options' => [
                                    'height' => 240,
                                    'legend'=>'bottom',
                                    'fontSize'=> 12, 
                                    'chartArea'=>[
                                        'left'=> 0,
                                        'top'=> 0,
                                        'width'=>'100%',
                                        'height'=>'90%',
                                    ], 
                                ],
                                'dataProvider' => $dataPayment,
                                'columns' => [
                                    'paymentname:string',
                                    [
                                        'attribute' => 'count_payment',
                                        'formatted' => function ($model) {
                                            return $model['count_payment'] < 0 ? 0 : number_format($model['count_payment'], 0) . ' Order';
                                        },
                                    ]
                                    // 'count_payment:number',
                                ],                                
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ################################ -->
            <!-- ########### Product ############ -->
            <!-- ################################ -->
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#grid" style="padding: 10px 25px;" aria-expanded="false"><i class="fa fa-tags"></i> Order <span class="label label-primary"></span></a></li>
                </ul>
                <div class="tab-content">
                    <div id="grid" class="tab-pane active">
                        <div class="panel-body">
                            <div id="grid-by-category-pjax" data-pjax-container="" data-pjax-push-state data-pjax-timeout="1000">
                                <div id="w2" class="is-bs3 hide-resize" data-krajee-grid="kvGridInit_f2e4ba32" data-krajee-ps="ps_w2_container">
                                    <div id="w2-container" class="kv-grid-container">
                                        <?= GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'showPageSummary' => false,
                                            'summary' => '',
                                            'columns' => [
                                                [
                                                    'header' => Html::tag('i', null, ['class' => 'fa fa-sort-numeric-asc']),
                                                    'format' => 'raw',
                                                    'class' => '\kartik\grid\SerialColumn',
                                                    'width' => '40px',
                                                ],
                                                [
                                                    'label' => 'จังหวัด',
                                                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                                                    'value' =>  function ($model) {
                                                        return $model->provinceth;
                                                    },
                                                ],
                                                [
                                                    'label' => 'คำสั่งซื้อทั้งหมด',
                                                    'format' => 'raw',
                                                    'encodeLabel' => false,
                                                    'width' => '140px',
                                                    'format' => ['decimal', 0],
                                                    'value' =>  function ($model) {
                                                        return $model->orders;
                                                    },
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'vAlign' => GridView::ALIGN_MIDDLE
                                                ],
                                                [
                                                    'label' => 'ยอดขาย',
                                                    'format' => 'raw',
                                                    'encodeLabel' => false,
                                                    'width' => '140px',
                                                    'format' => ['decimal', 2],
                                                    'value' =>  function ($model) {
                                                        return $model->sumtotal;
                                                    },
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'vAlign' => GridView::ALIGN_MIDDLE
                                                ],
                                                [
                                                    'class' => 'kartik\grid\ExpandRowColumn',
                                                    'width' => '50px',
                                                    'value' => function ($model) {
                                                        return GridView::ROW_COLLAPSED;
                                                    },
                                                    // uncomment below and comment detail if you need to render via ajax
                                                    // 'detailUrl'=>Url::to(['/site/book-details']),
                                                    'detail' => function ($model) {
                                                        return $model->sync_billing_address_postcode;
                                                    },
                                                    'expandIcon' => Html::tag('i', null, ['class' => 'fa fa-angle-double-left']),
                                                    'collapseIcon' => Html::tag('i', null, ['class' => 'fa fa-angle-double-up']),
                                                ],
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   