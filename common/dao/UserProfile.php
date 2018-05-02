<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $avatar
 *
 * @property User $id0
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'first_name', 'last_name', 'avatar'], 'required'],
            [['id'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 31],
            [['avatar'], 'string', 'max' => 63],
            [['id'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'avatar' => Yii::t('app', 'Avatar'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }
}
