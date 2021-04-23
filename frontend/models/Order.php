<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string|null $order_number
 * @property int|null $tenant_id
 * @property int|null $customer_id
 * @property int|null $customer_address_id
 * @property string|null $bill_name
 * @property string|null $ship_name
 * @property string|null $note
 * @property int|null $dt_created
 * @property int|null $dt_modified
 * @property int|null $dt_process
 * @property int|null $dt_update
 * @property int|null $order_status_id
 * @property float|null $total
 * @property float|null $main_discount
 * @property float|null $sub_total
 * @property string|null $tax_type no_vat, exclude_vat, include_vat
 * @property float|null $vat_amount
 * @property int|null $admin_id
 * @property int|null $channel_id
 * @property string|null $channel_order_id
 * @property string|null $channel_order_number
 * @property int|null $is_preorder
 * @property int|null $is_print
 * @property int|null $is_print_ship_label
 * @property int|null $shipping_price_id
 * @property float|null $shipping_price
 * @property int|null $payment_type_id
 * @property int|null $vat_type_id
 * @property string|null $payment_slip_image
 * @property int|null $payment_date
 * @property int|null $payment_confirm_status
 * @property int|null $payment_confirm_status_for_sync
 * @property int|null $payment_confirm_date
 * @property int|null $cancel_date
 * @property float|null $cod_price
 * @property float|null $cod_price_surcharge
 * @property float|null $cod_receive_price
 * @property int|null $shipper_id
 * @property int|null $store_id
 * @property string|null $channel_account_name
 * @property int|null $tenant_bank_account_id
 * @property int|null $state
 * @property int|null $progress
 * @property int|null $status
 * @property string|null $ip_address
 * @property string|null $sync_detail
 * @property string|null $sync_order_id
 * @property string|null $sync_status
 * @property string|null $sync_customer_telephone
 * @property string|null $sync_customer_email
 * @property string|null $sync_payment_method
 * @property string|null $sync_payment_date
 * @property string|null $sync_billing_address
 * @property string|null $sync_billing_address_postcode
 * @property string|null $sync_shipping_address
 * @property string|null $sync_shipping_address_postcode
 * @property string|null $sync_shipper
 * @property string|null $sync_shipping_type
 * @property int|null $discount_type 1=fix,2=%
 * @property float|null $discount_percent
 * @property float|null $total_confirm
 * @property string|null $sync_discount_detail
 * @property string|null $sync_backup
 * @property string|null $url_key
 * @property int|null $cod_price_id
 * @property int|null $actual_weight
 * @property int|null $seller_weight
 * @property int|null $shipping_cost
 * @property float|null $actual_price
 * @property string|null $sync_tracking
 * @property int|null $sync_tracking_date
 * @property int|null $notification 0=not send sms,1=send sms
 * @property int|null $mark_as_complete 0=no,1=yes
 * @property int|null $is_sendtofulfillment
 * @property string|null $fulfillment_response
 * @property int|null $fulfillment_response_time
 * @property int|null $order_return_type 0=nothing,1=return,2=change
 * @property int|null $cod_approve
 * @property int|null $cod_confirm
 * @property string|null $invoice_number
 * @property int|null $invoice_date
 * @property string|null $sync_response
 * @property int|null $delivery_date
 * @property string|null $bill_tax_number
 * @property string|null $bill_phone
 * @property int|null $sync_cod
 * @property int|null $sync_datepickup
 * @property int|null $lzdop_branch_id
 * @property int|null $stock_method
 * @property int|null $warehouse_id
 * @property string|null $cn_number
 * @property int|null $cn_date
 * @property string|null $shipping_type
 * @property int|null $pack_date
 * @property int|null $rts_date
 * @property int|null $delivered_date
 * @property int|null $lzd_invoice
 * @property int|null $dropoff_seller_rate_id
 * @property int|null $dropoff_actual_rate_id
 * @property int|null $is_new_movement
 * @property int|null $error_time
 * @property string|null $error_message
 */
