<?php

namespace common\components;
 
use Yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\helpers\Json;
use common\modules\sys_account_manager\models\AccessControl;
use app\models\Account;

class Constant extends Component
{
    public function setConstantsId()
    {
        $array_rol_menu = [];
        $id = \Yii::$app->user->identity->getId();
        try {
            $sql = "SELECT (CASE 
                                WHEN r.id = 3 
                                    THEN coalesce(c.name, 'Sin Nombre')
                                ELSE 
                                    u.username
                            END) as name_identity,
                    (CASE
                       WHEN a.profile::text <> '{}'::text
                            THEN ((a.profile->>'first_name') || ' ' || (a.profile->>'first_surname'))
                       ELSE u.username    
                    END) as name_profile,     
                    a.id,  
                    coalesce(c.id::text, 'Empty') as company_id,
                    coalesce(r.id::text, 'Empty') as rol,
                    coalesce(r.name, 'Empty') as rol_name
                    FROM account a
                    LEFT JOIN company c ON c.id = a.company_id
                    INNER JOIN rol r ON r.id = a.rol_id
                    INNER JOIN ".'"user"'. "u ON u.id = a.user_id
                    WHERE u.id = $id;";
            $model = Account::findBySql($sql)->one();
            if($model != NULL)
            {
                if($model->rol == 'Empty'){$rol = 'general';}else{$rol = $model->rol;}
                $menu = Yii::$app->json_manager->getMenuJsonByRol($rol);
                $avatar = $model->getAvatar($model->id);
                Yii::$app->session->set('user.name_identity',$model->name_identity);
                Yii::$app->session->set('user.name_profile',$model->name_profile);
                Yii::$app->session->set('user.rol_name',$model->rol_name);
                Yii::$app->session->set('user.company_id',$model->company_id);
                Yii::$app->session->set('user.avatar',$avatar);
                Yii::$app->session->set('user.menu',$menu);
                return true;
            }else{return false;}
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
