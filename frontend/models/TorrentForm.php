<?php

namespace frontend\models;

use yii\base\Exception;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use Yii;

/**
 * Class AvatarForm
 * @package common\models
 *
 * @property UploadedFile $torrentFile
 */
class TorrentForm extends Torrent {
    /**
     * @var UploadedFile
     */
    public $torrentFile;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules () {
        /** @var array $rules */
        $rules = parent::rules();
        $rules[] = [['torrentFile'], 'file', 'skipOnEmpty' => false];

        return $rules;
    }

    /**
     * To upload an torrent
     * @return bool
     * @throws Exception
     */
    public function upload () {
        /** @var string $torrentFolder */
        $torrentFolder = Yii::getAlias('@torrents/');
        if ($this->torrentFile) {
            $uploadPathName = $torrentFolder . $this->torrentFile->baseName . '.' . $this->torrentFile->extension;
            $this->filename = $this->torrentFile->baseName . '.' . $this->torrentFile->extension;
            $this->path = $torrentFolder . $this->filename;
        }
        $valid = $this->validate();
        if (!$valid) {
            throw new Exception('Model is not valid!' . VarDumper::dumpAsString($this->getErrors()));
        }
        if ($this->validate()) {
            if ($this->torrentFile) {
                $this->torrentFile->saveAs($uploadPathName, false);
            }

            return true;
        } else {
            return false;
        }
    }
}