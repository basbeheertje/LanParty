<?php

use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

echo $form->field($model, 'torrentFile')->fileInput();

?>
<button><?php echo Yii::t('frontend','Save'); ?></button>
<?php ActiveForm::end(); ?>