<?php

namespace common\components;
 
use Yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;

class FieldGenerator extends Component
{
  public function genStaticInput($model,$array,$modelGeneric=NULL,$valuePath=NULL) 
  {
    $content = $optionsInput = NULL;
    foreach ($array as $key => $attribute) 
    {
        $content = NULL;
        foreach ($array as $key => $attribute) 
        {
          $optionsInput = NULL;  
          $arrayValues = NULL;  
          $setValue = NULL;
          $required = NULL;
          if(is_null($modelGeneric)){$modelGeneric=get_class($model);}
          $input = $this->genStaticField($attribute,$modelGeneric);
          if(!$model->isNewRecord){$setValue = $this->getValuesInModel($model,$modelGeneric,$attribute,$valuePath);}
          foreach ($input as $keyOption => $option) {
              if($keyOption == 'type'){$type = $option;}
              elseif($keyOption == 'values'){$arrayValues = $option;}
              elseif($keyOption == 'required'){$required = $option;}
              else{$optionsInput .= ' '.$keyOption.'="'.$option.'"';}
              // More Exceptions of Attributes ...
          }
          $content .= '<div class=" '.strtolower($modelGeneric).'-'.str_replace('_', '-', $attribute).' '.$required.'">'; 
              $content .= '<label class="control-label" for="'.strtolower($modelGeneric).'-'.$attribute.'" translate>'.$this->genNameLabel($attribute).'</label>';
              $content .= $this->constructStaticInput($modelGeneric,$type,$attribute,$optionsInput,$arrayValues,$setValue);
              $content .= '<div class="help-block"></div>';
          $content .= '</div>';
        }
        return $content;
    }
    return $content;
  }
  
  public function getValuesInModel($model,$modelGeneric,$attribute,$valuePath=NULL) 
  {
      if(get_class($model) != $modelGeneric)
      {
          if($valuePath == NULL)
          {
              $field = strtolower($modelGeneric);
              if(isset($model->$field))
              {
                  $json = Json::decode($model->$field);
                  return $json[$attribute];
              }else{return '';}
          }
          elseif($valuePath == 'valueOfSameModel')
          {
              if(isset($model->$attribute)){return $model->$attribute;}else{return '';}
          }
          else{return '';}
      }else{return '';}
  }
  
  public function genDynamicList($modelGeneric,$attribute,$optionsSelect,$arrayValues,$setValue) 
  {
        $select = '';
        $select .= '<select id="'.strtolower($modelGeneric).'-'.$attribute.'" '.$optionsSelect.' name="'.$modelGeneric.'['.$attribute.']" class="form-control select2me">';
        $select .= '<option value="">-- Seleccionar '.$this->genNameLabel($attribute).' --</option>';
        if($arrayValues != NULL){
            foreach ($arrayValues as $key => $value) {
                $selected = '';
                if($value != NULL && $value != ''){
                    if($key == $setValue){$selected = 'selected';}
                    $select .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                }
            }
            $select .= '</select>';
            return $select;
        }
  } 
    
  public function constructStaticInput($modelGeneric,$type,$attribute,$optionsInput,$arrayValues=NULL,$setValue=NULL) 
  {
        $input = '';
        switch ($type) 
        {
          case 'text':
            $input .= '<input type="text" id="'.strtolower($modelGeneric).'-'.$attribute.'" '.$optionsInput.' name="'.$modelGeneric.'['.$attribute.']" value="'.$setValue.'">';
          break;
          case 'email':
            $input .= '<input type="email" id="'.strtolower($modelGeneric).'-'.$attribute.'" '.$optionsInput.' name="'.$modelGeneric.'['.$attribute.']" value="'.$setValue.'">';
          break;
          case 'number':
            $input .= '<input type="text" id="'.strtolower($modelGeneric).'-'.$attribute.'" '.$optionsInput.' name="'.$modelGeneric.'['.$attribute.']" value="'.$setValue.'">';
          break;
          case 'phone':
            $input .= '<input type="text" id="'.strtolower($modelGeneric).'-'.$attribute.'" '.$optionsInput.' name="'.$modelGeneric.'['.$attribute.']" value="'.$setValue.'">';
          break;
          case 'date':
              $input .= DatePicker::widget([
                            'name' => $modelGeneric.'['.$attribute.']',
                            'id' => strtolower($modelGeneric).'-'.$attribute,
                            'value' => $setValue,
                            'dateFormat' => 'dd-MM-yyyy',
                            'language' => 'es',
                            'options' => [
                                'class' => 'form-control',
                                'readonly' => 'readonly',
                            ],
                            'clientOptions' => [
//                                'autoclose' => true,
                                'format' => 'dd, MM yyyy',
                            ],
                        ]);
//            $input .= '<input type="text" id="'.strtolower($modelGeneric).'-'.$attribute.'" '.$optionsInput.' name="'.$modelGeneric.'['.$attribute.']" value="'.$setValue.'">';
          break;
          case 'textarea':
            $input .= '<textarea id="'.strtolower($modelGeneric).'-'.$attribute.'" '.$optionsInput.' name="'.$modelGeneric.'['.$attribute.']">'.$setValue.'</textarea>';
          break;
          case 'list':
            $input .= $this->genDynamicList($modelGeneric,$attribute,$optionsInput,$arrayValues,$setValue);
          break;
          //Default Input Text
          default:
            $input .= '<input type="text" id="'.strtolower($modelGeneric).'-'.$attribute.'" '.$optionsInput.' name="'.$modelGeneric.'['.$attribute.']" value="'.$setValue.'">';
          break;
        }
        return $input;
  }
    
