<?php

namespace common\components;
 
use Yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\helpers\Json;

class JsonManager extends Component
{

    private $data;
    
    public function getJsonValue() 
    {
        $count = count($this->data);
        $array_json = [];
        if($count > 0) 
        {
            foreach ($this->data as $key => $value) 
            {
                $label = strtolower($key);
                $array_json[$label] = $value;
            }
        }
        return Json::encode($array_json);
    }
    
    public function setJsonValue($post) 
    {
        if(!is_null($post) && count($post) > 0)
        {
            foreach ($post as $key => $value) 
            {
                $this->data[$key] = $value;
            }
        }
    }
    
    public function getJsonArrayValue($json_parameter,$array_parameter) 
    {
        if($json_parameter != NULL || $json_parameter != '')
        {
            $json = Json::decode($json_parameter);
            if($json)
            {
                $array = [];
                foreach ($array_parameter as $key => $value) 
                {
                    if($json[$value] != ''){
                        $array[] = $json[$value];
                    }
                }
                return implode(' ', $array);
            }else{return '';}
        }else{return '';}
    }
    
    public function setValueInArray($array_base, $array_values) 
    {
        if(is_array($array_base) && is_array($array_values)){return array_replace_recursive($array_base,$array_values);}
        else
        {
            if(!is_array($array_base) && !is_array($array_values)){return 'Ambos parametros deben ser array.';}
            else{
                if(!is_array($array_base) || !is_array($array_values))
                {
                    if(!is_array($array_base)){return 'El primer parametro no es un array.';}
                    elseif(!is_array($array_values)){return 'El segundo parametro no es un array.';}
                }
            }
        }
    }
    
    public function setLowerKeyArray($array) 
    {
        return array_change_key_case($array, CASE_LOWER);
    }
    
    public function genJsonProfile() 
    {
        $array = [
            'identification' => '',
            'first_name' => '',
            'second_name' => '',
            'first_surname' => '',
            'second_surname' => '',
            'gender' => '',
            'birth_date' => '',
            'nacionality' => '',
        ];
        return $array;
    }
    
    public function getJsonProfile($post=NULL,$profile_json=NULL) 
    {
        $this->data = $array = $this->genJsonProfile();
        if(!is_null($post) && count($post) > 0)
        {
            $array_values = [];
            foreach ($post as $key => $value) 
            {
                $array_values[$key] = $value;
                
            }
            if($profile_json != NULL){$array = Json::decode($profile_json);}
            $this->data = $this->setValueInArray($array, $array_values);
        }
        return $this->getJsonValue();
    }
    
    public function genJsonContact() 
    {
        $array = [
            'personal_address' => '',
            'personal_phone' => '',
            'personal_email' => '',
        ];
        return $array;
    }
    
    public function getJsonContact($post=NULL,$contact_json=NULL) 
    {
        $this->data = $array = $this->genJsonContact();
        if(!is_null($post) && count($post) > 0)
        {
            $array_values = [];
            foreach ($post as $key => $value) 
            {
                $array_values[$key] = $value;
                
            }
            if($contact_json != NULL){$array = Json::decode($contact_json);}
            $this->data = $this->setValueInArray($array, $array_values);
        }
        return $this->getJsonValue();
    }
    
    public function genJsonContactCorporative() 
    {
        $array = [
            'corporate_address' => '',
            'coordinates' => '',
            'corporate_phone' => '',
            'corporate_mobile_phone' => '',
            'corporate_email' => '',
        ];
        return $array;
    }
    
    public function getJsonContactCorporative($post=NULL,$contact_json=NULL) 
    {
        $this->data = $array = $this->genJsonContactCorporative();
        if(!is_null($post) && count($post) > 0)
        {
            $array_values = [];
            foreach ($post as $key => $value) 
            {
                $array_values[$key] = $value;
                
            }
            if($contact_json != NULL){$array = Json::decode($contact_json);}
            $this->data = $this->setValueInArray($array, $array_values);
        }
        return $this->getJsonValue();
    }
    
    public function genMenu() 
    {
        $arrayMenu = [];
        $arrayMenu[1] = [
            ['label' => '<i class="fa fa-home"></i> Inicio', 'url' => ['/'], 'options' => ['class'=>'']],
            ['label' => '<i class="fa fa-fw fa-building"></i> Compañias', 'url' => ['/company/'], 'options' => ['class'=>'treeview']],
            ['label' => '<i class="fa fa-book"></i> Inventarios', 'url' => ['/item/'], 'options' => ['class'=>'treeview']],
            ['label' => '<i class="fa fa-users"></i> Cuentas', 'url' => ['/account/'], 'options' => ['class'=>'treeview']],
        ];
        $arrayMenu[2] = [
            ['label' => '<i class="fa fa-home"></i> Inicio', 'url' => ['/site/'], 'options' => ['class'=>'']],
            ['label' => '<i class="fa fa-home"></i> Compañias', 'url' => ['/'], 'options' => ['class'=>'']],
            ['label' => '<i class="fa fa-home"></i> Productos/Servicios', 'url' => ['/'], 'options' => ['class'=>'']],
        ];
        $arrayMenu[3] = [
            ['label' => '<i class="fa fa-home"></i> Inicio', 'url' => ['/inventory/list'], 'options' => ['class'=>'']],
            ['label' => '<i class="fa fa-fw fa-building""></i> Mi Compañia', 'url' => ['/company/'.Yii::$app->session->get('user.company_id')], 'options' => ['class'=>'treeview']],
            ['label' => '<i class="fa fa-book"></i> Mi Inventario', 'url' => ['/item/list'], 'options' => ['class'=>'treeview']],
        ];
        return $arrayMenu;
    }


    public function getMenuJsonByRol($rol) 
    {
        $arrayMenu = $this->genMenu();
        return $arrayMenu[$rol];
    }

}
