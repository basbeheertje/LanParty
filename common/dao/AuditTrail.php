<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "audit_trail".
 *
 * @property int $id
 * @property int $entry_id
 * @property int $user_id
 * @property string $action
 * @property string $model
 * @property string $model_id
 * @property string $field
 * @property string $old_value
 * @property string $new_value
 * @property string $created
 *
 * @property AuditEntry $entry
 */
class AuditTrail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'audit_trail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entry_id', 'user_id'], 'integer'],
            [['action', 'model', 'model_id', 'created'], 'required'],
            [['old_value', 'new_value'], 'string'],
            [['created'], 'safe'],
            [['action', 'model', 'model_id', 'field'], 'string', 'max' => 255],
            [['entry_id'], 'exist', 'skipOnError' => true, 'targetClass' => AuditEntry::className(), 'targetAttribute' => ['entry_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'entry_id' => Yii::t('app', 'Entry ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'action' => Yii::t('app', 'Action'),
            'model' => Yii::t('app', 'Model'),
            'model_id' => Yii::t('app', 'Model ID'),
            'field' => Yii::t('app', 'Field'),
            'old_value' => Yii::t('app', 'Old Value'),
            'new_value' => Yii::t('app', 'New Value'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntry()
    {
        return $this->hasOne(AuditEntry::className(), ['id' => 'entry_id']);
    }
}
