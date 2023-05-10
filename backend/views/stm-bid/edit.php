<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<a href="<?= Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/system/' . \backend\models\system\System::findOne($id)->slug]); ?>">ссылка на систему</a>

<div class="">
<div id="box" class="bidding-box">
        <div class="bidding-wrapper">
            <?php foreach ($bids as $bid): ?>
                <span data-id="<?= $bid->id; ?>" data-num="<?= $bid->num; ?>" data-bid="<?= $bid->bid; ?>"><?= $bid->bid; ?></span>
            <?php endforeach; ?>
        </div>
        <div id="dbl" class="bidding-competition">
            <?php foreach ($pass as $pass): ?>
                <?php 
                    if ($pass->id == 2) {
                        $dbl = 'double';
                    } else if ($dbl = $pass->id == 3){
                        $dbl = 're-double';
                    }?>
                <span class="<?= $dbl ?>" data-id="<?= $pass->id; ?>" data-num="<?= $pass->num; ?>" data-bid="<?= $pass->bid; ?>"><?= $pass->bid; ?></span>
            <?php endforeach; ?>
        </div>
    </div>
    <div id="bidding-values" class="bidding-values"></div>
</div>