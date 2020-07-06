<?php

namespace zikwall\vktv\controllers;

use yii\web\Controller;

class StaticController extends Controller
{
    public $layout = 'static';

    public function actionContentPostingRules()
    {
        return $this->render('content-posting-rules');
    }

    public function actionCopyright()
    {
        return $this->render('copyright');
    }

    public function actionTerms()
    {
        return $this->render('terms');
    }

    public function actionPrivacy()
    {
        return $this->render('privacy');
    }

    public function actionContacts()
    {
        return $this->render('contacts');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    // never

    public function actionNeverPrivacy()
    {
        return $this->render('never-privacy');
    }
}
