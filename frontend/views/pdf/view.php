<?php

?>

<?= \yii\helpers\Html::a( 'Back', Yii::$app->request->referrer); ?>

<object data="<?= $filePath; ?>" type="application/pdf">
<!-- <a href="data/test.pdf">test.pdf</a> -->
<!-- </object> -->


<!-- <iframe src="https://docs.google.com/gview?url=https://path.com/to/your/pdf.pdf&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe> -->