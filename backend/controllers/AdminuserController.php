<?php

namespace backend\controllers;

use backend\models\SignupForm;
use backend\models\ResetpwdForm;
use common\models\AuthAssignment;
use common\models\AuthItem;
use Yii;
use common\models\Adminuser;
use common\models\AdminuserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminuserController implements the CRUD actions for Adminuser model.
 */
class AdminuserController extends Controller
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
     * Lists all Adminuser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adminuser model.
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
     * Creates a new Adminuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if($user=$model->signup()){
                return $this->redirect(['index']);
            } else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Adminuser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->author_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Adminuser model.
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
     * Finds the Adminuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adminuser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adminuser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    //重置密码
    public function actionResetpwd($id)
    {
        $model = new ResetpwdForm();

        if ($model->load(Yii::$app->request->post())) {
            if($model->resetPassword($id)){
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('resetpwd', [
                'model' => $model,
            ]);
        }
    }
    //权限设置
    public function actionPrivilege($id){

        //1.找出所有权限，提供给checkboxlist
        $allPrivilegesArray=array();
        $allPrivileges = AuthItem::find()->select(['name','description'])
            ->where(['type'=>1])->orderBy('description')->all();
        foreach ($allPrivileges as $pri){
            $allPrivilegesArray[$pri->name]=$pri->description;
        }
        //2.找出当前用户的权限
        $AuthAssignments = AuthAssignment::find()->select(['item_name'])
            ->where(['user_id'=>$id])->all();
        $AuthAssignmentsArray = array();
        foreach ($AuthAssignments as $AuthAssignment){
            array_push($AuthAssignmentsArray , $AuthAssignment->item_name);
        }
        //3.更新AuthAssignment表，更新用户与角色间的关系
        if(isset($_POST['newPir'])){
            AuthAssignment::deleteAll('user_id=:id',[':id'=>$id]);

            $newPri = $_POST['newPir'];
            $arrlength = count($newPri);
            for ($x=0;$x<$arrlength;$x++){
                $aPri = new AuthAssignment();
                $aPri->item_name=$newPri[$x];
                $aPri->user_id=$id;
                $aPri->created_at = time();
                $aPri->save();
            }
            return $this->redirect(['index']);
        }
        //4.渲染多选按钮，让数据能提交过来
        return $this->render('privilege',['id'=>$id,'AuthAssignmentsArray'=>$AuthAssignmentsArray,
            'allPrivilegesArray'=>$allPrivilegesArray]);
    }
}
