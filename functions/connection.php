<?php if(!defined("DIR")){ exit(); }
/*
** pdo connect to database
*/
class connection
{
	public $HANDLER;

	function __construct(){

	}

	public function conn($c){
		try{
			$host = 'mysql:host='.$c['database.hostname'].';dbname='.$c['database.name'].";charset=utf8"; 
			$this->HANDLER = new PDO($host,$c['database.username'],$c['database.password']); 
			$this->HANDLER->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$this->HANDLER->exec("set names utf8"); 
		}catch(PDOException $e){
			// $e->getMessage();
			die("Sorry, Database connection problem.."); 
		}
		return $this->HANDLER; 
	}

	function __destruct(){
		
	}
}