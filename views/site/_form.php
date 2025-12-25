<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\Filling $filling */

use app\models\Tank;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="mt-3 mb-5">

    <?php
        Pjax::begin(['submitEvent' => 'submit']);
        $form = ActiveForm::begin([
            'options' => ['data-pjax' => true],
        ]);
    ?>

    <div class="row justify-content-center">
        <div class="col-auto">
            <?= $form->field($filling, 'filled_by')
                ->label(false)
                ->textInput()
                ->input('text', [
                    'placeholder' => Yii::t('app', 'Filled By'),
                ]) ?>
        </div>

        <div class="col-2">
            <?= $form->field($filling, 'quantity')
                ->label(false)
                ->textInput()
                ->input('number', [
                    'min' => '1',
                    'max' => (string)Tank::getMaximumCapacity(),
                    'placeholder' => Yii::t('app', 'Quantity (l)'),
                ]) ?>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-auto">
            <?= Html::submitButton(Yii::t('app', 'Add'), [
                'class' => 'btn btn-primary rounded-pill',
                'style' => 'min-width: 200px;',
            ]) ?>
        </div>
    </div>

    <?php
        ActiveForm::end();
        Pjax::end();
    ?>

</div>
