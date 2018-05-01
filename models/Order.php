<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $table
 * @property string $description
 * @property string $time
 * @property int $booked
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description'], 'string'],
            [['booked'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'table' => 'Table',
            'description' => 'Description',
            'booked' => 'Booked',
        ];
    }
}
