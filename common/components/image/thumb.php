<?php

preg_match('/[a-z]{2,}$/', $model->format, $img);

?>
<?= $sources; ?>
<img src="/images/<?= "{$model->path}-{$model->thWidth}x{$model->thHeight}.{$img[0]}"; ?>" alt="<?= $model->alt; ?>" width="<?= $model->thWidth; ?>" height="<?= $model->thHeight; ?>" class="news-img">