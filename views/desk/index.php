<?php

/* @var $models Task[] */

/* @var $pages Pagination */

use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Tasks';

$dataProvider = new ActiveDataProvider([
    'query' => Task::find(),
    'pagination' => [
        'pageSize' => 5,
    ],
]); ?>

<h1>Desk</h1>
<p>There are all of the tasks</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'title',
        'created',
        'deadline',
        ['attribute' => 'author','label' => 'Author', 'value'=>'author.username'],
        ['attribute' => 'assignee','label' => 'Assignee', 'value'=>'assignee.username'],
        ['class' => 'yii\grid\ActionColumn']
    ],
]) ?>

<a href="/desk/create" class="btn btn-success">Create task</a>
