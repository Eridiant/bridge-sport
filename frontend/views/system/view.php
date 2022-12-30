<?php

use yii\helpers\Html;
use yii\helpers\Url;
// $this->registerCss("
// p { margin-left: 30px; }");

?>
<div id="bidding" class="bidding" data-system="<?= $id; ?>">

    <div class="bidding-table">
        <div class="bidding-table-head">
            <span>N</span>
            <span>W</span>
            <span>S</span>
            <span>E</span>
        </div>
        <div id="body" class="bidding-table-body" data-parent="0">
            <span>?</span>
        </div>
        <h1></h1>
    </div>

    <form class="bidding-form" action="#" method="post">
        <div class="row">
            <input type="checkbox" name="checkbox" id="competition"><label for="competition">конкуренция</label>
            <!-- <input type="checkbox" name="checkbox" id="intervention"><label for="intervention">интервенция</label> -->
        </div>
    </form>
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