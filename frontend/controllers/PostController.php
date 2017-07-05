<?php

namespace frontend\controllers;

use common\models\Comment;
use common\models\Tags;
use common\models\User;
use Yii;
use common\models\Post;
use common\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    public $added=0;   //有评论提交才改成1
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $tags = Tags::findTagWeights();
        $recentComment = Comment::findRecentComments();

        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tags'=>$tags,
            'recentComment'=>$recentComment,
        ]);
    }

    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->post_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->post_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
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
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //文章详细界面
    public function actionDetail($id){
        if(!isset(Yii::$app->user->id)){
            $this->redirect('index.php?r=site/login');
        }
        //1.准备数据模型
        $model = $this->findModel($id);     //文章
        $tags=Tags::findTagWeights();       //标签
        $recentComment=Comment::findRecentComments();  //评论
        $userMe=User::findOne(Yii::$app->user->id);     //获取登陆人
        $commentModel=new Comment();
        $commentModel->email=$userMe->email;
        $commentModel->userid=$userMe->id;

        //2.如果有评论提交
        if($commentModel->load(Yii::$app->request->post())){

            $commentModel->comment_status_id=1;
            $commentModel->post_id=$id;
            if($commentModel->save()){
                $this->added=1;
            }
        }

        //3.渲染视图
        return $this->render('detail',[
            'model'=>$model,
            'tags'=>$tags,
            'recentComment'=>$recentComment,
            'commentModel'=>$commentModel,
            'added'=>$this->added,
        ]);

    }

}
