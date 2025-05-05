<?php

namespace app\controllers\api_v0;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class ApiController extends Controller
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
    
    
    public function beforeAction($action) {
        $modelClass = '\app\models\\'. strtoupper(substr($action->id, 0, 1)) . substr($action->id, 1);
        $type = substr($action->controller->id, 7);

        switch ($type) {
            case 'select':
                // $modelClass::find()
                //     ->select(['id' => 'id', 'text' => 'concat()'])
                break;
            case 'unique':
                break;
            default:
                break;
        }

        echo '<pre>';
        print_r([$modelClass, $type, $action->id, $action]);
        exit;
        
        return $action;
    }
}
