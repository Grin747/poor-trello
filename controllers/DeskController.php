<?php

namespace app\controllers;

use app\models\Task;
use app\models\TaskForm;
use app\models\TaskSearch;
use Yii;
use yii\base\BaseObject;
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
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', compact('dataProvider', 'searchModel'));
    }

    public function actionCreate()
    {
        $model = new TaskForm();

        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
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

    public function actionView($id)
    {
        $model = Task::findOne($id);
        return $this->render('view', compact('model'));
    }

    public function actionUpdate($id)
    {
        $task = Task::findOne($id);
        if (Yii::$app->user->id != $task->author_id) return $this->redirect('/desk');

        $model = new TaskForm();
        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $task->title = $model->title;
            $task->description = $model->description;
            $task->deadline = $model->deadline;
            $task->assignee_id = $model->assignee;
            $task->status_id = $model->status;

            if($task->save()){
                Yii::$app->session->setFlash('success', 'Task updated');
                return $this->redirect('/desk');
            }
            Yii::$app->session->setFlash('error', 'Error');
        }
        else
        {
            $model->title = $task->title;
            $model->description = $task->description;
            $model->deadline = $task->deadline;
            $model->assignee = $task->assignee_id;
            $model->status = $task->status_id;
        }

        return $this->render('update', compact('model'));
    }

    public function actionDelete($id)
    {
        Task::deleteAll(['id' => $id]);
        return $this->redirect('/desk');
    }
}