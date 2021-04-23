<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_address".
 *
 * @property int $id
 * @property string|null $address_line1
 * @property string|null $address_line2
 * @property string|null $zipcode
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $city
 * @property string|null $stage
 * @property int|null $address_type
 * @property int|null $country_id
 * @property int|null $customer_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $tenant_id
 * @property int|null $sync_order_id
 * @property int|null $sync_customer_id
 * @property int|null $sync_customer_address_id
 * @property string|null $dcp_address
 * @property string|null $dcp_district
 * @property string|null $dcp_city
 * @property string|null $dcp_province
 *
 * @property Customer $customer
 */
class CustomerAddress extends \yii\db\ActiveRecord
{   
    public  function getZipcode(){
        return $this->hasOne(Zipcode::className(), ['zipcode' => 'zipcode']);
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address_line1', 'address_line2'], 'string'],
            [['address_type', 'country_id', 'customer_id', 'status', 'created_at', 'updated_at', 'tenant_id', 'sync_order_id', 'sync_customer_id', 'sync_customer_address_id'], 'integer'],
            [['zipcode', 'firstname', 'lastname', 'city', 'stage', 'dcp_address', 'dcp_district', 'dcp_city', 'dcp_province'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address_line1' => 'Address Line1',
            'address_line2' => 'Address Line2',
            'zipcode' => 'Zipcode',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'city' => 'City',
            'stage' => 'Stage',
            'address_type' => 'Address Type',
            'country_id' => 'Country ID',
            'customer_id' => 'Customer ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'tenant_id' => 'Tenant ID',
            'sync_order_id' => 'Sync Order ID',
            'sync_customer_id' => 'Sync Customer ID',
            'sync_customer_address_id' => 'Sync Customer Address ID',
            'dcp_address' => 'Dcp Address',
            'dcp_district' => 'Dcp District',
            'dcp_city' => 'Dcp City',
            'dcp_province' => 'Dcp Province',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
