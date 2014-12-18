<?php
class Page{

/**
 * @var $pag - пагинатор
 * @var $myList - сообщения для текущей страницы
 */
private $pag;
private $myList="";	

/**
 * Возвращает номер текущей страницы
 * @return int
 */
public static function getCurrentPage(){
    if(isset($_GET['num']) && intval($_GET['num']) != 0){
        $num = intval($_GET['num']);
    }
    else{
        $num = FIRST_PAGE;
    }
    return $num;
}

/**
 * Возвращает пагинатор
 * @param $countPages
 * @param $pageNum
 * @return string
 */
public static function navigatorPage($countPages, $pageNum){
    $num = "";
    for($i = 1;$i <= $countPages; $i++){
        if($i == $pageNum){
            $num .= "$i "; 
        }
        else {
            $num .= "<a href=?num=$i>$i </a>";
        }
    }
    return $num;
}


/**
 * Устанавливает сообщения для текущей страницы и пагинатор
 * @param $messageTpl
 * @param $examp
 */
public function getListAndPag($messageTpl, $examp){
    $Npage = self::getCurrentPage();
    $mas = $examp->getItemsForPage($Npage);
    $pages = ceil($examp->getAmountRecords()/PAGE_SIZE);
    foreach($mas as $a){
        $this->myList .= Template::processTemplace($messageTpl,$a);
    }
    $this->pag = self::navigatorPage($pages, $Npage);
}

/**
 * возвращает значение свойства myList
 * @return mixed
 */
public function getList(){
    return $this->myList;
}

/**
 * возвращает значение свойства pag
 * @return mixed
 */
public function getPag(){
    return $this->pag;
}
}