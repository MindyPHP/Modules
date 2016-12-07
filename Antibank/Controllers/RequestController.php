<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 15/09/14.09.2014 15:13
 */

namespace Modules\Antibank\Controllers;

use Mindy\Base\Mindy;
use Mindy\Helper\Json;
use Modules\Antibank\Forms\ConsultForm;
use Modules\Antibank\Forms\ContactForm;
use Modules\Antibank\Forms\MoreForm;
use Modules\Antibank\Forms\PartnerForm;
use Modules\Antibank\Forms\QuestionAlternateForm;
use Modules\Antibank\Forms\QuestionForm;
use Modules\Antibank\Forms\SurveyForm;
use Modules\Core\Controllers\CoreController;

class RequestController extends CoreController
{
    public function actionSurvey()
    {
        $this->process(new SurveyForm(), 'antibank/request.html', [
            'fields' => ['username', 'phone', 'description'],
            'button' => 'Отправить анкету',
            'action' => Mindy::app()->urlManager->reverse('antibank.survey'),
            'title' => 'Заполнить анкету'
        ]);
    }

    public function actionContact()
    {
        $this->process(new ContactForm(), 'antibank/request.html', [
            'fields' => ['username', 'phone', 'email', 'file'],
            'button' => 'Отправить',
            'action' => Mindy::app()->urlManager->reverse('antibank.contact'),
            'title' => 'Связаться с нами',
            'class' => 'contact-us'
        ]);
    }

    public function actionConsult()
    {
        $this->process(new ConsultForm(), 'antibank/request.html', [
            'fields' => ['username', 'phone', 'email'],
            'button' => 'Подать заявку на консультацию',
            'action' => Mindy::app()->urlManager->reverse('antibank.consult'),
            'title' => 'Подать заявку'
        ]);
    }

    public function actionConsultalt()
    {
        $this->process(new ConsultForm(), 'antibank/request.html', [
            'fields' => ['username', 'phone', 'email'],
            'button' => 'Получить консультацию',
            'action' => Mindy::app()->urlManager->reverse('antibank.consult_alt'),
            'title' => 'Получить консультацию'
        ]);
    }

    public function actionQuestion()
    {
        $this->process(new QuestionForm(), 'antibank/request.html', [
            'fields' => ['username', 'phone', 'email', 'text'],
            'button' => 'Задать вопрос',
            'action' => Mindy::app()->urlManager->reverse('antibank.question'),
            'title' => 'Задать вопрос'
        ]);
    }

    public function actionQuestionalter()
    {
        $this->process(new QuestionAlternateForm(), 'antibank/request.html', [
            'fields' => ['username', 'phone', 'email', 'text'],
            'button' => 'Задать вопрос',
            'action' => Mindy::app()->urlManager->reverse('antibank.question_alter'),
            'title' => 'Задать вопрос'
        ]);
    }

    public function actionPartner()
    {
        $form = new MoreForm();
        $this->process($form, 'antibank/request.html', [
            'fields' => ['city', 'username', 'phone', 'email', 'question'],
            'button' => 'Отправить',
            'action' => Mindy::app()->urlManager->reverse('antibank.partner'),
            'title' => 'Узнать о сотрудничестве'
        ]);
    }

    public function actionOffer()
    {
        $form = new PartnerForm();
        $this->process($form, 'antibank/request.html', [
            'fields' => ['city', 'username', 'phone', 'email'],
            'button' => 'Получить коммерческое предложение',
            'action' => Mindy::app()->urlManager->reverse('antibank.offer'),
            'title' => 'Получить коммерческое предложение',
            'info' => 'Для загрузки коммерческого предложения заполните поля ниже'
        ]);
    }

    public function process($form, $template = 'antibank/request.html', $data)
    {
        $this->ajaxValidation($form);
        if($this->r->isPost) {
            if (!empty($_POST)) {
                $form->setAttributes($_POST);
            }

            if (!empty($_FILES)) {
                $form->setAttributes($_FILES);
            }

            if ($form->isValid() && $form->save()){
                if ($this->r->isAjax) {
                    echo $this->render('antibank/success.html');
                    Mindy::app()->end();
                }else{
                    Mindy::app()->flash->success("Сообщение успешно отправлено");
                    if (isset($_GET['next'])) {
                        $this->redirect($_GET['next']);
                    }else{
                        $this->redirect('/');
                    }
                }
            }
        }

        echo $this->render($template, array_merge($data, [
            'form' => $form
        ]));
    }

    public function ajaxValidation($form)
    {
        if($this->r->isPost && isset($_POST['ajax_validation'])) {
            $form->setAttributes($_POST)->isValid();
            echo Json::encode($form->getErrors());
            Mindy::app()->end();
        }
    }
}
