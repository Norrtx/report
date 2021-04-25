<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "thai_amphur".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $name_en
 * @property int $geo_id
 * @property int $province_id
 */
class ThaiAmphur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'thai_amphur';
    }

    /**
     * {@inheritdoc}
     */
    
    public $subamphur;
    public function rules()
    {
        return [
            [['code', 'name', 'name_en', 'geo_id', 'province_id'], 'required'],
            [['geo_id', 'province_id'], 'integer'],
            [['code'], 'string', 'max' => 4],
            [['name', 'name_en'], 'string', 'max' => 150],
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
            'name' => 'Name',
            'name_en' => 'Name En',
            'geo_id' => 'Geo ID',
            'province_id' => 'Province ID',
        ];
    }
}
