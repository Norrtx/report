<?php
namespace frontend\modules\report\controllers;
use app\models\CustomerAddress;
use app\models\Order;
use app\models\OrderDetail;
use app\models\ThaiProvince;
use app\models\Zipcode;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
/**
 * Default controller for the `report` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
       // return $this->render('..\sales\order\order-by-Province');
    }
    public function actionChart()
    {  
        $thaiprovince1 = ThaiProvince::find();
        $thaiprovince1->alias('t');## t=ThaiProvince ##
        $zipcodeModel1 = Zipcode::find();
        $zipcodeModel1 ->alias('z'); ## z=zipcode ##
        $orderModel1 = Order::find();
        $orderModel1->select('o.*,z.province_id,t.name_th, t.code');       
        $orderModel1->alias('o'); ## o=oeder ##
        $orderModel1->innerJoin(['z' => $zipcodeModel1->groupBy('z.zipcode')], 'z.zipcode = o.sync_shipping_address_postcode');
        $orderModel1->innerJoin(['t' => $thaiprovince1], 't.id = z.province_id');
        // $orderModel1->innerJoin(['od' => $orderdetailModel1], 'od.order_id = o.id');
        $orderModel1->where(['not', ['o.sync_shipping_address_postcode' => null]]);
        
    
        $thaiprovince2 = ThaiProvince::find();
        $thaiprovince2->alias('t');## t=ThaiProvince ##
        $customerModel2 = CustomerAddress::find();  
        $zipcodeModel2 = Zipcode::find();
        $zipcodeModel2 ->alias('z');## z=zipcode ##
        $orderModel2 = Order::find();
        $orderModel2->select('o.*, z.province_id,t.name_th, t.code');       
        $orderModel2->alias('o');## o=oeder ##
        // $orderModel2->innerJoin(['od' => $orderdetailModel2], 'od.order_id = o.id');
        $orderModel2->innerJoin(['c'=>$customerModel2],'c.id = o.customer_address_id');
        $orderModel2->innerJoin(['z' => $zipcodeModel2->groupBy('z.zipcode')],'z.zipcode = c.zipcode');        
        $orderModel2->innerJoin(['t' => $thaiprovince2], 't.id = z.province_id');
        $orderModel2->where(['o.sync_shipping_address_postcode' => null]);
        $orderModel2->andWhere(['not',['o.customer_address_id'=>null]]);      
                
        
        $datetimestart = Yii::$app->request->get('datetime_start');##GET datetimestart##
        $datetimeend = Yii::$app->request->get('datetime_end');##GET datetimeend##
        $datestart =strtotime(date('d-m-Y H:i',strtotime($datetimestart)));
        $dateend =strtotime(date('d-m-Y H:i',strtotime($datetimeend)));      
        $orderModel = Order::find()->where(['between','dt_created',$datestart,$dateend]);    
        $orderModel->from(['o'=>$orderModel1->union($orderModel2)]);             
        $orderModel->select('o.*, sum(o.total) as sumtotal, COUNT(o.id) as orders,o.name_th as provinceth, o.code as proviceCode'); 
        $orderModel->groupBy('o.province_id');      
        $orderModel->orderBy(['sumtotal'=>SORT_DESC]);

        
        $orderdetail = OrderDetail::find();
        $orderdetail->alias('orderdetail');## t=ThaiProvince ## 
        $order = Order::find()->where(['between','order.dt_created',$datestart,$dateend]);
        $order->alias('order');## o=oeder ##
        $order->innerJoin(['orderdetail' => $orderdetail], 'orderdetail.order_id = order.id');        
        $order->select('order.*, sum(order.total) as ordersumtotal, COUNT(order.id) as ordercount, orderdetail.product_name as ordername')->limit(5)->offset(0)->all();  
        $order->groupBy('order.id');      
        $order->orderBy(['ordersumtotal'=>SORT_DESC]);
        $payment = Order::find()->where(['between','orderpayment.dt_created',$datestart,$dateend]);
        $payment->andwhere(['not',['orderpayment.sync_cod'=> null]]);
        $payment->alias('orderpayment');## oeder ##
        $payment->select('orderpayment.*,COUNT(orderpayment.sync_cod) as count_payment, orderpayment.sync_payment_method as paymentname, orderpayment.sync_cod as sync_cod'); 
        $payment->groupBy(['orderpayment.sync_cod']);      
        $payment->orderBy(['count_payment'=>SORT_DESC]);
        $dataPayment = new ActiveDataProvider([
            'query' => $payment,
            'pagination' => false,
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $orderModel,
            'pagination' => false,
        ]);
        $Provider = new ActiveDataProvider([
            'query' => $order,
            'pagination' => false,
        ]);
        
        return $this->render('chart',[
            'dataProvider' => $dataProvider,
            'Provider' => $Provider,
            'dataPayment' => $dataPayment,
        ]); 
    }
    public function actionPie()	{
        
        $datetimestart = Yii::$app->request->get('datetime_start');##GET datetimestart##
        $datetimeend = Yii::$app->request->get('datetime_end');##GET datetimeend##
        $datestart =strtotime(date('d-m-Y H:i',strtotime($datetimestart)));
        $dateend =strtotime(date('d-m-Y H:i',strtotime($datetimeend)));  
        $payment = Order::find()->where(['between','orderpayment.dt_created',$datestart,$dateend]);
        $payment->where(['not',['orderpayment.sync_cod'=> null]]);
        $payment->alias('orderpayment');## oeder ##
        $payment->select('orderpayment.*,COUNT(orderpayment.sync_cod) as count_payment, orderpayment.sync_payment_method as paymentname, orderpayment.sync_cod as sync_cod'); 
        $payment->groupBy(['orderpayment.sync_cod']);      
        $payment->orderBy(['count_payment'=>SORT_DESC]);
        $dataPayment = new ActiveDataProvider([
            'query' => $payment,
            'pagination' => false
        ]);
        
        return $this->render('pie', [
            'dataPayment' => $dataPayment,
        ]);
    }

    public function actionTest() {
        $simple_data = array(
            0 => 'a',
            1 => 'b',
            2 => 'c',
            3 => 'd',
            4 => 'e',
            5 => 'f',
            6 => 'g',
            7 => 'h',
            8 => 'i',
            9 => 'j',
        );
        
        if( isset($_GET['index']) ){
            $index = $_GET['index'];
        }
        else{
            $index = 0;
        }
        if( isset($_GET['requestByAjax']) ){
            echo json_encode( array(
                'data1' => $simple_data[$index]
            ));
        }
        else {
            echo $simple_data[$index];
        }
        // return '1111';
    }
}
