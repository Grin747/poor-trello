<?php


namespace app\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;

class TaskSearch extends Model
{
    public $title;
    public $status;
    public $created;
    public $deadline;
    public $author;
    public $assignee;

    public function rules()
    {
        return [
            [['status', 'author', 'assignee'], 'integer'],
            [['title'], 'safe'],
            [['created', 'deadline'], 'date',  'format' => 'php:Y-m-d']
        ];
    }

    public function search($params)
    {
        $query = Task::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['status_id' => $this->status]);
        $query->andFilterWhere(['author_id' => $this->author]);
        $query->andFilterWhere(['assignee_id' => $this->assignee]);
        if ($this->created != null) $query->andWhere('created = date(\'' . $this->created . '\')');
        if ($this->deadline != null) $query->andWhere('created = date(\'' . $this->deadline . '\')');

        return $dataProvider;
    }
}