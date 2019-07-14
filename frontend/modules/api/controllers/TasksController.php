<?php

namespace frontend\modules\api\controllers;

use common\models\User;
use Yii;
use common\models\Tasks;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class TasksController extends ActiveController
{
    public $modelClass = Tasks::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function($username, $password) {
                $user = User::findByUsername($username);

                if ($user->validatePassword($password)) {
                    return $user;
                }

                return false;
            }
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $query = Tasks::find();

        if ($request = Yii::$app->request->queryParams) {
            $query->andFilterWhere($request);
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}