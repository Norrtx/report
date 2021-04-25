<?php

namespace frontend\modules\report\controllers;

use app\models\CustomerAddress;
use app\models\Order;
use app\models\OrderDetail;
use app\models\ThaiAmphur;
use app\models\ThaiProvince;
use app\models\Zipcode;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;

/**
 * Sales controller for the `report` module
 */
class SalesController extends Controller
{
    /**
     * Renders the order-by-Province view for the module
     * @return string
     */
    
    public function actionOrderByProvince()
    {          
        $datetimestart = Yii::$app->request->get('datetime_start');##GET datetimestart##
        $datetimeend = Yii::$app->request->get('datetime_end');##GET datetimeend##
        $datestart =strtotime(date('d-m-Y H:i',strtotime($datetimestart)));
        $dateend =strtotime(date('d-m-Y H:i',strtotime($datetimeend))); 
        $customer = CustomerAddress::find();  
        $orderdetail = OrderDetail::find();
        $thaiprovince = ThaiProvince::find();
        $zipcode = Zipcode::find();
        $zipcode->alias('z');## orderdetail ##    
        $orderdetail = OrderDetail::find();
        $orderdetail->alias('orderdetail');## orderdetail ##      
        $orderProvince = Order::find();
        $orderProvince->select('o.*,z.province_id,t.name_th, t.code, z.amphur_id,orderdetail.product_name' );       
        $orderProvince->alias('o'); ## o=oeder ##
        $orderProvince->innerJoin(['z' => $zipcode->groupBy('z.zipcode')], 'z.zipcode = o.sync_shipping_address_postcode');
        $orderProvince->innerJoin(['t' => $thaiprovince], 't.id = z.province_id');
        $orderProvince->rightJoin(['orderdetail' => $orderdetail], 'orderdetail.order_id = o.id');
        $orderProvince->where(['not', ['o.sync_shipping_address_postcode' => null]]);        
     
        $orderModelProvince = Order::find();
        $orderModelProvince->select('o.*, z.province_id,t.name_th, t.code, z.amphur_id,orderdetail.product_name');       
        $orderModelProvince->alias('o');## o=oeder ##
        $orderModelProvince->innerJoin(['c'=>$customer],'c.id = o.customer_address_id');
        $orderModelProvince->innerJoin(['z' => $zipcode->groupBy('z.zipcode')],'z.zipcode = c.zipcode');        
        $orderModelProvince->innerJoin(['t' => $thaiprovince], 't.id = z.province_id');
        $orderModelProvince->rightJoin(['orderdetail' => $orderdetail], 'orderdetail.order_id = o.id');
        $orderModelProvince->where(['o.sync_shipping_address_postcode' => null]);
        $orderModelProvince->andWhere(['not',['o.customer_address_id'=> null]]);      
                
        $order = Order::find()->where(['between','dt_created',$datestart,$dateend]);    
        $order->from(['o'=>$orderProvince->union($orderModelProvince)]);             
        $order->select('o.*, sum(o.total) as sumtotal, COUNT(DISTINCT(o.id)) as orders, o.province_id as provinceid, o.name_th as provinceth, o.code as proviceCode,o.product_name as ordername');    
        $orderModel = $order->groupBy('provinceid');         
        $orderModel = $order->orderBy(['sumtotal'=>SORT_DESC]);
        $SumtotalProvince= Order::find()->where(['between','dt_created',$datestart,$dateend]);    
        $SumtotalProvince->from(['o'=>$orderProvince->union($orderModelProvince)]);             
        $SumtotalProvince->select('o.*, sum(o.total) as sumtotal1, COUNT(DISTINCT(o.id)) as orders, o.province_id as provinceid1, o.name_th as provinceth, o.code as proviceCode,o.product_name as ordername')->limit(5)->offset(0)->all();
        $SumtotalProvince->groupBy('provinceid1');         
        $SumtotalProvince->orderBy(['sumtotal1'=>SORT_DESC]);

        $payment = Order::find()->where(['between','orderpayment.dt_created',$datestart,$dateend]);
        $payment->alias('orderpayment');## oeder ##
        $payment->select(['orderpayment.*,COUNT(orderpayment.id) as count_payment, if(orderpayment.sync_cod = 1, "COD", "Transfer") as paymentname, ifnull(orderpayment.sync_cod,0) as synccod']); 
        $payment->groupBy(['synccod']);      
        $payment->orderBy(['count_payment'=>SORT_DESC]);
        $dataPayment = new ActiveDataProvider([
            'query' => $payment,
            'pagination' => false,
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $orderModel,
            'pagination' => false,
            'key' => 'provinceid',
        ]);
        $Provider = new ActiveDataProvider([
            'query' => $SumtotalProvince,
            'pagination' => false,
        ]);
        return $this->render('order/order-by-province',[
            'dataProvider' => $dataProvider,
            'Provider' => $Provider,
            'dataPayment' => $dataPayment,
        ]); 
    }
    public function actionRemember()
    {
        return $this->render('remember');
    }
    public function actionAjaxOrderByProvince()
    {   
        $provinceIdTEST = null ;
        if (isset($_POST['expandRowKey'])){
            $provinceIdTEST = $_POST['expandRowKey'];
        }
        $datetimestart = Yii::$app->request->get('datetime_start');##GET datetimestart##
        $datetimeend = Yii::$app->request->get('datetime_end');##GET datetimeend##
        $datestart =strtotime(date('d-m-Y H:i',strtotime($datetimestart)));
        $dateend =strtotime(date('d-m-Y H:i',strtotime($datetimeend))); 
        $customer = CustomerAddress::find();  
        $orderdetailAmphur = OrderDetail::find();
        $thaiamphur = ThaiAmphur::find();
        $zipcode = Zipcode::find();
        $zipcode ->alias('z'); ## z=zipcode ##
        $orderAmphur = Order::find();
        $orderAmphur->select('o.*,z.province_id,t.name, t.code, z.amphur_id, orderdetailAmphur.product_name' );       
        $orderAmphur->alias('o'); ## o=oeder ##
        $orderAmphur->innerJoin(['z' => $zipcode->groupBy('z.zipcode')], 'z.zipcode = o.sync_shipping_address_postcode');
        $orderAmphur->innerJoin(['t' => $thaiamphur], 't.id = z.amphur_id');
        $orderAmphur->rightJoin(['orderdetailAmphur' => $orderdetailAmphur], 'orderdetailAmphur.order_id = o.id');       
        $orderAmphur->where(['not', ['o.sync_shipping_address_postcode' => null]]);        
     
        $orderModelAmphur = Order::find();
        $orderModelAmphur->select('o.*, z.province_id,t.name, t.code, z.amphur_id, orderdetailAmphur.product_name');       
        $orderModelAmphur->alias('o');## o=oeder ##
        $orderModelAmphur->innerJoin(['c'=>$customer],'c.id = o.customer_address_id');
        $orderModelAmphur->innerJoin(['z' => $zipcode->groupBy('z.zipcode')],'z.zipcode = c.zipcode');        
        $orderModelAmphur->innerJoin(['t' => $thaiamphur], 't.id = z.amphur_id');
        $orderModelAmphur->rightJoin(['orderdetailAmphur' => $orderdetailAmphur], 'orderdetailAmphur.order_id = o.id');  
        $orderModelAmphur->where(['o.sync_shipping_address_postcode' => null]);
        $orderModelAmphur->andWhere(['not',['o.customer_address_id'=>null]]);      
                
        $amphur = Order::find()->where(['between','dt_created',$datestart,$dateend]);    
        $amphur->from(['o'=>$orderAmphur->union($orderModelAmphur)]);             
        $amphur->select('o.*, sum(o.total) as sumtotal, COUNT(DISTINCT(o.id)) as orders,o.province_id as proviceid, o.name as provinceth, o.code as proviceCode, o.product_name as ordername')->limit(5)->offset(0)->all(); 
        $amphur->andWhere(['o.province_id'=>$provinceIdTEST]);  ####ID###   
        $amphurModel = $amphur->groupBy('o.amphur_id');          
        $amphurModel =$amphur->orderBy(['sumtotal'=>SORT_DESC]);
        $order = $amphur->groupBy('o.amphur_id');          
        $order = $amphur->orderBy(['sumtotal'=>SORT_DESC]);

        $orderModelPayment = Order::find();
        $orderModelPayment->select('o.*,z.province_id,t.name, t.code, z.amphur_id' );       
        $orderModelPayment->alias('o'); ## o=oeder ##
        $orderModelPayment->innerJoin(['z' => $zipcode->groupBy('z.zipcode')], 'z.zipcode = o.sync_shipping_address_postcode');
        $orderModelPayment->innerJoin(['t' => $thaiamphur], 't.id = z.amphur_id');
        $orderModelPayment->rightJoin(['orderdetailAmphur' => $orderdetailAmphur], 'orderdetailAmphur.order_id = o.id');       
        $orderModelPayment->where(['not', ['o.sync_shipping_address_postcode' => null]]);        
     
        $orderPayment = Order::find();
        $orderPayment->select('o.*, z.province_id,t.name, t.code, z.amphur_id');       
        $orderPayment->alias('o');## o=oeder ##
        $orderPayment->innerJoin(['c'=>$customer],'c.id = o.customer_address_id');
        $orderPayment->innerJoin(['z' => $zipcode->groupBy('z.zipcode')],'z.zipcode = c.zipcode');        
        $orderPayment->innerJoin(['t' => $thaiamphur], 't.id = z.amphur_id');
        $orderPayment->rightJoin(['orderdetailAmphur' => $orderdetailAmphur], 'orderdetailAmphur.order_id = o.id');  
        $orderPayment->where(['o.sync_shipping_address_postcode' => null]);
        $orderPayment->andWhere(['not',['o.customer_address_id'=>null]]);      
   
        $payment = Order::find()->where(['between','dt_created',$datestart,$dateend]);    
        $payment->from(['o'=>$orderModelPayment->union($orderPayment)]);             
        $payment->select(['o.*,COUNT(DISTINCT(o.id)) as count_payment,o.province_id as proviceid , if(o.sync_cod = 1, "COD", "Transfer") as paymentname,  ifnull(o.sync_cod,0) as synccod']); 
        $payment->andWhere(['o.province_id'=>$provinceIdTEST]);#####ID#####
        $payment->groupBy(['synccod']);  
        $payment->orderBy(['count_payment'=>SORT_DESC]);
        $dataPayment = new ActiveDataProvider([
            'query' => $payment,
            'pagination' => false,
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $amphurModel,
            'pagination' => false,
        ]);
        $Provider = new ActiveDataProvider([
            'query' => $order,
            'pagination' => false,
        ]);
        return $this->renderAjax('order/ajax-order-by-province',[
            'dataProvider2' => $dataProvider,
            'Provider' => $Provider,
            'dataPayment' => $dataPayment,
            'provinceid'=> $provinceIdTEST,
        ]); 
    }
}
