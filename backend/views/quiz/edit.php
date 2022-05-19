<?php

use common\components\QuizWidget;
use yii\helpers\Html;
use yii\helpers\Url;
$this->registerCss("
p { margin-left: 30px; }");

?>
<style>
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
<?= QuizWidget::widget(['id' => $id]); ?>


