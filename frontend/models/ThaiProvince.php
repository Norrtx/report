<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "thai_province".
 *
 * @property int $id
 * @property int|null $code
 * @property string|null $name_th
 * @property string|null $name_en
 * @property int|null $geography_id
 * @property string|null $province_lat
 * @property string|null $province_lon
 */
class ThaiProvince extends \yii\db\ActiveRecord
{   
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'thai_province';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'geography_id'], 'integer'],
            [['name_th', 'name_en', 'province_lat', 'province_lon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name_th' => 'Name Th',
            'name_en' => 'Name En',
            'geography_id' => 'Geography ID',
            'province_lat' => 'Province Lat',
            'province_lon' => 'Province Lon',
        ];
    }
}
