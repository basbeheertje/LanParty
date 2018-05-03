<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "audit_error".
 *
 * @property int $id
 * @property int $entry_id
 * @property string $created
 * @property string $message
 * @property int $code
 * @property string $file
 * @property int $line
 * @property resource $trace
 * @property string $hash
 * @property int $emailed
 *
 * @property AuditEntry $entry
 */
class AuditError extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_error';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entry_id', 'created', 'message'], 'required'],
            [['entry_id', 'code', 'line', 'emailed'], 'integer'],
            [['created'], 'safe'],
            [['message', 'trace'], 'string'],
            [['file'], 'string', 'max' => 512],
            [['hash'], 'string', 'max' => 32],
            [['entry_id'], 'exist', 'skipOnError' => true, 'targetClass' => AuditEntry::className(), 'targetAttribute' => ['entry_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'entry_id' => Yii::t('app', 'Entry ID'),
            'created' => Yii::t('app', 'Created'),
            'message' => Yii::t('app', 'Message'),
            'code' => Yii::t('app', 'Code'),
            'file' => Yii::t('app', 'File'),
            'line' => Yii::t('app', 'Line'),
            'trace' => Yii::t('app', 'Trace'),
            'hash' => Yii::t('app', 'Hash'),
            'emailed' => Yii::t('app', 'Emailed'),
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
