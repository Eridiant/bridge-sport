<?php

preg_match('/[a-z]{2,}$/', $model->format, $img);

?>
<?= $source; ?>
<?= $sources; ?>
<img src="/images/<?= "{$model->path}-{$model->width}x{$model->height}.{$img[0]}"; ?>" alt="<?= $model->alt; ?>" width="<?= $model->width; ?>" height="<?= $model->height; ?>">