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
                                WHEN r.name = 'store' 
                                    THEN c.name 
                                ELSE (CASE
                                           WHEN a.profile::text <> '{}'::text
                                                THEN ((a.profile->>'first_name') || ' ' || (a.profile->>'first_surname'))
                                           ELSE u.username    
                                      END) 
                            END) as name_identity
                    FROM account a
                    LEFT JOIN company c ON c.id = a.company_id
                    INNER JOIN rol r ON r.id = a.rol_id
                    INNER JOIN ".'"user"'. "u ON u.id = a.user_id
                    WHERE u.id = $id;";
            $model = Account::findBySql($sql)->one();
            if($model != NULL)
            {
                Yii::$app->session->set('user.name_identity',$model->name_identity);
                return true;
            }else{return false;}
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
