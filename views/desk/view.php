<?php

/* @var $model Task */

use app\models\Task;
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