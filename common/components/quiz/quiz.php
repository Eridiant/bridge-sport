
<li>
    <p>
        <?= $quiz['description'] ?>
        <a href="<?= \yii\helpers\Url::to(['quiz/update', 'id' => $quiz['id']]) ?>">&#9998;</a>
        <a href="<?= \yii\helpers\Url::to(['quiz/check', 'parent_id' => $quiz['id'], 'survey_id' => $quiz['survey_id']]) ?>" class="add" data-tooltip="добавить вопрос">&#10010;</a>
        <a href="<?= \yii\helpers\Url::to(['quiz/delete', 'id' => $quiz['id']]) ?>" class="del">&#10008;</a>
        <a href="<?= \yii\helpers\Url::to(['answer/create', 'quiz_id' => $quiz['id'], 'survey_id' => $quiz['survey_id']]) ?>" data-tooltip="добавить вариант ответа">&#10010;</a>
    </p>
    <?php if ($quiz['answers']): ?>
        <?php foreach ($quiz['answers'] as $answer): ?>
            <p>
                - <?= $answer['description']; ?>
                <a href="<?= \yii\helpers\Url::to(['answer/update', 'id' => $answer['id']]) ?>" class="edit">&#9998;</a>
                <a href="<?= \yii\helpers\Url::to(['quiz/check', 'parent_id' => $quiz['id'], 'answer_id' => $answer['id'], 'survey_id' => $quiz['survey_id']]) ?>" class="add">&#10010;</a>
                <a href="<?= \yii\helpers\Url::to(['answer/delete', 'id' => $answer['id']]) ?>" class="del">&#10008;</a>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if(isset($quiz['childs'])): ?>
        <ul>
            <?= $this->getMenuHtml($quiz['childs']) ?>
        </ul>
    <?php endif; ?>
</li>