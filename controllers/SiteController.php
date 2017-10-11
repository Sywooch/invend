<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\Stock;
use app\models\StockSearch;
use app\models\Transactions;
use app\models\TransactionsSearch;
use app\models\Customer;
use app\models\SalesOrder;
use app\models\SalesOrderReturn;
use yii\db\Expression;

class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
        $searchModel = new StockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModelT = new TransactionsSearch();
        $dataProviderT = $searchModelT->search(Yii::$app->request->queryParams);

        $totalCustomers = Customer::find()
                                    ->where('user_id=:user_id or user_id=:admin and active=:active', [':active' => 1,':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->count();

        $weeklyTotalCustomers = Customer::find()
                        ->where('user_id=:user_id or user_id=:admin and active =:active and time >= :start and time <= :end', [':active' => 1,':start' => new Expression('DATE_SUB(, INTERVAL 1 WEEK)'),':end' => new Expression('NOW()'),':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                        ->count();

        $highestCustomer = SalesOrder::find()
                                    ->from('sales_order t1')
                                    ->select(['t2.name as name','sum(total) as total'])
                                    ->where('t1.user_id=:user_id or t1.user_id=:admin', [':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->innerJoin('customer t2', 't2.id = t1.customer_id')
                                    ->groupBy(['t1.customer_id'])
                                    ->max('name');

        $highestSales = SalesOrder::find()
                                    ->select(['sum(total) as total'])
                                    ->where('user_id=:user_id or user_id=:admin', [':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->groupBy(['customer_id'])
                                    ->max('total');

        $highestSalesReturn = SalesOrderReturn::find()
                                    ->select(['sum(total) as total'])
                                    ->where('user_id=:user_id or user_id=:admin', [':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->groupBy(['customer_id'])
                                    ->max('total');

        $grandTotalSales = SalesOrder::find()
                                    ->where('user_id=:user_id or user_id=:admin', [':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->sum('total');

        $grandTotalSalesReturn = SalesOrderReturn::find()
                                    ->where('user_id=:user_id or user_id=:admin', [':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->sum('total');

        $monthlyTotalSales = SalesOrder::find()
                                    ->where('user_id=:user_id or user_id=:admin and time >= :start and time <= :end', [':start' => new Expression('DATE_SUB(, INTERVAL 1 MONTHLY)'),':end' => new Expression('NOW()'),':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->sum('total');

        $monthlyTotalSalesReturn = SalesOrderReturn::find()
                                    ->where('user_id=:user_id or user_id=:admin and time >= :start and time <= :end', [':start' => new Expression('DATE_SUB(, INTERVAL 1 MONTHLY)'),':end' => new Expression('NOW()'),':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->sum('total');

        $quarterlyTotalSales = SalesOrder::find()
                                    ->where('user_id=:user_id or user_id=:admin and time >= :start and time <= :end', [':start' => new Expression('DATE_SUB(, INTERVAL 1 QUARTER)'),':end' => new Expression('NOW()'),':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->sum('total');

        $quarterlyTotalSalesReturn = SalesOrderReturn::find()
                                    ->where('user_id=:user_id or user_id=:admin and time >= :start and time <= :end', [':start' => new Expression('DATE_SUB(, INTERVAL 1 QUARTER)'),':end' => new Expression('NOW()'),':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->sum('total');

        $weeklyTotalSales = SalesOrder::find()
                                    ->where('user_id=:user_id or user_id=:admin and time >= :start and time <= :end', [':start' => new Expression('DATE_SUB(, INTERVAL 1 WEEK)'),':end' => new Expression('NOW()'),':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->sum('total');

        $weeklyTotalSalesReturn = SalesOrderReturn::find()
                                    ->where('user_id=:user_id or user_id=:admin and time >= :start and time <= :end', [':start' => new Expression('DATE_SUB(, INTERVAL 1 WEEK)'),':end' => new Expression('NOW()'),':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->sum('total');

        $dailyTotalSales = SalesOrder::find()
                                    ->where('user_id=:user_id or user_id=:admin and time >= :start and time <= :end', [':start' => new Expression('DATE_SUB(, INTERVAL 1 DAY)'),':end' => new Expression('NOW()'),':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->sum('total');

        $dailyTotalSalesReturn = SalesOrderReturn::find()
                                    ->where('user_id=:user_id or user_id=:admin and time >= :start and time <= :end', [':start' => new Expression('DATE_SUB(, INTERVAL 1 DAY)'),':end' => new Expression('NOW()'),':user_id' => Yii::$app->user->getId(), ':admin' => 'admin'])
                                    ->sum('total');

        $grandSales = $grandTotalSales - $grandTotalSalesReturn;

        $monthlySales = $monthlyTotalSales - $monthlyTotalSalesReturn;
        $monthlySalesPercentage = ($monthlySales / $grandSales) * 100;

        $weeklySales = $weeklyTotalSales - $weeklyTotalSalesReturn;
        $weeklySalesPercentage = ($weeklySales / $grandSales) * 100;

        $quaterlySales = $quarterlyTotalSales - $quarterlyTotalSalesReturn;
        $quaterlySalesPercentage = ($quaterlySales / $grandSales) * 100;

        $dailySales = $dailyTotalSales - $dailyTotalSalesReturn;
        $dailySalesPercentage = ($dailySales / $grandSales) * 100;

        $highestSale  = $highestSales - $highestSalesReturn;
        $highestSalePercentage = ($highestSale / $grandSales) * 100;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelT' => $searchModelT,
            'dataProviderT' => $dataProviderT,

            'grandSales' => $grandSales,
            'monthlySales' => $monthlySales,
            'weeklySales' => $weeklySales,
            'quaterlySales' => $quaterlySales,
            'dailySales' => $dailySales,
            'highestSale' => $highestSale,
            'totalCustomers' => $totalCustomers,
            'weeklyTotalCustomers' => $weeklyTotalCustomers,
            'highestCustomer' => $highestCustomer,

            'dailySalesPercentage' => $dailySalesPercentage,
            'highestSalePercentage' => $highestSalePercentage,
            'weeklySalesPercentage' => $weeklySalesPercentage,
            'monthlySalesPercentage' => $monthlySalesPercentage,
            'quaterlySalesPercentage' => $quaterlySalesPercentage,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'empty';

        if (!Yii::$app->user->isGuest) {
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

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
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
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
