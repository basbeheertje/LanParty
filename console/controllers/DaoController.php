<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\BaseFileHelper;

/**
 * Class DaoController
 * @package console\controllers
 */
class DaoController extends Controller {

    public $message;

    public function init () {
        parent::init();
    }

    /**
     * @todo describe
     * @param string $actionId
     * @return array
     */
    public function options ($actionId) {
        return [
            'create',
            'update',
            'help'
        ];
    }

    /**
     * @todo describe
     * @return array
     */
    public function optionAliases () {
        return [
            'c' => 'create',
            'u' => 'update',
            'h' => 'help'
        ];
    }

    /**
     * @todo describe
     */
    public function actionIndex () {
        echo $this->message . "\n";
    }

    /**
     * @todo describe
     */
    public function actionCreate () {
        if (!is_dir(Yii::getAlias('@console/dao'))) {
            BaseFileHelper::createDirectory(Yii::getAlias('@common/dao'), 0755, true);
        }
        echo "Creating DAO\r\n";
        // Get all tables from database
        $connection = Yii::$app->db;//get connection
        $dbSchema = $connection->schema;
        $tables = $dbSchema->getTableNames();//returns array of tbl schema's
        foreach ($tables as $tbl) {
            /** @var array $daoNameArray */
            $daoNameArray = explode('_', $tbl);
            /** @var string $daoName */
            $daoName = '';
            foreach ($daoNameArray as $daoNameValue) {
                $daoName .= ucfirst($daoNameValue);
            }
            //$daoName .= 'DAO';
            if (file_exists(Yii::getAlias('@common/dao/' . $daoName . '.php'))) {
                echo $tbl . " [exists]\r\n";
            } else {
                $command = 'php yii gii/model --tableName=' . $tbl . ' --modelClass=' . $daoName . ' --enableI18N=1 --interactive=0 --ns=common\\dao --overwrite=0 --queryNs=common\\dao';
                exec($command);
                echo $tbl . " [created]\r\n";
            }
        }
    }

    /**
     * @todo describe
     */
    public function actionUpdate () {
        if (!is_dir(Yii::getAlias('@console/dao'))) {
            BaseFileHelper::createDirectory(Yii::getAlias('@common/dao'), 0755, true);
        }
        echo "Updating DAO\r\n";
        // Ophalen van alle tabellen in de database
        $connection = Yii::$app->db;//get connection
        $dbSchema = $connection->schema;
        $tables = $dbSchema->getTableNames();//returns array of tbl schema's
        foreach ($tables as $tbl) {
            /** @var array $daoNameArray */
            $daoNameArray = explode('_', $tbl);
            /** @var string $daoName */
            $daoName = '';
            foreach ($daoNameArray as $daoNameValue) {
                $daoName .= ucfirst($daoNameValue);
            }
            //$daoName .= 'DAO';
            /** @var boolean $exists */
            $exists = false;

            if (file_exists(Yii::getAlias('@common/dao/' . $daoName . '.php'))) {
                $exists = true;
            }

            $command = 'php yii gii/model --tableName=' . $tbl . ' --modelClass=' . $daoName . ' --enableI18N=1 --interactive=0 --ns=common\\dao --overwrite=1 --queryNs=common\\dao';
            exec($command);

            if ($exists) {
                echo $tbl . " [exists]\r\n";
            } else {
                echo $tbl . " [created]\r\n";
            }

        }
    }

    /**
     * @todo describe
     */
    public function actionHelp () {
        echo 'Help';
    }

}
