<?php
class Files implements IMessages{
    private $mas;
/**
 * Записывает информацию добавленную пользователем в файл
 * @param array $msgData
 * @return bool
 */
public function saveMessage(array $msgData){
    $file = fopen('data/db.txt', 'a');
    $str =  static::preparateStringToSave($msgData['userName']).'|'.static::preparateStringToSave($msgData['userEmail']).'|'.static::preparateStringToSave($msgData['messageText']).'|'.$msgData['date'].'|'.$msgData['userIP']."|".$msgData['userBrowser']."\n";
    $value = fwrite($file, $str);
    fclose($file);
    return $value;
}

/**
 * обрабатывает строку, заменяет переносы строки на
 * тег br и преобразует спец. символы в
 * в HTML-сущности
 * @param $str
 * @return mixed|string
 */
public static function preparateStringToSave($str){
    $str = str_replace("\r\n", "<br>", $str);
    $str = htmlspecialchars($str);
    return $str;
}

/**
 * Возвращает отсортированный  массив по дате со всем данными
 * @return array
 */
public  function getStorage(){
    $arr = file('data/db.txt', FILE_IGNORE_NEW_LINES);
    if(!empty($arr)){
        foreach($arr as $row) {
            $tmp = explode('|', $row);
            $ret[] = array('_userName'=>$tmp[0],'_userEmail'=>$tmp[1],'messageText'=>$tmp[2],'date'=>$tmp[3],'userIP'=>$tmp[4],'userBrowser'=>$tmp[5]);
        }
	    foreach ($ret as $key => $row) {
            $date[$key]  = $row['date'];
        }
        array_multisort($date, SORT_DESC, $ret);
        $this->mas = $ret;
		return($this->mas);
	}
    else return false;
}

    /**
     * @param $pageNum
     * @param $pageSize
     * @return array
     */
public function getItemsForPage($pageNum, $pageSize = PAGE_SIZE){
    $array_for_page = array_slice($this->mas, ($pageNum - 1) * $pageSize, $pageSize);
    return $array_for_page;
}

    /**
     * @return int
     */
public function getAmountRecords(){
	return count($this->mas);
}
}