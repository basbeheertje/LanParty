<?php

use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?php

echo $form->field($model, 'avatarFile')->fileInput();

?>

    <button><?php echo Yii::t('frontend','Save'); ?></button>

<?php ActiveForm::end(); ?>