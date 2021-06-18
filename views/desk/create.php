<?php

/* @var $model TaskForm */

use app\models\domain\Status;
use app\models\forms\TaskForm;
use app\models\domain\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\jui\DatePicker;

$this->title = 'Create task';
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create task:</p>

<?php

$form = ActiveForm::begin([
    'id' => 'task-create-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ],
]);

echo $form->field($model, 'title')->textInput();
echo $form->field($model, 'description')->textarea();
echo $form->field($model, 'deadline')->widget(DatePicker::class, [
    'options' => ['class' => 'form-control'],
    'dateFormat' => 'yyyy-MM-dd'
]);
echo $form->field($model, 'status')->dropDownList(
    Status::find()->select(['title', 'id'])->indexBy('id')->column()
);
echo $form->field($model, 'assignee')->dropDownList(
    User::find()->select(['username', 'id'])->indexBy('id')->column()
); ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Create', ['class' => 'btn btn-success', 'name' => 'create-button']) ?>
        </div>
    </div>

<?php

ActiveForm::end();