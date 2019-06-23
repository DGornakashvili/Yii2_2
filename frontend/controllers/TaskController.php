<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\base\Exception;
use common\models\User;
use common\models\Tasks;
use yii\web\UploadedFile;
use common\models\Comments;
use yii\filters\AccessControl;
use yii\caching\TagDependency;
use common\models\TaskStatuses;
use frontend\models\filters\TasksFilter;
use frontend\models\forms\AttachmentsForm;

class TaskController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['preview', 'save'],
                'rules' => [
                    [
                        'actions' => ['preview'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['save'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * @return string
     * @throws
     */
    public function actionIndex()
    {
        $searchModel = new TasksFilter();
        $dataProvider = $searchModel->monthFilter(Yii::$app->request->post());
        $tagDep = new TagDependency(['tags' => 'tasksCache']);
        
        Yii::$app->db->cache(function () use ($dataProvider) {
            return $dataProvider->prepare();
        }, 36000, $tagDep);
        
        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }
    
    /**
     * @param $id
     * @return string
     */
    public function actionPreview($id)
    {
        $model = Tasks::findOne($id);
        
        return $this->render(
            'preview',
            [
                'model' => $model,
                'statuses' => TaskStatuses::getStatuses(),
                'users' => User::getUsers(),
                'commentsForm' => new Comments(),
                'attachmentsForm' => new AttachmentsForm(),
                'userId' => Yii::$app->user->id,
            ]
        );
    }
    
    /**
     * @param $id
     */
    public function actionSave($id)
    {
        $model = Tasks::findOne($id);
        
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->save();
        }
        
        $this->redirect(Yii::$app->request->referrer);
    }
    
    /**
     *
     */
    public function actionSaveComment()
    {
        $model = new Comments();
        
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->save();
        }
        
        $this->redirect(Yii::$app->request->referrer);
    }
    
    /**
     * @throws Exception
     */
    public function actionSaveAttachment()
    {
        $model = new AttachmentsForm();
        
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->upload = UploadedFile::getInstance($model, 'upload');
            $model->save();
        }
        
        $this->redirect(Yii::$app->request->referrer);
    }
}