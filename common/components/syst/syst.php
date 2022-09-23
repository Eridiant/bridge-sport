<?php

use yii\helpers\Url;

?>
<li>
    <p>
        <?= $syst['description'] ?>
        <a href="<?= Url::to(['sys-itm/update', 'id' => $syst['id']]) ?>">&#9998;</a>
        <a href="<?= Url::to(['sys-itm/check', 'parent_id' => $syst['id'], 'syst_id' => $syst['syst_id'], 'lvl' => $syst['lvl']]) ?>" class="add" data-tooltip="добавить вопрос">&#10010;</a>
        <a href="<?= Url::to(['sys-itm/delete', 'id' => $syst['id']]) ?>" class="del">&#10008;</a>
    </p>

    <?php if(isset($syst['childs'])): ?>
        <ul>
            <?= $this->getMenuHtml($syst['childs']) ?>
        </ul>
    <?php endif; ?>
</li>