<?php

namespace console\controllers;

use Yii;
use webvimark\migrate\Controller;

/**
 * Class MigrateController
 * @package console\controllers
 */
class MigrateController extends Controller
{
    /**
     * @param string $migrationPath
     * @return array
     */
    protected function scanNewMigrations($migrationPath)
    {
        /** @var array $migrations */
        $migrations = [];
        if(!is_array($migrationPath)){
            $migrations = array_merge($migrations, parent::scanNewMigrations($migrationPath));
        }else if(is_array($migrationPath)){
            foreach($migrationPath as $path){
                $migrations = array_merge($migrations,parent::scanNewMigrations($path));
            }
        }

        return $migrations;
    }

    /**
     * Creates a new migration instance.
     * @param string $class the migration class name
     * @return \yii\db\MigrationInterface the migration instance
     */
    protected function createMigration($class)
    {
        $file = Yii::getAlias($class . '.php');
        require_once($file);

        $parts = explode('/m', $class);

        $className = 'm' . end($parts);

        $className = str_replace('migrations\/','',$className);
        $className = str_replace('migrations\\','',$className);
        $className = str_replace('migrations\\','',$className);

        return new $className();
    }
}