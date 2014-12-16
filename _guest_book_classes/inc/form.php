<?php
class Form{
/**
 * Проверяет была ли отправлена форма
 * @return bool
 */
public  static function isFormSubmitted(){
    return (isset($_POST) AND !empty($_POST));
}

/**
 * Возвращает массив данных ассоциированных с формой и
 * добавляет в него IP пользователя, дату добавления сообщения,
 * браузер использованный пользователем, устанавливает знае
 * @return array (userName, userEmail, messageText, captcha, userIP, date, 
 * userBrowser)
 */
public static function getFormData(){
    $arr = array();
    $arr['userName'] = isset($_POST['userName'])? trim($_POST['userName']): "";
    $arr['userEmail'] = isset($_POST['userEmail'])? trim($_POST['userEmail']): "";
    $arr['messageText'] = isset($_POST['messageText'])? trim($_POST['messageText']): "";
    $arr['captcha'] = isset($_POST['captcha'])? trim($_POST['captcha']): "";
    $arr['userIP'] = $_SERVER['REMOTE_ADDR'];
    $arr['date'] = date('Y-m-d H:i:s');
    $arr['userBrowser'] = self::getUserBrowser();
    return $arr;
}

/**
 * Проверяет правильность введенной капчи
 * @param $answ
 * @return bool
 */
public static function checkCaptchaAnswer($answ){
    $rightAnsw = isset($_SESSION['captcha'])? $_SESSION['captcha']: '';
    return $answ == $rightAnsw;
}

/**
 * Проверяет валидность заполлнения полей формы
 * @param array $formData - массив с данными формы
 * @return array|bool - TRUE если форма валидка, массив со списком ошибок, если нет
 */
public static function isFormVaild(array $formData){
    $resp = true;
    $errors = array();

    if(preg_match('/^([A-Za-z]{3,})(\s[A-Za-z]{3,})*/', $formData['userName']) == 0){
        $resp = false;
        $errors['userName'] = 'Проверьте ввод имени';
    }

    if(preg_match('/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/', $formData['userEmail']) == 0){
        $resp = false;
        $errors['userEmail'] = 'Проверьте ввод email';
    }


    if(strlen($formData['messageText']) < 50){
        $resp = false;
        $errors['messageText'] = 'Сообщение должно содержать от 50 символов';
    }

    if(!Form::checkCaptchaAnswer($formData['captcha'])){
        $resp = false;
        $errors['captcha'] = 'Неправильный ответ';
    }
    if(!$resp){
        return $errors;
    } else {
        return $resp;
    }
}

/**
 * Генерирует капчу. Возвращает вопрос. Ответ устанавливает в сессию
 * @return string
 */
public static function generateCaptcha(){
    $answ = rand(1, 20);
    $marker = rand(0,1)? '+': '-';

    $b = rand(1,$answ);
    switch($marker){
        case '+':
            $a = $answ - $b;
            break;
        case '-':
            $a = $answ + $b;
            break;
    }

    $_SESSION['captcha'] = $answ;
    return $a.' '.$marker.' '.$b;
}

/**
 * Возвращает браузер, который использует пользователь
 * @return string
 */
public static function getUserBrowser(){
  $user_agent = $_SERVER["HTTP_USER_AGENT"];
  if (strpos($user_agent, "Firefox") !== false){ 
     $browser = "Firefox";
  }
  else if (strpos($user_agent, "Opera") !== false) {
     $browser = "Opera";
  }
  else if (strpos($user_agent, "Chrome") !== false) {
     $browser = "Chrome";
  }
  else if (strpos($user_agent, "MSIE") !== false) {
     $browser = "Internet Explorer";
  }
  else if (strpos($user_agent, "Safari") !== false) {
     $browser = "Safari";
  }
  else {
	  $browser = "Неизвестный";
  }
  return $browser;
}

/**
 * устанавливает значене $_SESSION['userName'] и
 * $_SESSION['userEmail']
 * @param array $msgData
 */
public static function setup_session(array $msgData){
    $_SESSION['userName'] = $msgData['userName'];
    $_SESSION['userEmail'] = $msgData['userEmail'];
}
}
