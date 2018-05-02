<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "audit_javascript".
 *
 * @property int $id
 * @property int $entry_id
 * @property string $created
 * @property string $type
 * @property string $message
 * @property string $origin
 * @property resource $data
 *
 * @property AuditEntry $entry
 */
class AuditJavascript extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'audit_javascript';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entry_id', 'created', 'type', 'message'], 'required'],
            [['entry_id'], 'integer'],
            [['created'], 'safe'],
            [['message', 'data'], 'string'],
            [['type'], 'string', 'max' => 20],
            [['origin'], 'string', 'max' => 512],
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
            'created' => Yii::t('app', 'Created'),
            'type' => Yii::t('app', 'Type'),
            'message' => Yii::t('app', 'Message'),
            'origin' => Yii::t('app', 'Origin'),
            'data' => Yii::t('app', 'Data'),
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
