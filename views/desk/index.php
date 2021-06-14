<?php

/* @var $models Task[] */

/* @var $pages Pagination */

use app\models\Task;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Tasks'; ?>

<h1>Desk</h1>
<p>There are all of the tasks</p>


<?php foreach ($models as $model) { ?>

    <h5 class="card-title"><?= $model->title ?></h5>
    <p class="card-text text-muted"><?= $model->created ?></p>
    <a href="<?= Url::toRoute(['desk/detail', 'id' => $model->id]) ?>">View</a>

<?php } ?>


<?= LinkPager::widget(['pagination' => $pages,]); ?>

<a href="/desk/create" class="btn btn-success">Create task</a>
