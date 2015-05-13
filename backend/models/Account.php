<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property integer $id
 * @property string $profile
 * @property string $contact
 * @property integer $company_id
 * @property integer $user_id
 * @property integer $rol_id
 * @property string $create_date
 *
 * @property Company $company
 * @property Rol $rol
 * @property User $user
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $name_identity;
    
    public static function tableName()
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile', 'contact'], 'string'],
            [['company_id', 'user_id', 'rol_id'], 'integer'],
            [['create_date'], 'required'],
            [['create_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile' => 'Profile',
            'contact' => 'Contact',
            'company_id' => 'Company ID',
            'user_id' => 'User ID',
            'rol_id' => 'Rol ID',
            'create_date' => 'Create Date',
        ];
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
    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['id' => 'rol_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getArrayAccount($post)
    {
        $array = [];
        $array['Account']['profile'] = Yii::$app->json_manager->getJsonProfile($post['Profile']);
        $array['Account']['contact'] = Yii::$app->json_manager->getJsonContact($post['Contact']);
        $array['Account']['company_id'] = NULL;
        return $array;
    }
}
