<?php

namespace frontend\models;

/**
 * Class Torrent
 * @package frontend\models
 *
 * @property boolean $isDownloaded
 */
class Torrent extends \common\models\Torrent {

    public function getIsDownloaded () {
        /** @var TorrentDownload $downloads */
        $downloads = $this->getDownloads();
        if($downloads){
            foreach($downloads as $download){
                /** @var TorrentDownload $download */
                return true;
            }
        }
        return false;
    }

}