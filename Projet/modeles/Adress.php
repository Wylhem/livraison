<?php
namespace Projet;

require_once 'Bd.php';

/*
 * Validation:
 * error_validate_adress
 *
 */
class Adress {
	private $bd;
	private $idAdress;
	private $adress;
	private $city;
	private $CP;
	private $isMain;
	private $idUser;

	function __construct(){
		$this->bd = initBD();
	}

	/*
	 * Main functions
	 */
	public function updateMainAdress($adress, $city, $CP){
		$adress = $this->bd->escape($adress);
		$city = $this->bd->escape($city);
		$CP = $this->bd->escape($CP);

		if($this->getIdAdress() !== NULL){
			if($adress != $this->getAdress()){
				$this->setAdress($adress);
			}

			if($CP != $this->getCP()){
				$this->setCP($CP);
			}

			if($city != $this->getCity()){
				$this->setCity($city);
			}
		}else{
			if(empty($adress) || empty($CP) || empty($city)){
				$_SESSION["error_validate_adress"] = "Cette Adresse n'est pas compléte";
			}else{
				$this->_populateWithNewAdress($adress, $city, $CP, $this->idUser);
				$this->_setMain(1);
			}
		}
	}

	/*
	 * Fetch infos
	 */
	private function fetchInfo(){
		$info = $this->bd->row_query("SELECT idAdress, adress, CP, city, isMain, idUser FROM ProjetS3.Adress WHERE idAdress='{$this->idAdress}'");
		$res = ($info !== NULL);
		if($res){
			$this->idAdress = (int) $info["idAdress"];
			$this->adress = $info["adress"];
			$this->CP = (int) $info["CP"];
			$this->city = $info["city"];
			$this->isMain = (int) $info["isMain"];
			$this->idUser = (int) $info["idUser"];
		}
		return $res;
	}

	/*
	 * Public populators
	 */
	public function populateWithId($idAdress){
		$idAdress = $this->bd->escape($idAdress);
		return $this->_populateWithId($idAdress);
	}

	public function populateWithUser($idUser){
		$idUser = $this->bd->escape($idUser);
		return $this->_populateWithUser($idUser);
	}

	public function populateWithNewAdress($adress, $city, $CP, $idUser){
		$adress = $this->bd->escape($adress);
		$city = $this->bd->escape($city);
		$CP = $this->bd->escape($CP);
		$idUser = $this->bd->escape($idUser);

		return $this->_populateWithNewAdress($adress, $city, $CP, $idUser);
	}

	/*
	 * Private populators
	 */
	private function _populateWithId($id){
		$this->idAdress = $id;
		return $this->fetchInfo();
	}

	private function _populateWithUser($idUser){
		$this->idUser = $idUser;
		$row = $this->bd->row_query("SELECT idAdress FROM ProjetS3.Adress WHERE idUser='{$idUser}' AND isMain=1");
		if($row !== NULL){
			$this->idAdress = $row["idAdress"];
			$res = ($this->idAdress !== NULL);
			return $res && $this->fetchInfo();
		}else{
			return FALSE;
		}
	}

	private function _populateWithNewAdress($adress, $city, $CP, $idUser){
		if($this->bd->modify_query("INSERT INTO ProjetS3.Adress (adress, city, CP, idUser) VALUES('{$adress}', '{$city}', {$CP}, {$idUser})")){
			$this->idAdress = $this->bd->row_query("SELECT idAdress FROM ProjetS3.Adress WHERE idUser={$idUser} ORDER BY idAdress DESC LIMIT 1")["idAdress"];
			$res = ($this->idAdress !== NULL);
			return $res && $this->fetchInfo();
		}
		return FALSE;
	}

	/*
	 * verify functions
	 * verifier la validite des arguemnts (revient a comparer la valeur passer en parametre avec la valeur de l'obect la plus part du temps)
	 */

	/*
	 * validate functions
	 * verifie la validiter des arguments passer en parametre (peuvent ils etres set dans la BD)
	 */

	/*
	 * getter
	 */
	public function getIdAdress(){
		return $this->idAdress;
	}

	public function getAdress(){
		return $this->adress;
	}

	public function getCity(){
		return $this->city;
	}

	public function getCP(){
		return $this->CP;
	}

	public function isMain(){
		return $this->isMain;
	}

	public function getUser(){
		return $this->idUser;
	}

	/*
	 * Public setters
	 */
	public function setAdress($adress){
		$adress = $this->bd->escape($adress);
		return $this->_setAdress($adress);
	}

	public function setCP($CP){
		$CP = $this->bd->escape($CP);
		return $this->_setCP($CP);
	}

	public function setCity($city){
		$city = $this->bd->escape($city);
		return $this->_setCity($city);
	}

	public function setMain($isMain){
		$isMain = $this->bd->escape($isMain);
		return $this->_setMain($isMain);
	}

	public function setUser($idUser){
		$idUser = $this->bd->escape($idUser);
		return $this->_setIdUser($idUser);
	}

	/*
	 * Private setters
	 */
	private function _setAdress($adress){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Adress SET adress='{$adress}' WHERE idAdress={$this->getIdAdress()}");
		return $res && $this->fetchInfo();
	}

	private function _setCP($CP){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Adress SET CP='{$CP}' WHERE idAdress={$this->getIdAdress()}");
		return $res && $this->fetchInfo();
	}

	private function _setCity($city){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Adress SET city='{$city}' WHERE idAdress={$this->getIdAdress()}");
		return $res && $this->fetchInfo();
	}

	private function _setMain($isMain){
		if($isMain){ // Constraint
			$this->bd->modify_query("UPDATE ProjetS3.Adress SET isMain=0 WHERE idUser={$this->getUser()} AND isMain=1");
		}
		$res = $this->bd->modify_query("UPDATE ProjetS3.Adress SET isMain=".$isMain." WHERE idAdress={$this->getIdAdress()}");
		return $res && $this->fetchInfo();
	}

	private function _setIdUser($idUser){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Adress SET idUser='{$idUser}' WHERE idAdress={$this->getIdAdress()}");
		return $res && $this->fetchInfo();
	}
}

?>