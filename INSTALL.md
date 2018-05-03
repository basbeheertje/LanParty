# Installation manual

## Database

## Configure Cronjobs
This application uses voodooo rocks yii2 cron [LINK](https://github.com/voodoo-rocks/yii2-cron) you need to add 
```
TaskRunner::checkAndRunTasks()
```

## YII2 Audit
You need to install Yii2 audit from [LINK](https://bedezign.github.io/yii2-audit/docs/installation/). Draai onderstaande migratie:
```
php yii migrate --migrationPath=@bedezign/yii2/audit/migrations
```