class Order extends \yii\db\ActiveRecord
{   
    public  function getZipcode(){
        return $this->hasOne(Zipcode::className(), ['zipcode' => 'sync_shipping_address_postcode']);
    }
    public  function getCustomerAddress(){
        return $this->hasOne(CustomerAddress::className(), ['id' => 'customer_address_id']);
    }
    public  function getOrderDetail(){
        return $this->hasOne(OrderDetail::className(), ['order_id' => 'id']);
    }
    /**
     * {@inheritdoc}
     */
    public $proviceidModel;
    public $provinceid;
    public $synccod;
    public $paymentname;
    public $count_payment;
    public $ordername;
    public $ordercount;
    public $ordersumtotal;
    public $proviceCode;
    public $provinceth;
    public $sumtotal;
    public $orders;
    public $sumshipper;
    
    public $ordername1;
    public $sumtotal1;
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tenant_id', 'customer_id', 'customer_address_id', 'dt_created', 'dt_modified', 'dt_process', 'dt_update', 'order_status_id', 'admin_id', 'channel_id', 'is_preorder', 'is_print', 'is_print_ship_label', 'shipping_price_id', 'payment_type_id', 'vat_type_id', 'payment_date', 'payment_confirm_status', 'payment_confirm_status_for_sync', 'payment_confirm_date', 'cancel_date', 'shipper_id', 'store_id', 'tenant_bank_account_id', 'state', 'progress', 'status', 'discount_type', 'cod_price_id', 'actual_weight', 'seller_weight', 'shipping_cost', 'sync_tracking_date', 'notification', 'mark_as_complete', 'is_sendtofulfillment', 'fulfillment_response_time', 'order_return_type', 'cod_approve', 'cod_confirm', 'invoice_date', 'delivery_date', 'sync_cod', 'sync_datepickup', 'lzdop_branch_id', 'stock_method', 'warehouse_id', 'cn_date', 'pack_date', 'rts_date', 'delivered_date', 'lzd_invoice', 'dropoff_seller_rate_id', 'dropoff_actual_rate_id', 'is_new_movement', 'error_time'], 'integer'],
            [['note', 'sync_detail', 'sync_billing_address', 'sync_shipping_address', 'sync_discount_detail', 'sync_backup', 'fulfillment_response', 'sync_response', 'shipping_type'], 'string'],
            [['total', 'main_discount', 'sub_total', 'vat_amount', 'shipping_price', 'cod_price', 'cod_price_surcharge', 'cod_receive_price', 'discount_percent', 'total_confirm', 'actual_price'], 'number'],
            [['order_number', 'bill_name', 'ship_name', 'tax_type', 'channel_order_id', 'channel_order_number', 'payment_slip_image', 'channel_account_name', 'ip_address', 'sync_order_id', 'sync_status', 'sync_customer_telephone', 'sync_customer_email', 'sync_payment_method', 'sync_payment_date', 'sync_billing_address_postcode', 'sync_shipping_address_postcode', 'sync_shipper', 'sync_shipping_type', 'url_key', 'sync_tracking', 'invoice_number', 'bill_tax_number', 'bill_phone', 'error_message'], 'string', 'max' => 255],
            [['cn_number'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_number' => 'Order Number',
            'tenant_id' => 'Tenant ID',
            'customer_id' => 'Customer ID',
            'customer_address_id' => 'Customer Address ID',
            'bill_name' => 'Bill Name',
            'ship_name' => 'Ship Name',
            'note' => 'Note',
            'dt_created' => 'Dt Created',
            'dt_modified' => 'Dt Modified',
            'dt_process' => 'Dt Process',
            'dt_update' => 'Dt Update',
            'order_status_id' => 'Order Status ID',
            'total' => 'Total',
            'main_discount' => 'Main Discount',
            'sub_total' => 'Sub Total',
            'tax_type' => 'Tax Type',
            'vat_amount' => 'Vat Amount',
            'admin_id' => 'Admin ID',
            'channel_id' => 'Channel ID',
            'channel_order_id' => 'Channel Order ID',
            'channel_order_number' => 'Channel Order Number',
            'is_preorder' => 'Is Preorder',
            'is_print' => 'Is Print',
            'is_print_ship_label' => 'Is Print Ship Label',
            'shipping_price_id' => 'Shipping Price ID',
            'shipping_price' => 'Shipping Price',
            'payment_type_id' => 'Payment Type ID',
            'vat_type_id' => 'Vat Type ID',
            'payment_slip_image' => 'Payment Slip Image',
            'payment_date' => 'Payment Date',
            'payment_confirm_status' => 'Payment Confirm Status',
            'payment_confirm_status_for_sync' => 'Payment Confirm Status For Sync',
            'payment_confirm_date' => 'Payment Confirm Date',
            'cancel_date' => 'Cancel Date',
            'cod_price' => 'Cod Price',
            'cod_price_surcharge' => 'Cod Price Surcharge',
            'cod_receive_price' => 'Cod Receive Price',
            'shipper_id' => 'Shipper ID',
            'store_id' => 'Store ID',
            'channel_account_name' => 'Channel Account Name',
            'tenant_bank_account_id' => 'Tenant Bank Account ID',
            'state' => 'State',
            'progress' => 'Progress',
            'status' => 'Status',
            'ip_address' => 'Ip Address',
            'sync_detail' => 'Sync Detail',
            'sync_order_id' => 'Sync Order ID',
            'sync_status' => 'Sync Status',
            'sync_customer_telephone' => 'Sync Customer Telephone',
            'sync_customer_email' => 'Sync Customer Email',
            'sync_payment_method' => 'Sync Payment Method',
            'sync_payment_date' => 'Sync Payment Date',
            'sync_billing_address' => 'Sync Billing Address',
            'sync_billing_address_postcode' => 'Sync Billing Address Postcode',
            'sync_shipping_address' => 'Sync Shipping Address',
            'sync_shipping_address_postcode' => 'Sync Shipping Address Postcode',
            'sync_shipper' => 'Sync Shipper',
            'sync_shipping_type' => 'Sync Shipping Type',
            'discount_type' => 'Discount Type',
            'discount_percent' => 'Discount Percent',
            'total_confirm' => 'Total Confirm',
            'sync_discount_detail' => 'Sync Discount Detail',
            'sync_backup' => 'Sync Backup',
            'url_key' => 'Url Key',
            'cod_price_id' => 'Cod Price ID',
            'actual_weight' => 'Actual Weight',
            'seller_weight' => 'Seller Weight',
            'shipping_cost' => 'Shipping Cost',
            'actual_price' => 'Actual Price',
            'sync_tracking' => 'Sync Tracking',
            'sync_tracking_date' => 'Sync Tracking Date',
            'notification' => 'Notification',
            'mark_as_complete' => 'Mark As Complete',
            'is_sendtofulfillment' => 'Is Sendtofulfillment',
            'fulfillment_response' => 'Fulfillment Response',
            'fulfillment_response_time' => 'Fulfillment Response Time',
            'order_return_type' => 'Order Return Type',
            'cod_approve' => 'Cod Approve',
            'cod_confirm' => 'Cod Confirm',
            'invoice_number' => 'Invoice Number',
            'invoice_date' => 'Invoice Date',
            'sync_response' => 'Sync Response',
            'delivery_date' => 'Delivery Date',
            'bill_tax_number' => 'Bill Tax Number',
            'bill_phone' => 'Bill Phone',
            'sync_cod' => 'Sync Cod',
            'sync_datepickup' => 'Sync Datepickup',
            'lzdop_branch_id' => 'Lzdop Branch ID',
            'stock_method' => 'Stock Method',
            'warehouse_id' => 'Warehouse ID',
            'cn_number' => 'Cn Number',
            'cn_date' => 'Cn Date',
            'shipping_type' => 'Shipping Type',
            'pack_date' => 'Pack Date',
            'rts_date' => 'Rts Date',
            'delivered_date' => 'Delivered Date',
            'lzd_invoice' => 'Lzd Invoice',
            'dropoff_seller_rate_id' => 'Dropoff Seller Rate ID',
            'dropoff_actual_rate_id' => 'Dropoff Actual Rate ID',
            'is_new_movement' => 'Is New Movement',
            'error_time' => 'Error Time',
            'error_message' => 'Error Message',
        ];
    }
}
