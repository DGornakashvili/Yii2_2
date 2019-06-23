<?php

namespace frontend\models\filters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tasks;

/**
 * TasksFilter represents the model behind the search form of `app\models\tables\Tasks`.
 */
class TasksFilter extends Tasks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'responsible_id', 'status_id'], 'integer'],
            [['name', 'description', 'deadline', 'created', 'updated'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function monthFilter($params)
    {
	    $query = Tasks::find();

	    $dataProvider = new ActiveDataProvider([
		    'query' => $query,
	    ]);

	    $this->load($params);

	    if (!$this->validate()) {
		    return $dataProvider;
	    }

	    $query->andFilterWhere(['=', 'MONTH(created)', $this->created]);

	    return $dataProvider;
    }
}
