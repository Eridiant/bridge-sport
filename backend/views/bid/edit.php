<?php

use common\components\SystWidget;
use yii\helpers\Html;
use yii\helpers\Url;
// $this->registerCss("
// p { margin-left: 30px; }");

?>

<a href="<?= Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/system/' . \backend\models\system\System::findOne($id)->slug]); ?>">ссылка на систему</a>
<br>
<br>

<p>переносы учитываются, завершение редактирования клик в любом месте вне блока или cntr+enter</p>
<p>удалить двойные пробелы alr+enter</p>

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
            <input type="radio" name="radio" id="imps"><label for="imps">импы</label>
            <input type="radio" name="radio" id="max"><label for="max">макс</label>
            <input type="radio" name="radio" id="rubber"><label for="rubber">роббер</label>
        </div>
        <!-- <div id="vulnerable" class="row">
            <input type="radio" name="radio" id="none">
            <label for="none">все&#160;до&#160;зоны</label>
            <input type="radio" name="radio" id="all">
            <label for="all">все&#160;в&#160;зоне</label>
            <input type="radio" name="radio" id="nvul">
            <label for="nvul">до&#160;против&#160;зоны</label>
            <input type="radio" name="radio" id="vul">
            <label for="vul">в&#160;зоне&#160;против&#160;до</label>
        </div> -->
        <div class="row">
            <input type="checkbox" name="checkbox" id="competition"><label for="competition">конкуренция</label>
            <input type="checkbox" name="checkbox" id="intervention"><label for="intervention">интервенция</label>
            <input type="checkbox" name="checkbox" id="fillout"><label for="fillout">заполнение&#160;заявок</label>
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
        <!-- <div class="bidding-wrapper">
            <span data-num="1" data-bid="1c">1c</span><span data-num="2" data-bid="1d">1d</span><span data-num="3" data-bid="1h">1h</span><span data-num="4" data-bid="1s">1s</span><span data-num="5" data-bid="1nt">1nt</span>
            <span data-num="6" data-bid="2c">2c</span><span data-num="7" data-bid="2d">2d</span><span data-num="8" data-bid="2h">2h</span><span data-num="9" data-bid="2s">2s</span><span data-num="10" data-bid="2nt">2nt</span>
            <span data-num="11" data-bid="3c">3c</span><span data-num="12" data-bid="3d">3d</span><span data-num="13" data-bid="3h">3h</span><span data-num="14" data-bid="3s">3s</span><span data-num="15" data-bid="3nt">3nt</span>
            <span data-num="16" data-bid="4c">4c</span><span data-num="17" data-bid="4d">4d</span><span data-num="18" data-bid="4h">4h</span><span data-num="19" data-bid="4s">4s</span><span data-num="20" data-bid="4nt">4nt</span>
            <span data-num="21" data-bid="5c">5c</span><span data-num="22" data-bid="5d">5d</span><span data-num="23" data-bid="5h">5h</span><span data-num="24" data-bid="5s">5s</span><span data-num="25" data-bid="5nt">5nt</span>
            <span data-num="26" data-bid="6c">6c</span><span data-num="27" data-bid="6d">6d</span><span data-num="28" data-bid="6h">6h</span><span data-num="29" data-bid="6s">6s</span><span data-num="30" data-bid="6nt">6nt</span>
            <span data-num="31" data-bid="7c">7c</span><span data-num="32" data-bid="7d">7d</span><span data-num="33" data-bid="7h">7h</span><span data-num="34" data-bid="7s">7s</span><span data-num="35" data-bid="7nt">7nt</span>
        </div>
        <div id="dbl" class="bidding-competition">
            <span data-num="0" data-bid="pass">pass</span>
            <span class="double" data-num="-1" data-bid="Dbl">Dbl</span>
            <span class="re-double" data-num="-2" data-bid="ReDbl">ReDbl</span>
        </div> -->
    </div>
    <div id="bidding-values" class="bidding-values"></div>
</div>


<br>
<br>
<br>


<br>
<br>
<br> 
