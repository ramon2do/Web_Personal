<?php

namespace app\models;

use Yii;
use yii\helpers\Json;

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
    public $name_profile;
    public $rol;
    public $rol_name;
    public $file;

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
            [['file'], 'file'],
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
            'profile' => 'Perfil',
            'contact' => 'Contacto',
            'company_id' => 'Compañia',
            'user_id' => 'Usuario',
            'rol_id' => 'Rol',
            'create_date' => 'Creación',
            'file' => 'Archivo',
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
    
    public function getArrayAccount($post,$model=NULL)
    {
        $array = [];
        $profile_json = NULL;
        $contact_json = NULL;
        if($model != NULL)
        {
            $profile_json = $model->profile;
            $contact_json = $model->contact;
        }
        $array['Account']['profile'] = Yii::$app->json_manager->getJsonProfile($post['Profile'],$profile_json);
        $array['Account']['contact'] = Yii::$app->json_manager->getJsonContact($post['Contact'],$contact_json);
        if(isset($post['Account']['company_id']) && $post['Account']['company_id'] != ''){
            $array['Account']['company_id'] = $post['Account']['company_id'];
        }
        if(isset($post['Account']['rol_id']) && $post['Account']['rol_id'] != ''){
            $array['Account']['rol_id'] = $post['Account']['rol_id'];
        }
        return $array;
    }
    
    public function getAvatar($id) 
    {
        if(file_exists(\Yii::getAlias('@webroot').'/img/avatar/'.$id.'.png')){return '/img/avatar/'.$id.'.png';}else{return '/img/avatar/avatar-tiny.jpg';}
    }
}
