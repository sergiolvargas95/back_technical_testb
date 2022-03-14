<?php

namespace app\controllers;

use app\models\Shopping;
use app\models\ShoppingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShoppingController implements the CRUD actions for Shopping model.
 */
class ShoppingController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Shopping models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ShoppingSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Shopping model.
     * @param int $idShopping Id Shopping
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idShopping)
    {
        return $this->render('view', [
            'model' => $this->findModel($idShopping),
        ]);
    }

    /**
     * Creates a new Shopping model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Shopping();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idShopping' => $model->idShopping]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Shopping model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idShopping Id Shopping
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idShopping)
    {
        $model = $this->findModel($idShopping);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idShopping' => $model->idShopping]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Shopping model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idShopping Id Shopping
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idShopping)
    {
        $this->findModel($idShopping)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Shopping model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idShopping Id Shopping
     * @return Shopping the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idShopping)
    {
        if (($model = Shopping::findOne(['idShopping' => $idShopping])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
