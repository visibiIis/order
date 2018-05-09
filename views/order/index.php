<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php

        $create = Html::a('Create Order', ['create'], ['class' => 'btn btn-success']);

        if (Yii::$app->user->can('admin')) {
            echo $create;
        } ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'table',


            'description:ntext',


            [
                'attribute' => 'booked',
                'format' => 'raw',
                'filter' => [
                    1 => 'Busy',
                    0 => 'Free',
                ],
                'value' => function ($model, $key, $index, $column) {
                    $active = $model->{$column->attribute} === 0;
                    return \yii\helpers\Html::tag(
                        'span',
                        $active ? 'Free' : 'Busy',
                        [
                            'class' => 'label label-' . ($active ? 'info' : 'danger'),
                        ]
                    );
                },
            ],
        ],
    ]); ?>
</div>
