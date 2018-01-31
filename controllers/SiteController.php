<?php

namespace app\controllers;

use app\models\InquiryForm;
use app\models\Testimonial;
use Yii;
use app\models\ContactForm;

class SiteController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index', []);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->send(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionFaq()
    {
        return $this->render('faq');
    }

    public function actionHowItWorks()
    {
        return $this->render('how-it-works');
    }

    public function actionPrivacyPolicy()
    {
        return $this->render('privacy-policy');
    }

    public function actionTermsAndConditions()
    {
        return $this->render('terms-and-conditions');
    }

    public function actionBusinessSolutions()
    {
        $model = new InquiryForm();

        if ($model->load(Yii::$app->request->post()) && $model->send(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }

        return $this->render('business-solutions', ['model' => $model]);
    }

    public function actionTestimonials()
    {
        $model = Testimonial::find()->orderBy(['created' => SORT_DESC])->all();

        $this->showTestimonials = false;

        return $this->render('testimonials', ['model' => $model]);
    }
}
