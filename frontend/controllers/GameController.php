<?php

namespace frontend\controllers;

use common\dao\GamePlayer;
use frontend\models\GameForm;
use Yii;
use frontend\models\Game;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Expression;
use frontend\models\TorrentForm;
use frontend\models\GameTorrent;
use frontend\models\GameKey;
use yii\helpers\Url;

/**
 * GameController implements the CRUD actions for Game model.
 */
class GameController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors () {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'create' => ['POST', 'GET'],
                    'addtorrent' => ['POST', 'GET'],
                    'disable' => ['GET']
                ],
            ],
        ];
    }

    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionIndex () {
        $dataProvider = new ActiveDataProvider([
            'query' => Game::find(),
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Game model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView ($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Disables a game
     * @param $id
     * @return \yii\web\Response
     * @throws Exception
     */
    public function actionDisable ($id) {
        /** @var Game $model */
        $model = Game::find()->where(
            [
                'id' => $id
            ]
        )->one();
        if ($model) {
            $model->status = Game::STATUS_INACTIVE;
            if (!$model->save()) {
                throw new Exception(Yii::t('frontend', 'Unable to save model!') . ' ' . VarDumper::dumpAsString($model->getErrors()));
            }

            return $this->redirect(['index']);

        }
        throw new Exception(Yii::t('frontend', 'Unable to find game by id') . ' ' . $id);
    }

    /**
     * Creates a new Game model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws Exception
     */
    public function actionCreate () {
        /** @var GameForm $model */
        $model = new GameForm();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->created_by = Yii::$app->user->id;
            $model->created_at = time();
            $model->updated_at = time();
            $model->profileFile = UploadedFile::getInstance($model, 'profileFile');
            $model->avatarFile = UploadedFile::getInstance($model, 'avatarFile');

            if (!$model->upload()) {
                throw new Exception(Yii::t('frontend', 'Unable to upload files!') . ' ' . VarDumper::dumpAsString($model->getErrors()));
            }

            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                throw new Exception(Yii::t('frontend', 'Unable to save Game!') . ' ' . VarDumper::dumpAsString($model->getErrors()));
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return bool|string
     * @throws Exception
     */
    public function actionAddtorrent ($id) {
        /** @var TorrentForm $model */
        $model = new TorrentForm();

        if (Yii::$app->request->isPost) {
            $model->created_by = Yii::$app->user->id;
            $model->created_at = time();
            $model->updated_at = time();
            $model->torrentFile = UploadedFile::getInstance($model, 'torrentFile');
            if (!$model->upload()) {
                throw new Exception(Yii::t('frontend', 'Unable to upload files!') . ' ' . VarDumper::dumpAsString($model->getErrors()));
            }
            if (!$model->save()) {
                throw new Exception(Yii::t('frontend', 'Unable to save torrent!') . ' ' . VarDumper::dumpAsString($model->getErrors()));
            }
            /** @var GameTorrent $gameTorrent */
            $gameTorrent = new GameTorrent();
            $gameTorrent->game_id = $id;
            $gameTorrent->torrent_id = $model->id;
            $gameTorrent->created_by = Yii::$app->user->id;
            $gameTorrent->created_at = time();
            $gameTorrent->updated_at = time();
            if (!$gameTorrent->save()) {
                throw new Exception(Yii::t('frontend', 'Unable to save GameTorrent!') . ' ' . VarDumper::dumpAsString($gameTorrent->getErrors()));
            }

            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('addtorrent', ['model' => $model]);
    }

    /**
     * @param $id
     * @return bool|string
     * @throws Exception
     */
    public function actionAddkey ($id) {
        /** @var GameKey $model */
        $model = new GameKey();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->game_id = $id;
            $model->created_by = Yii::$app->user->id;
            $model->created_at = time();
            $model->updated_at = time();
            if (!$model->save()) {
                throw new Exception(Yii::t('frontend', 'Unable to save GameKey!') . ' ' . VarDumper::dumpAsString($model->getErrors()));
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('addkey', ['model' => $model]);
    }

    public function adctionSetPlaying($id){
        /** @var Game $model */
        $model = Game::find()->where(
            [
                'id' => $id
            ]
        )->one();
        if ($model) {
            GamePlayer::setAllToPlayed();
            /** @var GamePlayer $gameplayer */
            $gameplayer = new GamePlayer();
            $gameplayer->user_id = Yii::$app->user->identity->id;
            $gameplayer->game_id = $model->id;
            $gameplayer->status = GamePlayer::STATUS_PLAYING;
            $gameplayer->created_at = time();
            $gameplayer->updated_at = time();
            if(!$gameplayer->save()){
                throw new Exception(Yii::t('frontend','Unable to save playing!') . " " . $gameplayer->getErrors());
            }
            $this->goBack();
        }
        throw new Exception(Yii::t('frontend','Unable to find game!'));
    }

    /**
     * Updates an existing Game model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate ($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Game model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete ($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Game model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Game the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel ($id) {
        if (($model = Game::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
