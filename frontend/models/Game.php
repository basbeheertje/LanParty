<?php

namespace frontend\models;

/**
 * Class Game
 * @package frontend\models
 */
class Game extends \common\models\Game
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}