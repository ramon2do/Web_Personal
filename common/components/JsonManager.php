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
    
    public function getJsonProfile($post=NULL) 
    {
        $this->data = $array = $this->genJsonProfile();
        if(!is_null($post) && count($post) > 0)
        {
            $array_values = [];
            foreach ($post as $key => $value) 
            {
                $array_values[$key] = $value;
                
            }
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
    
    public function getJsonContact($post=NULL) 
    {
        $this->data = $array = $this->genJsonContact();
        if(!is_null($post) && count($post) > 0)
        {
            $array_values = [];
            foreach ($post as $key => $value) 
            {
                $array_values[$key] = $value;
                
            }
            $this->data = $this->setValueInArray($array, $array_values);
        }
        return $this->getJsonValue();
    }
    
    

}
