<?php

namespace frontend\controllers;

use yii\web\UploadedFile;
use common\models\AvatarForm;
use Yii;
use frontend\models\User;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;

/**
 * ProfileController implements the CRUD actions for Game model.
 */
class ProfileController extends Controller
{

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @todo descirbe
     * @return bool|string
     * @throws Exception
     */
    public function actionAvatar()
    {
        /** @var AvatarForm $model */
        $model = new AvatarForm();

        if (Yii::$app->request->isPost) {
            $model = $model->find()->where(['id' => Yii::$app->user->id])->one();
            if (!$model) {
                throw new Exception(Yii::t('frontend', 'Unable to find user for avatar update!'));
            }
            $model->avatarFile = UploadedFile::getInstance($model, 'avatarFile');
            if (!$model->upload()) {
                throw new Exception(Yii::t('frontend', 'Unable to upload files!') . ' ' . VarDumper::dumpAsString($model->getErrors()));
            }
            if (!$model->save()) {
                throw new Exception(Yii::t('frontend', 'Unable to save Avatar!') . ' ' . VarDumper::dumpAsString($model->getErrors()));
            }
            $this->goHome();
            return true;
        }

        return $this->render('avatar', ['model' => $model]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
