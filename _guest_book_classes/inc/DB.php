<?php 
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'Blackpearl99');
define('DB_NAME', 'study');

class DB implements IMessages{
    /**
     * @var экзмепляр соединения с базой данных
     */
    private $db;

    /**
     * соединение с базой данных
     */
    public function databaseConnection(){
		$this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
	}

    /**
     * сохраняет данные из формы в базу данных
     * @param array $msgData
     * @return bool
     */
    public function saveMessage(array $msgData){
		$ins = $this->db->prepare('INSERT INTO guest_book (userName, userEmail, messageText, date, userIP, userBrowser) VALUES (:userName, :userEmail, :messageText, :date, :userIP, :userBrowser)');
		if($ins->execute(array('userName' => $msgData['userName'], 'messageText' => $msgData['messageText'], 'userEmail' => $msgData['userEmail'], 'date'=>$msgData['date'], 'userIP' => $msgData['userIP'], 'userBrowser' => $msgData['userBrowser']))){
			return true;
		}
		else{
			return false;
		}
	}
	
   /**
    * Возвращает данные для данной страницы
    * @param $pageNum
    * @param $pageSize
    * @return array
    */
    public function getItemsForPage($pageNum, $pageSize = PAGE_SIZE){
        $num = ($pageNum - 1) * $pageSize;
		$mas = $this->db->query("SELECT userName AS '_userName', userEmail AS '_userEmail', messageText, date, userIP, userBrowser FROM guest_book ORDER BY date DESC LIMIT $num, $pageSize", PDO::FETCH_ASSOC)->fetchAll();
        return $mas;
    }

    /**
     * @return mixed
     */
    public function getAmountRecords(){
		$amount = $this->db->query("SELECT COUNT(*) AS count FROM guest_book", PDO::FETCH_ASSOC)->fetch();
		return $amount['count'];
	}
}