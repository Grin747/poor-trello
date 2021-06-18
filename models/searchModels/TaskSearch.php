<?php


namespace app\models;


use app\models\domain\Task;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TaskSearch extends Model
{
    public string $title;
    public int $status;
    public string $created;
    public string $deadline;
    public int $author;
    public int $assignee;

    public function rules(): array
    {
        return [
            [['status', 'author', 'assignee'], 'integer'],
            [['title'], 'safe'],
            [['created', 'deadline'], 'date',  'format' => 'php:Y-m-d']
        ];
    }

    public function search($params): ActiveDataProvider
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