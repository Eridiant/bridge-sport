<?php

use common\components\MenuWidget;

?>
    <?php if (isset($this->params['aside'])): ?>
        <aside class="aside">
            <div class="aside-wrapper">
                <header class="aside-header">
                    <div class="nav-logo">
                        <a class="title" href="/">Bridge sport</a>
                    </div>
                    <div class="aside-close">
                        <p>&#10007;</p>
                    </div>
                </header>
                <ul>
                    <?= MenuWidget::widget(['tpl' => 'menu']); ?>
                    <li><a href="/system/index">Системы</a></li>
                </ul>
            </div>
        </aside>
    <?php endif; ?>