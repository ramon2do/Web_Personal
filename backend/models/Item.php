<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $company_id
 * @property integer $subcategory_id
 * @property string $photo
 * @property boolean $active
 * @property string $disable_date
 * @property string $create_date
 *
 * @property Inventory[] $inventories
 * @property Company $company
 * @property SubCategory $subcategory
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'company_id', 'subcategory_id', 'create_date'], 'required'],
            [['description', 'photo'], 'string'],
            [['company_id', 'subcategory_id'], 'integer'],
            [['active'], 'boolean'],
            [['disable_date', 'create_date'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'description' => 'Descripción',
            'company_id' => 'Compañia',
            'subcategory_id' => 'Subcategoría',
            'photo' => 'Photo',
            'active' => 'Activo',
            'disable_date' => 'Desactivación',
            'create_date' => 'Creación',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventories()
    {
        return $this->hasMany(Inventory::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(SubCategory::className(), ['id' => 'subcategory_id']);
    }
    
    public function getArrayItem($post,$companyId) 
    {
        $array = [];
        $array['Item']['name'] = $post['Item']['name'];
        $array['Item']['description'] = $post['Item']['description'];
        $array['Item']['create_date'] = date('Y-m-d H:i:s');
        if($companyId != NULL){$array['Item']['company_id'] = $companyId;}else{$array['Item']['company_id'] = $post['Item']['company_id'];}
        $array['Item']['subcategory_id'] = $post['Item']['subcategory_id'];
        return $array;
    }
}
