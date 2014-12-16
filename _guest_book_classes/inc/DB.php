﻿<?php 
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'Blackpearl99');
define('DB_NAME', 'study');

class DB{
	private $db;
	
	public function databaseConnection(){
		$this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
	}
	
	public function saveMessage(array $msgData){
		$ins = $this->db->prepare('INSERT INTO guest_book (userName, userEmail, messageText, date, userIP, userBrowser) VALUES (:userName, :userEmail, :messageText, :date, :userIP, :userBrowser)');
		if($ins->execute(array('userName' => $msgData['userName'], 'messageText' => $msgData['messageText'], 'userEmail' => $msgData['userEmail'], 'date'=>$msgData['date'], 'userIP' => $msgData['userIP'], 'userBrowser' => $msgData['userBrowser']))){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function getStorage(){
		$mas = $this->db->query("SELECT userName AS '_userName', userEmail AS '_userEmail', messageText, date, userIP, userBrowser FROM guest_book ORDER BY date DESC", PDO::FETCH_ASSOC)->fetchAll();
		return $mas;
	}
}