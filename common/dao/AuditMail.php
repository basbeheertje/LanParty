<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "audit_mail".
 *
 * @property int $id
 * @property int $entry_id
 * @property string $created
 * @property int $successful
 * @property string $from
 * @property string $to
 * @property string $reply
 * @property string $cc
 * @property string $bcc
 * @property string $subject
 * @property resource $text
 * @property resource $html
 * @property resource $data
 *
 * @property AuditEntry $entry
 */
class AuditMail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_mail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entry_id', 'created', 'successful'], 'required'],
            [['entry_id', 'successful'], 'integer'],
            [['created'], 'safe'],
            [['text', 'html', 'data'], 'string'],
            [['from', 'to', 'reply', 'cc', 'bcc', 'subject'], 'string', 'max' => 255],
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
            'successful' => Yii::t('app', 'Successful'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
            'reply' => Yii::t('app', 'Reply'),
            'cc' => Yii::t('app', 'Cc'),
            'bcc' => Yii::t('app', 'Bcc'),
            'subject' => Yii::t('app', 'Subject'),
            'text' => Yii::t('app', 'Text'),
            'html' => Yii::t('app', 'Html'),
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
