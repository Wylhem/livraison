<?php
namespace Projet;

require_once 'Bd.php';

class Test {
	private $bd;
	private $id;
	private $value;

	function __construct(){
		$this->bd = initBD();
	}

	/*
	 * Main functions
	 */

	/*
	 * Fetch infos
	 */
	private function fetchInfo(){
		$info = $this->bd->row_query("SELECT id FROM Test WHERE id=".$this->id);
		$res = ($info !== NULL);
		if($res){
			$this->id = (int) $info["id"];
			$this->value = $info["value"];
		}
		return $res;
	}

	/*
	 * Public populators
	 */
	public function populateWithId($id){
		$id = $this->bd->escape($id);
		return $this->_populateWithId($id);
	}

	/*
	 * Private populators
	 */
	private function _populateWithId($id){
		$this->id = $id;
		return $this->fetchInfo();
	}

	/*
	 * verify functions
	 * Compare les arguments passer en parametre a ceux dans la base de donnees
	 */

	/*
	 * validate functions
	 * Contraintes d integriter avec la BD
	 */

	/*
	 * getters
	 */
	public function getId(){
		return $this->id;
	}

	public function getValue(){
		return $this->value;
	}

	/*
	 * Public setters
	 */
	public function setValue($value){
		$value = $this->bd->escape($value);
		return $this->_setValue($value);
	}

	/*
	 * Private setters
	 */
	private function _setValue($value){
		$id = $this->getId();
		$res = $this->bd->modify_query("UPDATE Test SET value='".$value."' WHERE id='".$id."'");
		return $res && $this->fetchInfo();
	}
}

?>