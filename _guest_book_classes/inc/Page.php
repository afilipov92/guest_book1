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
 * Возвращает данные для данной страницы
 * @param $pageNum
 * @param $array
 * @param $pageSize
 * @return array
 */
public static function getItemsForPage($pageNum, $array, $pageSize = PAGE_SIZE){
   $array_for_page = array_slice($array, ($pageNum - 1) * $pageSize, $pageSize);
   return $array_for_page;
}

/**
 * Устанавливает сообщения для текущей страницы и пагинатор
 * @param $messageTpl
 */
public function getListAndPag($messageTpl, array $arr){
    $Npage = self::getCurrentPage();
    if($arr !== false){
        $mas = static::getItemsForPage($Npage, $arr);
		foreach($mas as $a){
         $this->myList .= Template::processTemplace($messageTpl,$a);
		}
    }
    $pages = ceil(count($arr)/PAGE_SIZE);
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