<?php


namespace app\controllers;

use app\models\Comment;
use app\models\CommentForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommentController extends Controller
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

    public function actionCreate()
    {
        $form = new CommentForm();
        if($form->load(Yii::$app->request->post()) && $form->validate())
        {
            $model = new Comment();
            $model->value = $form->value;
            $model->task_id = $form->task_id;
            $model->author_id = Yii::$app->user->id;
            $model->created = date('Y-m-d H:i:s');

            $model->save();
            $this->redirect(Url::toRoute(['/desk/view', 'id' => $form->task_id]));
            return;
        }
        $this->goHome();
    }
}