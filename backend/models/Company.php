<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $contact
 * @property string $create_date
 * @property boolean $active
 * @property string $disabled_date
 *
 * @property Account[] $accounts
 * @property Item[] $items
 * @property WorkDay[] $workDays
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public $code_number;
    
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'create_date'], 'required'],
            [['contact'], 'string'],
            [['create_date', 'disabled_date'], 'safe'],
            [['active'], 'boolean'],
            [['code', 'name'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Código',
            'name' => 'Nombre',
            'contact' => 'Contacto',
            'create_date' => 'Creación',
            'active' => 'Active',
            'disabled_date' => 'Disabled Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkDays()
    {
        return $this->hasMany(WorkDay::className(), ['company_id' => 'id']);
    }
    
    public function getListCompany() 
    {
        $company = self::find()->all();
        $listData = ArrayHelper::map($company,'id','name');
        return $listData;
    }
    
    public function getArrayCompany($post,$model=NULL)
    {
        $array = [];
        $contact_json = NULL;
        if($model != NULL){$contact_json = $model->contact;}
        $array['Company']['code'] = $post['Company']['code'];
        $array['Company']['name'] = $post['Company']['name'];
        $array['Company']['contact'] = Yii::$app->json_manager->getJsonContactCorporative($post['Contact'],$contact_json);
        $array['Company']['create_date'] = date('Y-m-d H:i:s');
        return $array;
    }
    
    public function getCompanyCode() 
    {
        $model = self::findBySql("SELECT coalesce(lpad((substr(code,16)::int +1)::text, 7, '0'), '0000001') as code FROM company ORDER BY code DESC LIMIT 1;")->one();
        if($model != NULL){return $model->code;}else{return '0000001';}
    }
}
