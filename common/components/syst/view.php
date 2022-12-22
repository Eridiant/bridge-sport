<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<?= Html::tag('h' . $syst['lvl'], $syst['converted'], ['class' => 'username']) ?>

<?php if(isset($syst['childs'])): ?>
    <div>
        <?= $this->getMenuHtml($syst['childs']) ?>
    </div>
<?php endif; ?>
<span></span>
