<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory".
 *
 * @property integer $id
 * @property integer $item_id
 * @property double $price
 * @property integer $quantity
 * @property string $start_date
 * @property string $end_date
 *
 * @property Item $item
 */
class Inventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'start_date'], 'required'],
            [['item_id', 'quantity'], 'integer'],
            [['price'], 'number'],
            [['start_date', 'end_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
}
