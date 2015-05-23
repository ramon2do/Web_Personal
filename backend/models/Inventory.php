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
 * @property string $description
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
            [['description'], 'string'],
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
            'item_id' => 'Articulo',
            'price' => 'Precio (Bs.)',
            'quantity' => 'Cantidad',
            'description' => 'Descripción',
            'start_date' => 'Inicio',
            'end_date' => 'Final',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
    
    public function getArrayInventory($post,$itemId) 
    {
        $array = [];
        $array['Inventory']['price'] = $post['Inventory']['price'];
        $array['Inventory']['quantity'] = $post['Inventory']['quantity'];
        $array['Inventory']['start_date'] = date('Y-m-d H:i:s');
        $array['Inventory']['item_id'] = $itemId;
        return $array;
    }
}
