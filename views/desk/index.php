<?php

/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel TaskSearch */

use app\models\Status;
use app\models\TaskSearch;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

$this->title = 'Tasks';
?>

<h1>Desk</h1>
<p>There are all of the tasks</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'title',
        [
            'attribute' => 'status',
            'label' => 'Status',
            'value'=>'status.title',
            'filter' => ArrayHelper::map(Status::find()->all(), 'id', 'title')
        ],
        [
            'attribute' => 'created',
            'label' => 'Created',
            'value'=>'created',
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'value' => $searchModel->created,
                'attribute' => 'created',
                'options' => ['class' => 'form-control'],
                'dateFormat' => 'yyyy-MM-dd'
            ]),
        ],
        [
            'attribute' => 'deadline',
            'label' => 'Deadline',
            'value'=>'deadline',
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'value' => $searchModel->deadline,
                'attribute' => 'deadline',
                'options' => ['class' => 'form-control'],
                'dateFormat' => 'yyyy-MM-dd'
            ]),
        ],
        [
            'attribute' => 'author',
            'label' => 'Author',
            'value'=>'author.username',
            'filter' => ArrayHelper::map(User::find()->all(), 'id', 'username')
        ],
        [
            'attribute' => 'assignee',
            'label' => 'Assignee',
            'value'=>'assignee.username',
            'filter' => ArrayHelper::map(User::find()->all(), 'id', 'username')
        ],
        ['class' => 'yii\grid\ActionColumn']
    ],
]) ?>

<a href="/desk/create" class="btn btn-success">Create task</a>