  public function genStaticField($attribute) 
  {
        $field_list_values = ['text'=>'Campo Texto','number'=>'Campo Numerico','phone'=>'Campo Telefónico','email'=>'Campo Email','date'=>'Campo Fecha','ip'=>'Campo IP','textarea'=>'Area de Texto','list'=>'Lista Desplegable'];
        $field_list_nationality = ['Venezolano','Estadounidese','Argentina','Peruana','Colombiana','Cubana','Mexicana','Canadiense','Española','Italiana','Francesa','Alemana','Portuguesa','Brasilera','Chileno','Austriaco'];
        $field_list_gender = ['Female' => 'Femenino', 'Male' => 'Masculino'];
        $field_list_company_sector = ['pubc' => 'Público', 'prvd' => 'Privado'];
        $field_list_company_activity = ['inds' => 'Industrial', 'comr' => 'Comercial', 'sevc' => 'De Servicios'];
        $field_list_company_geoambit = ['locl' => 'Local', 'nacl' => 'Nacional', 'comu' => 'Comunitario', 'muln' => 'Multinacional'];
        $fields = [
            'identification' => ['type'=>'text', 'class'=>'form-control', 'required'=>'required'],
            'first_name' => ['type'=>'text', 'class'=>'form-control only-string'],
            'second_name' => ['type'=>'text', 'class'=>'form-control only-string'],
            'first_surname' => ['type'=>'text', 'class'=>'form-control only-string'],
            'second_surname' => ['type'=>'text', 'class'=>'form-control only-string'],
            'gender' => ['type'=>'list', 'class'=>'form-control', 'values'=>$field_list_gender],
            'birth_date' => ['type'=>'date', 'class'=>'form-control form-control-inline input-medium date-picker'],
            'nacionality' => ['type'=>'list', 'class'=>'form-control', 'values'=>$field_list_nationality],
            'corporate_address' => ['type'=>'textarea', 'rows'=>'4', 'cols'=>'50', 'class'=>'form-control'],
            'personal_address' => ['type'=>'textarea', 'rows'=>'4', 'cols'=>'50', 'class'=>'form-control'],
            'corporate_skype' => ['type'=>'text', 'class'=>'form-control'],
            'corporate_phone' => ['type'=>'number', 'class'=>'form-control telephone'],
            'corporate_mobile_phone' => ['type'=>'number', 'class'=>'form-control phone'],
            'corporate_email' => ['type'=>'email', 'class'=>'form-control'],
            'personal_address' => ['type'=>'textarea', 'rows'=>'4', 'cols'=>'50', 'class'=>'form-control'],
            'personal_skype' => ['type'=>'text', 'class'=>'form-control'],
            'personal_phone' => ['type'=>'phone', 'class'=>'form-control telephone'],
            'personal_mobile_phone' => ['type'=>'number', 'class'=>'form-control phone'],
            'personal_email' => ['type'=>'email', 'class'=>'form-control'],
            'contact_person' => ['type'=>'text', 'class'=>'form-control'],
            'contact_method' => ['type'=>'list', 'class'=>'form-control', 'values'=>['Teléfono','Correo Electrónico','']],
            'contact_device' => ['type'=>'text', 'class'=>'form-control'],
            'field_name' => ['type'=>'text', 'class'=>'form-control'],
            'field_type' => ['type'=>'list', 'class'=>'form-control', 'values'=>$field_list_values],
            'field_values' => ['type'=>'text', 'class'=>'form-control tags'], 
            'list_sector' => ['type'=>'list', 'class'=>'form-control', 'values'=>$field_list_company_sector],
            'list_activity' => ['type'=>'list', 'class'=>'form-control', 'values'=>$field_list_company_activity],
            'list_geoambit' => ['type'=>'list', 'class'=>'form-control', 'values'=>$field_list_company_geoambit],
        ];
        return $fields[$attribute];
  }

  public function genNameLabel($attribute) 
  {
    $label = [
      'identification' => 'Identificación',
      'first_name' => 'Primer Nombre',
      'second_name' => 'Segundo Nombre',
      'first_surname' => 'Primer Apellido',
      'second_surname' => 'Segundo Apellido',
      'gender' => 'Sexo',
      'birth_date' => 'Fecha de Nacimiento',
      'nacionality' => 'Nacionalidad',
      'corporate_phone' => 'Teléfono Corporativo',
      'corporate_mobile_phone' => 'Teléfono Móvil Corporativo',
      'corporate_skype' => 'Skype Corporativo',
      'corporate_email' => 'Correo Electrónico Corporativo',
      'corporate_address' => 'Dirección Corporativa',
      'personal_phone' => 'Teléfono Personal',
      'personal_mobile_phone' => 'Teléfono Móvil Personal',
      'personal_skype' => 'Skype Personal',
      'personal_email' => 'Correo Electrónico Personal',
      'personal_address' => 'Dirección Personal',
      'contact_person' => 'Nombre de la Persona de Contacto',
      'contact_method' => 'Medio de Comunicación',
      'contact_device' => 'Dispositivo de Origen',
      'field_name' => 'Nombre del Campo',
      'field_type' => 'Tipo de Campo',
      'field_values' => 'Valores',
      'list_sector' => 'Sector',
      'list_activity' => 'Actividad Laboral',
      'list_geoambit' =>  'Ambito Geografico',
    ];
    if(isset($label[$attribute])){return $label[$attribute];}else{return 'Campo sin Nombre';}
  }
  
  public function genArrayList($model,$id,$option,$filter=NULL) 
  {
    if($filter != NULL){$data = $model::find()->where($filter)->all();}else{$data = $model::find()->all();}  
    $listData = ArrayHelper::map($data,$id,$option);
    return $listData;
  }
}