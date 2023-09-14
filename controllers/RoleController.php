<?php

namespace uzdevid\dashboard\access\control\controllers;

use uzdevid\dashboard\access\control\filters\DashboardAccessControl;
use uzdevid\dashboard\access\control\models\Action;
use uzdevid\dashboard\access\control\models\Role;
use uzdevid\dashboard\access\control\models\service\ActionService;
use uzdevid\dashboard\base\helpers\Url;
use uzdevid\dashboard\base\web\Controller;
use uzdevid\dashboard\widgets\ModalPage\ModalPage;
use uzdevid\dashboard\widgets\ModalPage\ModalPageOptions;
use uzdevid\dashboard\widgets\Toaster\Toaster;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RoleController extends Controller {
    /**
     * @inheritDoc
     */
    public function behaviors(): array {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        $behaviors['AccessControl'] = [
            'class' => \uzdevid\abac\AccessControl::class
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['GET'],
                'create' => ['GET', 'POST'],
                'update' => ['GET', 'POST'],
                'view' => ['GET'],
                'delete' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    public function init() {
        $this->viewPath = '@uzdevid/yii2-dashboard-access-control/views/role';

        parent::init();
    }

    /**
     * @return string
     */
    public function actionIndex(): string {
        $dataProvider = new ActiveDataProvider([
            'query' => Role::find()
        ]);

        return $this->render('index', compact('dataProvider'));
    }

    /**
     * @param int $id ID
     *
     * @return array|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): array|string {
        $model = $this->findModel($id);
        if ($this->request->isAjax) {
            $modal = ModalPage::options(true, ModalPageOptions::SIZE_SM);
            $view = $this->renderAjax('modal/view', compact('model'));

            return [
                'success' => true,
                'modal' => $modal,
                'body' => [
                    'title' => ModalPage::title($model->translatedName, '<i class="bi bi-list-check"></i>'),
                    'view' => $view
                ]
            ];
        }

        return $this->render('view', compact('model'));
    }

    /**
     * @return Response|array|string
     */
    public function actionCreate(): Response|array|string {
        $model = new Role();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(Url::to(['index']));
            }
        } else {
            $model->loadDefaultValues();
        }

        if ($this->request->isAjax) {
            $modal = ModalPage::options(true, ModalPageOptions::SIZE_SM);
            $view = $this->renderAjax('modal/create', compact('model'));

            return [
                'success' => true,
                'modal' => $modal,
                'body' => [
                    'title' => ModalPage::title(Yii::t('system.content', 'Create Role'), '<i class="bi bi-list-check"></i>'),
                    'view' => $view
                ]
            ];
        }

        return $this->render('create', compact('model'));
    }

    /**
     * @param int $id ID
     *
     * @return  Response|array|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id): Response|array|string {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(Url::to(['index']));
        }

        if ($this->request->isAjax) {
            $modal = ModalPage::options(true, ModalPageOptions::SIZE_SM);
            $view = $this->renderAjax('modal/create', compact('model'));

            return [
                'success' => true,
                'modal' => $modal,
                'toaster' => Toaster::success(),
                'body' => [
                    'title' => ModalPage::title(Yii::t('system.content', 'Update role'), '<i class="bi bi-list-check"></i>'),
                    'view' => $view
                ]
            ];
        }

        return $this->render('update', compact('model'));
    }

    /**
     * @param int $id
     *
     * @return array|string
     * @throws NotFoundHttpException
     */
    public function actionPermissions(int $id): array|string {
        $model = $this->findModel($id);

        $actions = Action::find()->orderBy(['action' => SORT_ASC])->all();

        if (!$this->request->isAjax) {
            return $this->render('permissions', compact('model', 'actions'));
        }

        return [
            'success' => true,
            'modal' => ModalPage::options(true, ModalPageOptions::SIZE_FULLSCREEN),
            'body' => [
                'title' => ModalPage::title($model->name, '<i class="bi bi-shield"></i>'),
                'view' => $this->renderAjax('modal/permissions', compact('model', 'actions'))
            ]
        ];
    }

    /**
     * @param int $id ID
     *
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException
     */
    public function actionDelete(int $id): Response {
        $this->findModel($id)->delete();

        return $this->redirect(Url::to(['index']));
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionSavePermission(): array {
        
    }

    /**
     * @param int $id ID
     *
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Role {
        if (($model = Role::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('system.message', 'The requested page does not exist.'));
    }
}
