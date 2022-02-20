<p><?= $model->description; ?></p>

<div class="form">
    <form method="post" action="/">
        <?php foreach ($model->answers as $key=>$value): ?>
            <div>
                <input type="radio" id="<?= $key; ?>" data-answer="<?= $value->id; ?>" name="subscribe" value="newsletter">
                <label for="<?= $key; ?>"><?= $value->description; ?></label>
            </div>
        <?php endforeach; ?>
        <p class="submit" data-quiz="<?= $model->survey_id; ?>" data-id="<?= $model->id; ?>">отправить</p>
    </form>
</div>
