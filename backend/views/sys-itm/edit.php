<?php

use common\components\SystWidget;
use yii\helpers\Html;
use yii\helpers\Url;
// $this->registerCss("
// p { margin-left: 30px; }");

?>
<style>
    ul {
        padding-left: 20px;
    }
    ul li p {
        display: inline-block;
    }
    li {
        /* display: flex; */
    }
    p {
        margin: 0;
    }
    p a {
        font-size: 22px;
    }
    a {
        position: relative;
    }
    a.del {
        color: red;
    }
    a.edit {
        color: green;
    }
    a.add {
        color: green;
    }
    [data-tooltip]:hover::after {
        position: absolute;
        top: 30px;
        /* bottom: -70px; */
        left: 10px;
        content: attr(data-tooltip);
        padding: 10px;
        line-height: 1.1;
        font-size: 14px;
        background-color: #fff;
        z-index: 1;
    }
</style>
<a href="<?= Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/syst/' . \backend\models\Syst::findOne($id)->slug]); ?>">ссылка на систему</a>
<br>
<a href="<?= Url::to(['sys-itm/check', 'parent_id' => 0, 'syst_id' => $id, 'lvl' => 0]) ?>" class="add" data-tooltip="добавить вопрос">добавить пункт &#10010;</a>
<ul>
    <?= SystWidget::widget(['id' => $id]); ?>
</ul>


