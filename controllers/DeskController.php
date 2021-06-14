<?php

namespace app\controllers;

use app\models\Task;
use app\models\TaskForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DeskController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function($rule, $action)
                {
                    throw new NotFoundHttpException('Page not found.');
                },
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function($rule, $action)
                        {
                            return !Yii::$app->user->isGuest;
                        }
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Task::find()->with('status')->with('author')->with('assignee');
        $pages = new Pagination(['totalCount' => $query->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', compact('models', 'pages'));
    }

    public function actionCreate()
    {
        $model = new TaskForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $task = new Task();

            $task->title = $model->title;
            $task->description = $model->description;
            $task->created = date('Y-m-d H:i:s');
            $task->deadline = $model->deadline;
            $task->author_id = Yii::$app->user->id;
            $task->assignee_id = $model->assignee;
            $task->status_id = $model->status;

            if($task->save()){
                Yii::$app->session->setFlash('success', 'Task created');
                return $this->redirect('/desk');
            }
            Yii::$app->session->setFlash('error', 'Error');
        }

        return $this->render('create', compact('model'));
    }

    public function actionDetail($id)
    {

    }
}