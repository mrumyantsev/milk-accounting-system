<?php

/** @var yii\web\View $this */
/** @var app\models\Tank[] $tanks */
/** @var app\models\Filling $filling */
/** @var app\models\Filling[] $fillings */

?>

<div class="site-index">
    <!-- tank filling levels start -->
    <h3 class="text-center user-select-none">
        <?= Yii::t('app', 'Tank Filling Levels') ?>
    </h3>

    <div id="tank-levels" class="user-select-none mt-3 mb-5">

        <?php foreach ($tanks as $tank): ?>
            <div class="row justify-content-center m-2" style="height: 38px;">
                <div class="col-2 text-white text-center bg-secondary h-100 d-flex justify-content-end rounded-2 p-2">
                    <b class="font-sans align-self-center w-100 overflow-hidden"
                        style="text-overflow: ellipsis; white-space: nowrap;">
                        <?= Yii::t('app', 'Tank') . ' ' . $tank->id ?>
                    </b>
                </div>

                <div class="col-6 h-100 progress-label-container">
                    <div class="progress h-100">
                        <div class="progress-bar"
                            role="progressbar"
                            aria-valuenow="<?= $tank->quantity ?>"
                            aria-valuemin="0"
                            aria-valuemax="<?= $tank->capacity ?>"
                            style="width: <?= $tank->quantity / $tank->capacity * 100 ?>%;">
                        </div>
                    </div>
                    <div class="progress-label">
                        <b><?= $tank->quantity . '/' . $tank->capacity . ' ' . Yii::t('app', 'l') ?></b>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
    <!-- tank filling levels end -->

    <!-- new filling form start -->
    <h3 class="text-center user-select-none">
        <?= Yii::t('app', 'New Filling') ?>
    </h3>

    <?= $this->render('_form', [
        'filling' => $filling,
    ]) ?>
    <!-- new filling form end -->

    <!-- filling log start -->
    <h3 class="text-center user-select-none">
        <?= Yii::t('app', 'Filling Log') ?>
    </h3>

    <table id="filling-table" class="table text-center w-75 mx-auto">
        <thead>
            <tr>
                <th class="col-4"><?= Yii::t('app', 'Filled By') ?></th>
                <th class="col-auto"><?= Yii::t('app', 'Quantity (l)') ?></th>
                <th class="col-auto"><?= Yii::t('app', 'Became (l)') ?></th>
                <th class="col-auto"><?= Yii::t('app', 'Tank') ?></th>
                <th class="col-auto"><?= Yii::t('app', 'Date and Time') ?></th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($fillings as $filling): ?>
                <tr>
                    <td><?= $filling->filled_by ?></td>
                    <td><?= $filling->quantity ?></td>
                    <td><?= $filling->became ?></td>
                    <td><?= $filling->tank_id ?></td>
                    <td><?= $filling->getCreatedAtLocalized() ?></td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
    <!-- filling log end -->
</div>

<?php

    // Registering PJAX event to send the form asynchronously, without
    // reloading of the page.
    $this->registerJs(
        '$(document).on("pjax:end", function() {
            $.pjax.reload("#tank-levels, #filling-table");
        });'
    );

?>
