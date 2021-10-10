<?php
namespace Projet;

use mysqli;

require_once 'info.php';

function initSession(){
	if(!isset($_SESSION)){
		session_start();
	}
}

function initBD(){
	initSession();
	$user = "apache";
	$passwd = "apache";
	if(!isset($GLOBALS["GLOBAL_BD"])){
		$GLOBALS["GLOBAL_BD"] = new Bd("127.0.0.1", $GLOBALS["bd_user"], $GLOBALS["bd_passwd"], "ProjetS3");
	}
	return $GLOBALS["GLOBAL_BD"];
}

function getErrorFromSession($string){
	$str = NULL;
	if(isset($_SESSION[$string])){
		$str = $_SESSION[$string];
		unset($_SESSION[$string]);
	}
	return $str;
}

class Bd {
	private $host;
	private $user;
	private $passwd;
	private $bd;
	private $mysqli;
	private $pdo;

	function __construct($host, $user, $passwd, $bd){
		$this->host = $host;
		$this->user = $user;
		$this->passwd = $passwd;
		$this->bd = $bd;

		$this->connexion();
	}

	public function connexion(){
		$this->mysqli = new mysqli($this->host, $this->user, $this->passwd, $this->bd) or die("erreur de connexion");
	}

	public function deConnexion(){
		$this->mysqli->close();
	}

	public function query($sql){
		return $this->mysqli->query($sql);
	}

	public function modify_query($sql){
		$res = $this->mysqli->query($sql);
		$this->mysqli->commit();
		return (bool) ($res);
	}

	public function row_query($sql){
		return $this->mysqli->query($sql)->fetch_assoc();
	}

	public function count_query($sql){
		return (int) ($this->mysqli->query($sql)->fetch_row()[0]);
	}

	public function escape($string){
		return $this->mysqli->real_escape_string($string);
	}

	public function update_type_querry($what, $table, $data, $where, $type){
		$sql = "UPDATE {$table} SET {$what} = ? WHERE {$where}";

		$stmt = $this->mysqli->prepare($sql);

		$test = NULL;
		$stmt->bind_param($type, $test);
		$stmt->send_long_data(0, $data);

		$res = $stmt->execute();

		$stmt->close();
		return $res;
	}

	public function select_type_querry($what, $table, $where){
		$sql = "SELECT {$what} FROM {$table} WHERE {$where}";

		$stmt = $this->mysqli->prepare($sql);

		$res = $stmt->execute();

		if($res){
			$data = NULL;
			$stmt->store_result();
			$stmt->bind_result($data);
			$stmt->fetch();
			$stmt->close();
			return $data;
		}else{
			return NULL;
		}
	}

	public function getLastError(){
		return $this->mysqli->error;
	}
}
?>