<?php

namespace app\controllers;

class DashboardController extends \yii\web\Controller
{
    public function actionD1()
    {
        return $this->render('dashboard_1');
    }

    public function actionD2()
    {
        return $this->render('dashboard_2');
    }

    public function actionD3()
    {
        return $this->render('dashboard_3');
    }

    public function actionD4()
    {
        return $this->render('dashboard_4');
    }

    public function actionD5()
    {
        return $this->render('dashboard_5');
    }
}
