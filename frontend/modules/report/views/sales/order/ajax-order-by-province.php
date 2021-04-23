<?php

use dosamigos\chartjs\ChartJs;
use frontend\assets\AppAsset;
use sjaakp\gcharts\AreaChart;
use sjaakp\gcharts\BarChart;
use sjaakp\gcharts\BubbleChart;
use sjaakp\gcharts\ColumnChart;
use sjaakp\gcharts\GeoChart;
use sjaakp\gcharts\LineChart;
use sjaakp\gcharts\PieChart;
use sjaakp\gcharts\ScatterChart;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

AppAsset::register($this);
$nameAmphur = [];
$totalAmphur=[];
$totalAmphur1=[];
foreach ($dataProvider2->query->all() as $key => $model) {
    if ($key < 5) {
        array_push($nameAmphur,  $model->provinceth);
    }
}
foreach ($dataProvider2->query->all() as $key => $model) {
    if ($key < 5) {
        array_push($totalAmphur, $model->sumtotal);
        // array_push($totalAmphur1,  number_format($model->sumtotal, 2));
    }
}
// print_r($nameAmphur);
// print_r($totalAmphur1);
// print_r($totalAmphur);
// die();
$count = count($totalAmphur);
if ($count < 5) {
    $round = 5 - count($totalAmphur);
    for ($i=0; $i < $round; $i++) { 
        array_push($totalAmphur, 0);
    }
}
$POS_HEAD = <<< JS
JS;
$this->registerJs($POS_HEAD, static::POS_HEAD);
$POS_END = <<< JS
function addLabelToBarChart() {        
        var chartInstance = this.chart
        ctx = chartInstance.ctx;
        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
        ctx.textAlign = 'left';
        ctx.textBaseline = 'middle';

        this.data.datasets.forEach(function(dataset, i) {
            var meta = chartInstance.controller.getDatasetMeta(i);
            meta.data.forEach(function(bar, index) {
                var indentLabel = bar._model.base + 10;
                ctx.fillStyle = '#ffffff';
                if(bar._model.x < (bar._model.base + 100)) {
                    indentLabel = bar._model.x + 10;
                    ctx.fillStyle = '#666666';
                }
                var data = dataset.data[index] > 1 ? (formatNumber(dataset.data[index]) + ' THB') : '';
                ctx.fillText(data, indentLabel, bar._model.y);
            });
        });
    }
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
JS;
$this->registerJs($POS_END, static::POS_END);
?>

<div class="panel">
    <div class="panel-body">
        <div class="col-lg-4 text-center">
            <h3 class=""><i class="fa fa-globe m-r-xs" style="font-size: 14px;"></i>อำเภอที่มีการขายสินค้า</h3>
            <div class="m-b-xs">
                <small class="">ยอดขายแบ่งตามอำเภอ</small>
            </div>
            <div class="card-bodyJS"> 
                <?= ChartJs::widget([
                    'id' => 'ChartJs'.$provinceid,
                    'type' => 'horizontalBar',
                    'options' => [
                        'height' => 240,
                    ],
                    'data' => [
                        'radius' =>  "100%",
                        'labels' =>  $nameAmphur+['ไม่พบข้อมูล','ไม่พบข้อมูล','ไม่พบข้อมูล','ไม่พบข้อมูล','ไม่พบข้อมูล'],   // Your labels
                        // 'labels' => ['1','2','3','4','5','6'],
                        'datasets' => [
                            [   
                                // 'data' => ['1000','100','100','100','100','100'],
                                // 'data' =>$totalAmphur, // Your dataset
                                // 'label' =>$nameAmphur,
                                'backgroundColor' => [
                                    '#1ab394',
                                    '#1ab394',
                                    '#1ab394',
                                    '#1ab394',
                                    '#1ab394',
                                    '#1ab394',
                                    '#1ab394',
                                ],
                                'borderColor' =>  [
                                    '#fff',
                                    '#fff',
                                    '#fff'
                                ],
                                'borderWidth' => 1,
                                'hoverBorderColor' => ["#999", "#999", "#999"],
                                'data' => array_merge(ArrayHelper::getColumn($totalAmphur, function ($totalAmphur) {
                                    return !$totalAmphur ? 1 :number_format($totalAmphur, 2, '.', '');
                                })),
                            ]
                        ]
                    ],
                    'clientOptions' => [
                        'padding' => 20,
                        'responsive' => true,
                        'maintainAspectRatio' => false,
                        'scales' => [
                            'xAxes' => [
                                [
                                    'display' => false,
                                    'gridLines' => [
                                        'gridLineWidth' => 0,
                                        'display' => false,
                                        'drawBorder' => false,
                                        'show' => false
                                    ],
                                    'ticks' => [
                                        'min' => null,
                                        'max' => 100,
                                        'stepSize' => 10
                                    ],
                                ],
                            ],
                            'yAxes' => [
                                [
                                    'gridLines' => [
                                        'gridLineWidth' => 0,
                                        'display' => false,
                                        'drawBorder' => false,
                                        'show' => false
                                    ],
                                    'ticks' => [
                                        'min' => 0,
                                        'max' => 100,
                                        'stepSize' => 10
                                    ],
                                ],
                            ],
                        ],
                        'legend' => [
                            'display' => false,
                        ],
                        'tooltips' => [
                            'enabled' => false,
                            'intersect' => false
                        ],
                        'hover' => [
                            'display' => false,
                        ],
                        'animation' => [
                            'duration' => 0,
                            'onComplete' => new JsExpression('addLabelToBarChart'),
                        ],
                    ],
                ]);
                ?>         
            </div>
        </div>
        <div class="col-lg-4 text-center">
            <h3 class=""><i class="fa fa-cubes m-r-xs" style="font-size: 14px;"></i>ลำดับสินค้าที่ขายดีที่สุด</h3>
            <div class="m-b-xs">
                <small class="">แบ่งตามยอดขาย</small>
            </div>
            <div class="card-body">
                <?= PieChart::widget([
                    'height' => 240,
                    'id' => 'pie1'.$provinceid,
                        'options' => [
                        'height' => 240,
                        'legend'=>[
                        'position'=>'bottom',
                        ],
                        'fontSize'=> 12, 
                        'pieHole'=> 0.4,
                        'chartArea'=>[
                            'left'=> 0,
                            'top'=> 8,
                            'width'=>'100%',
                            'height'=>'90%',
                        ],
                    ],
                    'dataProvider' => $Provider,
                    'columns' => [                                    
                        'ordername:string:' . 'Sale',
                        [
                            'attribute' => 'sumtotal',
                            'formatted' => function ($model) {
                                return $model['sumtotal'] < 0 ? 0 :' Total: '.number_format($model['sumtotal'], 0) . ' THB';
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
                    'id' => 'pie2'.$provinceid,
                    'options' => [
                        'height' => 240,
                        'legend'=>'bottom', 
                        'fontSize'=> 12,
                        'is3D'=>true, 
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