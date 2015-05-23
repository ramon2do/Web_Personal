<?php

namespace backend\controllers;

use Yii;
use app\models\Item;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Inventory;
use app\models\Company;
use app\models\Type;
use app\models\Category;
use app\models\SubCategory;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
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
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Item::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id=NULL)
    {
        $model = new Item;
        $modelInventory = new Inventory;
        $modelCompany = new Company;
        $modelType = new Type;
        $modelCategory = new Category;
        $modelSubCategory = new SubCategory;

        $company = Yii::$app->field_generator->genArrayList($modelCompany,'id','name');
        $type = Yii::$app->field_generator->genArrayList($modelType,'id','name');
        $category = Yii::$app->field_generator->genArrayList($modelCategory,'id','name');
        $subcategory = Yii::$app->field_generator->genArrayList($modelSubCategory,'id','name');
        if($id != NULL){$model->company_id = $id;}

        if(Yii::$app->request->post())
        {
            $post = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            
            $arrayItem = $model->getArrayItem($post,$id);
            if ($model->load($arrayItem) && $model->save()) 
            {
                $arrayInventory = $modelInventory->getArrayInventory($post,$model->id);
                if ($modelInventory->load($arrayInventory) && $modelInventory->save()) 
                {
                    $transaction->commit();
                    $typeName = $modelCategory::find()->where(['id' => $model['subcategory']['category_id']])->one()->type->name;
                    \Yii::$app->session->setFlash('success', \Yii::t('user', 'El '.trim($typeName,'s').' ha Sido Guardado.'));
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{$transaction->rollBack();}
            }else{$transaction->rollBack();}
        }
        
        return $this->render('create', [
            'model' => $model,
            'modelInventory' => $modelInventory,
            'modelType' => $modelType,
            'modelCategory' => $modelCategory,
            'modelSubCategory' => $modelSubCategory,
            'company' => $company,
            'type' => $type,
            'category' => $category,
            'subcategory' => $subcategory,
        ]);
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelInventory = Inventory::find()->where(['item_id' => $model->id, 'end_date' => NULL])->one();
        $modelCompany = new Company;
        
        
        $modelSubCategory = SubCategory::find()->where(['id' => $model['subcategory_id']])->one();
        $modelCategory = Category::find()->where(['id' => $model['subcategory']['category_id']])->one();
        $modelType = $modelCategory->type;

        $company = Yii::$app->field_generator->genArrayList($modelCompany,'id','name');
        $type = Yii::$app->field_generator->genArrayList($modelType,'id','name');
        $category = Yii::$app->field_generator->genArrayList($modelCategory,'id','name',['type_id' => $modelType->id]);
        $subcategory = Yii::$app->field_generator->genArrayList($modelSubCategory,'id','name',['category_id' => $model['subcategory']['category_id']]);

        if(Yii::$app->request->post())
        {
            $post = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            $arrayItem = $model->getArrayItem($post,$model->company_id);
            if ($model->load($arrayItem) && $model->save()) 
            {
                $modelNewInventory = new Inventory;
                $arrayInventory = $modelNewInventory->getArrayInventory($post,$model->id);
                if ($modelNewInventory->load($arrayInventory) && $modelNewInventory->save()) 
                {
                    $modelInventory->end_date = $modelNewInventory->start_date;
                    $modelInventory->save(false);
                    $transaction->commit();
                    $typeName = $modelType->name;
                    \Yii::$app->session->setFlash('success', \Yii::t('user', 'El '.trim($typeName,'s').' ha Sido Actualizado.'));
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{$transaction->rollBack();}
            }else{$transaction->rollBack();}
        }
        
        return $this->render('update', [
            'model' => $model,
            'modelInventory' => $modelInventory,
            'modelType' => $modelType,
            'modelCategory' => $modelCategory,
            'modelSubCategory' => $modelSubCategory,
            'company' => $company,
            'type' => $type,
            'category' => $category,
            'subcategory' => $subcategory,
        ]);
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $deleteInventory = Inventory::deleteAll(['item_id' => $model->id]);
        $deleteItem = $model->delete();
        if($deleteInventory > 0 || $deleteItem){return $this->redirect(['index']);}else{return false;}
    }
    
    public function actionList()
    {
        $id = Yii::$app->session->get('user.company_id');
        $modelProducts = Item::find()
                ->join('INNER JOIN', 'sub_category', 'sub_category.id=item.subcategory_id')
                ->join('INNER JOIN', 'category', 'category.id=sub_category.category_id')
                ->join('INNER JOIN', 'type', 'type.id=category.type_id')
                ->where(['company_id' => $id, 'type.id' => '1'])->all();
        $modelServices = Item::find()
                ->join('INNER JOIN', 'sub_category', 'sub_category.id=item.subcategory_id')
                ->join('INNER JOIN', 'category', 'category.id=sub_category.category_id')
                ->join('INNER JOIN', 'type', 'type.id=category.type_id')
                ->where(['company_id' => $id, 'type.id' => '2'])->all();
        
        return $this->render('_list', [
            'modelProducts' => $modelProducts,
            'modelServices' => $modelServices,
        ]);
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
}
