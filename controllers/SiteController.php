<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Tank;
use app\models\Filling;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $tanks = Tank::getAll();
        $fillings = Filling::getAllInDescOrder();
        $filling = new Filling();

        if (
            $this->request->isPjax &&
            $this->request->isAjax &&
            $this->request->isPost &&
            $filling->load($this->request->post()) &&
            $filling->saveWithTankChange()
        ) {
            return $this->renderAjax('_form', [
                'partial' => true,
            ]);
        }

        return $this->render('index', [
            'tanks' => $tanks,
            'fillings' => $fillings,
            'filling' => $filling,
        ]);
    }

}
