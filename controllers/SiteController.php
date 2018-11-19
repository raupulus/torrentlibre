<?php

namespace app\controllers;

use app\helpers\Access;
use app\models\Accesos;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (Access::ipBloqueada()) {
            Yii::$app->getResponse()
                ->redirect(['site/iplocked'])
                ->send();
        }

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        // Cargo datos y registro si el login es correcto o no lo es
        if ($model->load(Yii::$app->request->post())) {
            if($model->login()) {
                Access::registrarAcceso();
                return $this->goBack();
            } else {
                Access::registrarErrorAcceso();
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays userlocked page.
     *
     * @return string
     */
    public function actionUserlocked()
    {
        return $this->render('userlocked');
    }

    /**
     * Displays iplocked page.
     *
     * @return string
     */
    public function actionIplocked()
    {
        return $this->render('iplocked');
    }

    /*
     * Displaus avisolegal page.
     *
     * @return string
     */
    public function actionAvisolegal()
    {
        return $this->render('avisolegal');
    }

    /**
     * Displays politicacookies page.
     *
     * @return string
     */
    public function actionPoliticacookies()
    {
        return $this->render('politicacookies');
    }

    /**
     * Displays politicaprivacidad page.
     *
     * @return string
     */
    public function actionPoliticaprivacidad()
    {
        return $this->render('politicaprivacidad');
    }

    /**
     * Displays Social Networks page.
     *
     * @return string
     */
    public function actionSocial()
    {
        return $this->render('redessociales');
    }
    public function actionEstadisticas()
    {
        return $this->render('administrar/estadisticas');
    }
}

