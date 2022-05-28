<?php

use common\components\MenuWidget;

?>
    <?php if ($this->params['aside']): ?>
        <aside>
            <?= MenuWidget::widget(['tpl' => 'menu']); ?>
        </aside>
    <?php endif; ?>