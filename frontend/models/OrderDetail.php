<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $tenant_product_sku
 * @property string|null $product_name
 * @property int|null $quantity
 * @property float|null $unit_price
 * @property float|null $discount_percent
 * @property float|null $discount_price
 * @property float|null $tax_rate
 * @property int|null $status
 * @property int|null $admin_id
 * @property int|null $tenant_id
 * @property int|null $dt_created
 * @property int|null $dt_updated
 * @property int|null $dt_confirmed
 * @property int|null $order_id
 * @property int|null $order_created
 * @property int|null $shipping_status
 * @property string|null $shipping_date
 * @property string|null $tracking_number
 * @property int|null $shipper_id
 * @property int|null $status_sync
 * @property int|null $sync_order_id
 * @property string|null $sync_order_detail_id
 * @property string|null $sync_product_id
 * @property int|null $packed_by_serial
 * @property int|null $packed
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity', 'status', 'admin_id', 'tenant_id', 'dt_created', 'dt_updated', 'dt_confirmed', 'order_id', 'order_created', 'shipping_status', 'shipper_id', 'status_sync', 'sync_order_id', 'packed_by_serial', 'packed'], 'integer'],
            [['product_name', 'sync_order_detail_id', 'sync_product_id'], 'string'],
            [['unit_price', 'discount_percent', 'discount_price', 'tax_rate'], 'number'],
            [['shipping_date'], 'safe'],
            [['tenant_product_sku', 'tracking_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'tenant_product_sku' => 'Tenant Product Sku',
            'product_name' => 'Product Name',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'discount_percent' => 'Discount Percent',
            'discount_price' => 'Discount Price',
            'tax_rate' => 'Tax Rate',
            'status' => 'Status',
            'admin_id' => 'Admin ID',
            'tenant_id' => 'Tenant ID',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'dt_confirmed' => 'Dt Confirmed',
            'order_id' => 'Order ID',
            'order_created' => 'Order Created',
            'shipping_status' => 'Shipping Status',
            'shipping_date' => 'Shipping Date',
            'tracking_number' => 'Tracking Number',
            'shipper_id' => 'Shipper ID',
            'status_sync' => 'Status Sync',
            'sync_order_id' => 'Sync Order ID',
            'sync_order_detail_id' => 'Sync Order Detail ID',
            'sync_product_id' => 'Sync Product ID',
            'packed_by_serial' => 'Packed By Serial',
            'packed' => 'Packed',
        ];
    }
}
