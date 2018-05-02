<?php

namespace common\dao;

use Yii;

/**
 * This is the model class for table "audit_entry".
 *
 * @property int $id
 * @property string $created
 * @property int $user_id
 * @property double $duration
 * @property string $ip
 * @property string $request_method
 * @property int $ajax
 * @property string $route
 * @property int $memory_max
 *
 * @property AuditData[] $auditDatas
 * @property AuditError[] $auditErrors
 * @property AuditJavascript[] $auditJavascripts
 * @property AuditMail[] $auditMails
 * @property AuditTrail[] $auditTrails
 */
class AuditEntry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'audit_entry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created'], 'required'],
            [['created'], 'safe'],
            [['user_id', 'ajax', 'memory_max'], 'integer'],
            [['duration'], 'number'],
            [['ip'], 'string', 'max' => 45],
            [['request_method'], 'string', 'max' => 16],
            [['route'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created' => Yii::t('app', 'Created'),
            'user_id' => Yii::t('app', 'User ID'),
            'duration' => Yii::t('app', 'Duration'),
            'ip' => Yii::t('app', 'Ip'),
            'request_method' => Yii::t('app', 'Request Method'),
            'ajax' => Yii::t('app', 'Ajax'),
            'route' => Yii::t('app', 'Route'),
            'memory_max' => Yii::t('app', 'Memory Max'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditDatas()
    {
        return $this->hasMany(AuditData::className(), ['entry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditErrors()
    {
        return $this->hasMany(AuditError::className(), ['entry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditJavascripts()
    {
        return $this->hasMany(AuditJavascript::className(), ['entry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditMails()
    {
        return $this->hasMany(AuditMail::className(), ['entry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditTrails()
    {
        return $this->hasMany(AuditTrail::className(), ['entry_id' => 'id']);
    }
}
