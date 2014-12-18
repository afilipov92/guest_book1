<?php
define('PAGE_SIZE', 6);
define('FIRST_PAGE', 1);
require_once('inc/inc.php');

$db = new DB();
$templ = new Template();
$objPage = new Page();

$pageTpl = Template::getTemplate('page');
$messageTpl = Template::getTemplate('message');
$templ->setHtml(Template::getTemplate('form'));

$msg = "";

$db->databaseConnection();
$formData = Form::getFormData();

if(Form::isFormSubmitted()){
    $validateFormResult = Form::isFormVaild($formData);
    Form::setup_session($formData);
    if($validateFormResult!== true) {
        $templ->setHtml($templ->processTemplateErrorOutput($validateFormResult));
    } else {
        if($db->saveMessage($formData)){
            header('Location: '.$_SERVER['REQUEST_URI']);
            die;
        } else {
            $msg = 'Ошибка сохранения';
        }
    }
}

$templ->setHtml(Template::processTemplace($templ->getHtml(), $formData));
$templ->setHtml(Template::processTemplace($templ->getHtml(), array('CAPTCHA' => Form::generateCaptcha())));

$objPage->getListAndPag($messageTpl,$db);

$page = Template::processTemplace($pageTpl, array(
    'FORM' => $templ->getHtml(),
    'MSG' => $msg,
    'LIST' => $objPage->getList(),
    'PAG' => $objPage->getPag()
));
echo $page;

