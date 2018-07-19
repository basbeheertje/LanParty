<?php

namespace frontend\models;

use yii\web\UploadedFile;
use frontend\models\Game;
use Yii;

/**
 * Class GameForm
 * @package frontend\models
 *
 * @property UploadedFile $avatarFile
 * @property UploadedFile $profileFile
 */
class GameForm extends Game {
    /**
     * @var UploadedFile
     */
    public $avatarFile;

    /**
     * @var UploadedFile
     */
    public $profileFile;

    public function rules () {
        return array_merge(
            parent::rules(),
            [
                [['avatarFile', 'profileFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            ]
        );
    }

    /**
     * Uploads the images for the game
     * @return bool
     */
    public function upload () {
        /** @var string $avatarFolder */
        $avatarFolder = '/images/uploads/games/avatar/';
        /** @var string $avatarFolderPath */
        $avatarFolderPath = Yii::getAlias('@frontend/web/images/uploads/games/avatar/');
        /** @var string $avatarFolder */
        $profileFolder = '/images/uploads/games/profile/';
        /** @var string $profileFolderPath */
        $profileFolderPath = Yii::getAlias('@frontend/web/images/uploads/games/profile/');
        if ($this->avatarFile) {
            $this->avatar = $avatarFolder . $this->avatarFile->baseName . '.' . $this->avatarFile->extension;
        }
        if ($this->profileFile) {
            $this->profile_image = $profileFolder . $this->profileFile->baseName . '.' . $this->profileFile->extension;
        }
        if ($this->validate()) {
            if ($this->avatarFile) {
                $this->avatarFile->saveAs($avatarFolderPath . $this->avatarFile->baseName . '.' . $this->avatarFile->extension);
            }
            if ($this->profileFile) {
                $this->profileFile->saveAs($profileFolderPath . $this->profileFile->baseName . '.' . $this->profileFile->extension);
            }

            return true;
        }

        return false;
    }

    public function uploadAvatar () {
        /** @var string $folder */
        $folder = Yii::getAlias('@frontend/web/images/uploads/games/avatar/');
        $this->avatar = $folder . $this->avatarFile->baseName . '.' . $this->avatarFile->extension;
        if ($this->validate()) {
            $this->avatarFile->saveAs($folder . $this->avatarFile->baseName . '.' . $this->avatarFile->extension);

            return true;
        } else {
            return false;
        }
    }

    public function uploadProfile () {
        //if ($this->validate()) {
        $this->profileFile->saveAs(Yii::getAlias('@web/images/uploads/games/profile/' . $this->profileFile->baseName . '.' . $this->profileFile->extension));
        $this->profile_image = 'images/uploads/games/profile/' . $this->profileFile->baseName . '.' . $this->profileFile->extension;

        return true;
        //} else {
        //    return false;
        //}
    }
}