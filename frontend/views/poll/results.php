<?php
use yii\helpers\Html;

?>
<div class="poll-question-view">

    <div class="poll">
        <div class="poll-header">
            Результаты опроса:
        </div>
        <?php foreach ($model->pollQuestions as $question): ?>
            <div class="poll-question" data-id=<?= $question->id; ?>>
                <p><?= $question->text; ?></p>
                <?php
                    $sum = 0;
                    foreach ($question->answers as $answer) {
                        $sum += $answer->result->result_count + $model->show_only_user_result * $answer->result->result_guest_count;
                    }
                ?>
                <?php foreach ($question->answers as $answer ): ?>
                    <div class="poll-response">
                        <p><?= $answer->text; ?></p>
                        <?php if ($model->show_result): ?>
                            <?php
                                $percent = ($sum != 0) ? (($answer->result->result_count + $model->show_only_user_result * $answer->result->result_guest_count) / $sum * 100) : 0;
                            ?>
                            <div class="answer-<?= $answer->result->is_correct; ?>"
                                style="width: <?= $percent; ?>%;"></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

</div>
