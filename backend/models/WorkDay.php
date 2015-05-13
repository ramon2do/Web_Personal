<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_day".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $sunday
 * @property string $monday
 * @property string $tuesday
 * @property string $wednesday
 * @property string $thursday
 * @property string $friday
 * @property string $saturday
 * @property string $breaktime
 * @property string $start_date
 * @property string $end_date
 *
 * @property Company $company
 */
class WorkDay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_day';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'start_date', 'end_date'], 'required'],
            [['company_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'breaktime'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'sunday' => 'Sunday',
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'breaktime' => 'Breaktime',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
