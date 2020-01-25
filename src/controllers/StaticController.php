<?php

namespace zikwall\vktv\controllers;


class StaticController extends BaseController
{
    public $layout = null;

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
}
