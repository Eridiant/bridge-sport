
<p><?= $model->description; ?></p>
<form method="post" action="/">
    <?php foreach ($model->answers as $key=>$value): ?>
        <div>
            <input type="checkbox" id="<?= $key; ?>" name="subscribe" value="newsletter">
            <label for="<?= $key; ?>"><?= $value->description; ?></label>
        </div>
    <?php endforeach; ?>
    <input type="submit" value="Отправить">
</form>