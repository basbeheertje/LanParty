<?php

namespace common\models;

use yii\base\Exception;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use Yii;

/**
 * Class AvatarForm
 * @package common\models
 *
 * @property UploadedFile $avatarFile
 */
class AvatarForm extends User
{
    /**
     * @var UploadedFile
     */
    public $avatarFile;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        /** @var array $rules */
        $rules = parent::rules();
        $rules[] = [['avatarFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'];
        return $rules;
    }

    /**
     * To upload an avatar
     * @return bool
     * @throws Exception
     */
    public function upload()
    {
        /** @var string $avatarPath */
        $avatarPath = '/images/uploads/users/avatar/';
        /** @var string $avatarFolder */
        $avatarFolder = Yii::getAlias('@frontend/web' . $avatarPath);
        /** @var string $filename */
        $filename = $this->id . '-' . md5($this->username . date('Y-m-d H:i:s')) . '.' . $this->avatarFile->extension;
        if($this->avatarFile) {
            $uploadPathName = $avatarFolder . $filename;
            $this->avatar = $avatarPath . $filename;
            if(!$this->validate()){
                throw new Exception('Model is not valid!' . VarDumper::dumpAsString($this->getErrors()));
            }
            if ($this->validate()) {
                if($this->avatarFile){
                    $this->avatarFile->saveAs($uploadPathName, false);
                }
                return true;
            }
        }
        return false;
    }
}