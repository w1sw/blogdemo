<?php

namespace backend\controllers;

use Yii;
use common\models\AuthItem;
use common\models\AuthAssignment;
use common\models\AuthItemChild;
use common\models\AuthItemChildSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthitemchildController implements the CRUD actions for AuthItemChild model.
 */
class AuthitemchildController extends Controller
{
    public $enableCsrfValidation = false;       //取消csrf验证

    public $parent;


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
     * Lists all AuthItemChild models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new AuthItemChildSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);  //Yii::$app->request->queryParams等同于$_GET

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItemChild model.
     * @param string $parent
     * @param string $child
     * @return mixed
     */
    public function actionView($parent, $child)
    {
        return $this->render('view', [
            'model' => $this->findModel($parent, $child),
        ]);
    }

    /**
     * Creates a new AuthItemChild model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItemChild();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'parent' => $model->parent, 'child' => $model->child]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    //打开绑定角色和权限的关系的界面
    public function actionBind()
    {
        $allRoleArray=array();       //角色数组
        $allPrivilegesArray=array(); //权限数组
        $AuthItemArray=array();      //角色所拥有的权限
//        $parent='';                  //单选按钮

        //1.找出所有角色和角色，提供给checkboxlist

        $allRole = AuthItem::find()->select(['name','description'])
            ->where(['type'=>1])->asArray()->orderBy('description')->all();
        $allPrivileges = AuthItem::find()->select(['name','description'])
            ->where(['type'=>2])->asArray()->orderBy('description')->all();
        foreach ($allRole as $role){
            $allRoleArray[$role['name']]=$role['description'];
        }
        foreach ($allPrivileges as $pri){
            $allPrivilegesArray[$pri['name']]=$pri['description'];
        }
        //2.找出当前用户的权限
        if(isset($_POST['AuthItemChild'])){
            $this->parent=$_POST['AuthItemChild'];
            $AuthItems = AuthItemChild::find()->select(['child'])
                ->where(['parent'=>$this->parent])->all();
            foreach ($AuthItems as $AuthItem){
                array_push($AuthItemArray , $AuthItem->child);
            }
        }
        $model = new AuthItemChild();   //用于显示radioList

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'parent' => $model->parent, 'child' => $model->child]);
//        }
            return $this->render('bind', [
                'model'=>$model,
                'parent'=>$this->parent,
                'allRoleArray' => $allRoleArray,
                'allPrivilegesArray'=>$allPrivilegesArray,
                'AuthItemArray'=>$AuthItemArray,
            ]);

    }
    //绑定操作
    public function actionStarbind(){
        //3.更新Auth_item_child表，更新用户与角色间的关系
        if(isset($_POST['newPir'])){
            $parentArr=$_REQUEST['parent'];
            $parent=$parentArr['parent'];
            AuthItemChild::deleteAll('parent=:parent',[':parent'=>$parent]);
            $newPri = $_POST['newPir'];
            $arrlength = count($newPri);
            for ($x=0;$x<$arrlength;$x++){
                $auth = new AuthItemChild();
                $auth->parent=$parent;
                $auth->child=$newPri[$x];
                $auth->save();
            }
        }
    }
    /**
     * Updates an existing AuthItemChild model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $parent
     * @param string $child
     * @return mixed
     */
    public function actionUpdate($parent, $child)
    {
        $model = $this->findModel($parent, $child);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'parent' => $model->parent, 'child' => $model->child]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AuthItemChild model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $parent
     * @param string $child
     * @return mixed
     */
    public function actionDelete($parent, $child)
    {
        $this->findModel($parent, $child)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItemChild model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $parent
     * @param string $child
     * @return AuthItemChild the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($parent, $child)
    {
        if (($model = AuthItemChild::findOne(['parent' => $parent, 'child' => $child])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
