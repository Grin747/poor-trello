<?php

/* @var $model Task */
/* @var $commentDataProvider ActiveDataProvider */
/* @var $lossDataProvider ActiveDataProvider */

use app\models\forms\CommentForm;
use app\models\forms\LossForm;
use app\models\domain\Task;
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
        'id',
        'title',
        'description:html',
        'created',
        'deadline',
        ['label' => 'Assignee', 'value' => $model->assignee->username],
        ['label' => 'Author', 'value' => $model->author->username],
        ['label' => 'Status', 'value' => $model->status->title]
    ]
]);


$this->title = 'Task #' . $model->id;

?>

<div class="col-lg-6">

    <h1>Comments</h1>

    <?php

    $comment = new CommentForm();
    $form = ActiveForm::begin([
        'id' => 'comment-form',
        'action' => Url::toRoute('/comment/create')
    ]);

    echo $form->field($comment, 'task_id')->hiddenInput(['value' => $model->id])->label(false);
    echo $form->field($comment, 'value')->textarea(['rows' => 5, 'class' => 'form-control']);

    ?>

    <div class="form-group">
        <?= Html::submitButton('Comment', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php

    ActiveForm::end();

    echo GridView::widget([
        'dataProvider' => $commentDataProvider,
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

    $loss = new LossForm();
    $form = ActiveForm::begin([
        'id' => 'time-form',
        'action' => Url::toRoute('/loss/create')
    ]);

    echo $form->field($loss, 'task_id')->hiddenInput(['value' => $model->id])->label(false);
    echo $form->field($loss, 'loss')->textInput();
    echo $form->field($loss, 'title')->TextInput();

    ?>

    <div class="form-group">
        <?= Html::submitButton('Add loss', ['class' => 'btn btn-primary', 'name' => 'time-button']) ?>
    </div>

    <?php

    ActiveForm::end();

    echo GridView::widget([
        'dataProvider' => $lossDataProvider,
        'columns' => [
            ['attribute' => 'author', 'label' => 'Author', 'value' => 'author.username'],
            'title',
            'loss'
        ]
    ]); ?>

</div>

