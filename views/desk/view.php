<?php

/* @var $model Task */

use app\models\Comment;
use app\models\CommentForm;
use app\models\Task;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

echo DetailView::widget([
    'model' => $model,
    'options' => ['class' => 'table table-hover'],
    'attributes' => [
        'title',
        'description:html',
        'created',
        'deadline',
        ['label' => 'Author', 'value' => $model->author->username]
    ]
]);

$dataProvider = new ActiveDataProvider([
    'query' => Comment::find()->where(['task_id' => $model->id]),
    'pagination' => [
        'pageSize' => 20,
    ],
]);

?>

<div class="col-lg-6">

    <h1>Comments</h1>

    <?php

    $comment = new CommentForm();
    $form = ActiveForm::begin([
        'id' => 'comment-form',
        'options' => ['class' => 'form-horizontal'],
        'action' => Url::toRoute('/comment/create')
    ]);

    echo $form->field($comment, 'task_id')->hiddenInput(['value' => $model->id])->label(false);
    echo $form->field($comment, 'value')->textarea(['rows' => 6]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('Comment', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php

    ActiveForm::end();

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['attribute' => 'author', 'label' => 'Author', 'value' => 'author.username'],
            ['attribute' => 'value', 'label' => 'Comment'],
        ]
    ]);

    ?>

</div>

<div class="col-lg-6">

    <h1>Time expenses</h1>

    <?php

    $comment = new CommentForm();
    $form = ActiveForm::begin([
        'id' => 'time-form',
        'options' => ['class' => 'form-horizontal'],
        'action' => Url::toRoute('/comment/create')
    ]);

    echo $form->field($comment, 'task_id')->hiddenInput(['value' => $model->id])->label(false);
    echo $form->field($comment, 'value')->textInput();
    echo $form->field($comment, 'value')->textarea(['rows' => 2]);

    ?>

    <div class="form-group">
        <?= Html::submitButton('Comment', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php

    ActiveForm::end();

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['attribute' => 'author', 'label' => 'Author', 'value' => 'author.username'],
            ['attribute' => 'value', 'label' => 'Comment'],
        ]
    ]); ?>

</div>

