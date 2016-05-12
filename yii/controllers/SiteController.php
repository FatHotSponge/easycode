<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\Post;
use app\models\Category;

class SiteController extends Controller
{
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

    public function actionIndex()
    {
        $categories = Category::find()->all();
        $categoryId = Yii::$app->request->get('category_id', 0); // $_GET['category_id'];
        $tagId = Yii::$app->request->get('tag_id', 0);
        if ($categoryId) {
            $posts = Post::find()->where(['category_id' => $categoryId])->orderBy('date_creation DESC')->all();
        } elseif ($tagId) {
            $posts = Post::find()
                ->joinWith('tags')
                ->where(['tag.id' => $tagId])
                ->orderBy('date_creation DESC')
                ->all();
        } else {
            $posts = Post::find()->orderBy('date_creation DESC')->all();
        }
        return $this->render(
            'index',
            [
                'allPosts' => $posts,
                'categories' => $categories
            ]
        );
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

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

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionUser()
    {
        $model = new User();
        $userId = Yii::$app->request->get('user_id');
        $results = $model->findIdentity($userId);
        return $this->render(
            'user',
            array('userInfo' => $results)
        );
    }
}


