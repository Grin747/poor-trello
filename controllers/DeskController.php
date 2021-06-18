<?php

namespace app\controllers;

use app\models\domain\Comment;
use app\models\domain\Loss;
use app\models\domain\Task;
use app\models\forms\TaskForm;
use app\models\TaskSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DeskController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
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

    /**
     * Displays desk page.
     *
     * @return Response|string
     */
    public function actionIndex(): string
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', compact('dataProvider', 'searchModel'));
    }

    /**
     * Creates task.
     *
     * @return Response|string
     */
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

    /**
     * Displays detail task view.
     *
     * @return Response|string
     */
    public function actionView($id): string
    {
        $model = Task::findOne($id) ?? $this->redirect('/desk');

        $commentDataProvider = new ActiveDataProvider([
            'query' => Comment::find()->where(['task_id' => $model->id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $lossDataProvider = new ActiveDataProvider([
            'query' => Loss::find()->where(['task_id' => $model->id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('view', compact('model', 'commentDataProvider', 'lossDataProvider'));
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
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

    /**
     * Deletes task.
     *
     * @param $id
     * @return Response
     */
    public function actionDelete($id): Response
    {
        $rows = Task::deleteAll(['id' => $id]);
        if ($rows != 1) Yii::$app->session->setFlash('error', 'Error');
        return $this->redirect('/desk');
    }
}