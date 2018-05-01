<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'username',


            'email:email',


            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => [
                    10 => 'Active',
                    0 => 'Deleted',
                ],
                'value' => function ($model, $key, $index, $column) {
                    $active = $model->{$column->attribute} === 0;
                    return \yii\helpers\Html::tag(
                        'span',
                        $active ? 'Deleted' : 'Active',
                        [
                            'class' => 'label label-' . ($active ? 'danger' : 'success'),
                        ]
                    );
                },
            ],    


            [
                'attribute' => 'created_at',
                'label' => 'Created at',
                'format' => 'datetime',
            ],


            [
                'attribute' => 'updated_at',
                'label' => 'Updated at',
                'format' => 'datetime',
            ],


            [
                'attribute' => 'role',
                'label' => 'User Role',
                'value' => function($model)
                {
                    return $model->getRole();
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
