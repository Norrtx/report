<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zipcode".
 *
 * @property int $id
 * @property int|null $zipcode_id
 * @property string|null $district_code
 * @property string|null $province_id
 * @property string|null $amphur_id
 * @property string|null $district_id
 * @property string|null $zipcode
 */
class Zipcode extends \yii\db\ActiveRecord
{   
    public  function getThaiProvince(){
        return $this->hasOne(ThaiProvince::className(), ['id' => 'province_id']);
    }  
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zipcode';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zipcode_id'], 'integer'],
            [['district_code', 'province_id', 'amphur_id', 'district_id'], 'string', 'max' => 100],
            [['zipcode'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zipcode_id' => 'Zipcode ID',
            'district_code' => 'District Code',
            'province_id' => 'Province ID',
            'amphur_id' => 'Amphur ID',
            'district_id' => 'District ID',
            'zipcode' => 'Zipcode',
        ];
    }
}
