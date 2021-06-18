<?php

namespace app\controllers;

use app\models\domain\Loss;
use app\models\forms\LossForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class LossController extends Controller
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
     * Creates loss.
     */
    public function actionCreate()
    {
        $form = new LossForm();
        if($form->load(Yii::$app->request->post()) && $form->validate())
        {
            $model = new Loss();
            $model->title = $form->title;
            $model->loss = $form->loss;
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