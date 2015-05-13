<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $photo
 * @property integer $company_id
 * @property integer $category_id
 * @property boolean $active
 * @property string $disable_date
 * @property string $create_date
 *
 * @property Inventory[] $inventories
 * @property Category $category
 * @property Company $company
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
            [['name', 'company_id', 'category_id', 'create_date'], 'required'],
            [['description', 'photo'], 'string'],
            [['company_id', 'category_id'], 'integer'],
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
            'name' => 'Name',
            'description' => 'Description',
            'photo' => 'Photo',
            'company_id' => 'Company ID',
            'category_id' => 'Category ID',
            'active' => 'Active',
            'disable_date' => 'Disable Date',
            'create_date' => 'Create Date',
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
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
