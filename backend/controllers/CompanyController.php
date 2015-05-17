<?php

namespace backend\controllers;

use Yii;
use app\models\Company;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use dektrium\user\traits\AjaxValidationTrait;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
{
    use AjaxValidationTrait;
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Company::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->getRequest()->isAjax)
        {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        }
        else
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();
        $model->code_number = $model->getCompanyCode();
        $this->performAjaxValidation($model);
        
        if(Yii::$app->request->post())
        {
            $post = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();

            $arrayCompany = $model->getArrayCompany($post);
            if ($model->load($arrayCompany) && $model->save()) 
            {
                $transaction->commit();
                \Yii::$app->session->setFlash('success', \Yii::t('user', 'La Compañia ha Sido Guardada.'));
                return $this->redirect(['view', 'id' => $model->id]);
            }else{$transaction->rollBack();}
        }
        
        if(Yii::$app->getRequest()->isAjax)
        {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if(Yii::$app->request->post())
        {
            $post = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();

            $arrayCompany = $model->getArrayCompany($post);
            if ($model->load($arrayCompany) && $model->save()) 
            {
                $transaction->commit();
                \Yii::$app->session->setFlash('success', \Yii::t('user', 'La Compañia ha Sido Actualizada.'));
                return $this->redirect(['view', 'id' => $model->id]);
            }else{$transaction->rollBack();}
        }
        
        if(Yii::$app->getRequest()->isAjax)
        {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
        else
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
