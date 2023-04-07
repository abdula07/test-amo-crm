<?php

namespace application\controllers;
use application\components\AmoCrm;
use application\core\Controller;
use application\models\forms\DealCreateForm;
use application\components\Config;

class ControllerMain extends Controller
{

    function action_index()
    {
        $request_method = strtoupper($_SERVER['REQUEST_METHOD']);

        if ($request_method === 'GET') {
            $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        }
        $deal_create_form = new DealCreateForm();
        if ($request_method === 'POST' && $deal_create_form->load($_POST)) {
            $amo_crm = new AmoCrm(Config::get());
            $result = $amo_crm->addDeal(
                $deal_create_form->name,
                $deal_create_form->price,
                $deal_create_form->phone,
                $deal_create_form->email
            );
            if (!isset($result[0]['id'])) {
                return $this->view->render('not_successful_deal_creation_view.php', 'template_view.php');;
            }
            return $this->view->render('success_deal_creation_view.php', 'template_view.php');
        }

        return $this->view->render(
            'main_view.php',
            'template_view.php',
            ['errors' => $deal_create_form->errors]
        );
    }
}