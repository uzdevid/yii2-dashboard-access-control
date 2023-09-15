<?php

namespace uzdevid\dashboard\access\control\controllers;

use uzdevid\dashboard\access\control\models\Action;
use uzdevid\dashboard\access\control\models\search\ActionSearch;
use uzdevid\dashboard\base\helpers\Url;
use uzdevid\dashboard\base\web\Controller;
use uzdevid\dashboard\widgets\ModalPage\ModalPage;
use uzdevid\dashboard\widgets\ModalPage\ModalPageOptions;
use uzdevid\dashboard\widgets\Toaster\Toaster;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ActionController implements the CRUD actions for Action model.
 */
class ActionController extends Controller {
    /**
     * @inheritDoc
     */
    public function behaviors(): array {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['GET'],
                'create' => ['GET', 'POST'],
                'view' => ['GET'],
                'update' => ['GET', 'POST'],
                'delete' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    public function init(): void {
        $this->viewPath = '@uzdevid/yii2-dashboard-access-control/views/action';

        parent::init();
    }

    /**
     * @return string
     */
    public function actionIndex(): string {
        $searchModel = new ActionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', compact('dataProvider', 'searchModel'));
    }

    /**
     * @param int $id ID
     *
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): Response|string {
        $model = $this->findModel($id);

        if (!$this->request->isAjax) {
            return $this->render('view', compact('model'));
        }

        return $this->asJson([
            'success' => true,
            'modal' => ModalPage::options(true, ModalPageOptions::SIZE_LG),
            'body' => [
                'title' => ModalPage::title(Yii::t('system.content', 'Action {path}', ['path' => $model->path]), '<i class="bi bi-link"></i>'),
                'view' => $this->renderAjax('modal/view', compact('model'))
            ]
        ]);
    }

    /**
     * @return Response|string
     */
    public function actionCreate(): Response|string {
        $model = new Action();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(Url::to(['index']));
            }
        } else {
            $model->loadDefaultValues();
        }

        if (!$this->request->isAjax) {
            return $this->render('create', compact('model'));
        }

        return $this->asJson([
            'success' => true,
            'modal' => ModalPage::options(true, ModalPageOptions::SIZE_LG),
            'toaster' => Toaster::success(),
            'body' => [
                'title' => ModalPage::title(Yii::t('system.content', 'Create action'), '<i class="bi bi-link"></i>'),
                'view' => $this->renderAjax('modal/update', ['model' => $model])
            ]
        ]);
    }

    /**
     * @param int $id ID
     *
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id): Response|string {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(Url::to(['index']));
        }

        if (!$this->request->isAjax) {
            return $this->render('update', compact('model'));
        }

        return $this->asJson([
            'success' => true,
            'modal' => ModalPage::options(true, ModalPageOptions::SIZE_LG),
            'toaster' => Toaster::success(),
            'body' => [
                'title' => ModalPage::title(Yii::t('system.content', 'Update action {path}', ['path' => $model->path]), '<i class="bi bi-link"></i>'),
                'view' => $this->renderAjax('modal/update', ['model' => $model])
            ]
        ]);
    }

    /**
     * @param int $id ID
     *
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $id): Response {
        $this->findModel($id)->delete();

        return $this->redirect(Url::to(['index']));
    }

    /**
     * @param int $id ID
     *
     * @return Action the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Action {
        if (($model = Action::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('system.message', 'The requested page does not exist.'));
    }
}
