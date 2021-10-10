<?php
namespace Projet;

require_once 'Bd.php';

class Item {
	private $bd;
	private $idItem;
	private $nom;
	private $description;
	private $prixKilo;
	private $poidsUnite;
	private $image;
	private $nb;
	private $idUser;
	private $idTypeItem;

	function __construct(){
		$this->bd = initBD();
	}

	/*
	 * Main functions
	 */
	public function getPrix(){
		return ($this->getPrixKilo() / 1000) * $this->getPoidsUnite();
	}

	public function updateInfos($nom, $description, $prixKilo, $poidsUnite, $nb, $image){
		$nom = $this->bd->escape($nom);
		$description = $this->bd->escape($description);
		$prixKilo = $this->bd->escape($prixKilo);
		$poidsUnite = $this->bd->escape($poidsUnite);
		$nb = $this->bd->escape($nb);

		if($nom != $this->getNom()){
			$this->_setNom($nom);
		}

		if($description != $this->getDescription()){
			$this->_setDescription($description);
		}

		if($prixKilo != $this->getPrixKilo()){
			$this->_setPrixKilo($prixKilo);
		}

		if($poidsUnite != $this->getPoidsUnite()){
			$this->_setPoidsUnite($poidsUnite);
		}
		if($nb != $this->getNb()){
			$this->_setNb($nb);
		}

		if($image !== NULL){
			$this->_setImage($image);
		}
	}

	/*
	 * Fetch infos
	 */
	private function fetchInfo(){
		$info = $this->bd->row_query("SELECT idItem, nom, description, prixKilo, poidsUnite, nb, idUser, idTypeItem FROM ProjetS3.Item WHERE idItem={$this->idItem}");
		$res = ($info !== NULL);
		if($res){
			$this->idItem = (int) $info["idItem"];
			$this->nom = $info["nom"];
			$this->description = $info["description"];
			$this->prixKilo = (floatval($info["prixKilo"]));
			$this->poidsUnite = (int) $info["poidsUnite"];
			$this->nb = (int) $info["nb"];
			$this->idUser = (int) $info["idUser"];
			$this->idTypeItem = (int) $info["idTypeItem"];
		}
		return $res;
	}

	private function fetchImage(){
		$this->image = $this->bd->select_type_querry("image", "ProjetS3.Item", "idItem={$this->getIdItem()}");
	}

	/*
	 * Public populators
	 */
	public function populateWithId($idItem){
		$idItem = $this->bd->escape($idItem);
		return $this->_populateWithId($idItem);
	}

	public function populateWithNewItem($nom, $description, $prixKilo, $poidsUnite, $image, $nb, $idUser){
		$nom = $this->bd->escape($nom);
		$description = $this->bd->escape($description);
		$prixKilo = ($this->bd->escape($prixKilo)) * 100;
		$poidsUnite = $this->bd->escape($poidsUnite);
		$nb = $this->bd->escape($nb);
		return $this->_populateWithNewItem($nom, $description, $prixKilo, $poidsUnite, $image, $nb, $idUser);
	}

	/*
	 * Private populators
	 */
	private function _populateWithId($idItem){
		$this->idItem = $idItem;
		return $this->fetchInfo();
	}

	private function _populateWithNewItem($nom, $description, $prixKilo, $poidsUnite, $image, $nb, $idUser){
		if($this->bd->modify_query("INSERT INTO ProjetS3.Item  (nom, prixKilo, poidsUnite, idUser) VALUES('{$nom}', {$prixKilo}, {$poidsUnite}, {$idUser})")){
			$this->idItem = $this->bd->row_query("SELECT idItem FROM ProjetS3.Item WHERE idUser={$idUser} ORDER BY idItem DESC LIMIT 1")["idItem"];
			$res = ($this->idItem !== NULL);
			if($description !== NULL){
				$this->_setDescription($description);
			}
			if($image !== NULL){
				$this->_setImage($image);
			}
			if($nb !== NULL){
				$this->_setNb($nb);
			}
			return $res && $this->fetchInfo();
		}
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
	public function getIdItem(){
		return $this->idItem;
	}

	public function getNom(){
		return $this->nom;
	}

	public function getDescription(){
		return $this->description;
	}

	public function getPrixKilo(){
		return $this->prixKilo;
	}

	public function getPoidsUnite(){
		return $this->poidsUnite;
	}

	public function getImage(){
		if($this->image === NULL){
			$this->fetchImage();
		}
		return $this->image;
	}

	public function getNb(){
		return $this->nb;
	}

	public function getIdUser(){
		return $this->idUser;
	}

	public function getIdTypeItem(){
		return $this->idTypeItem;
	}

	/*
	 * Public setters
	 */
	public function setNom($nom){
		$nom = $this->bd->escape($nom);
		return $this->_setNom($nom);
	}

	public function setDescription($description){
		$description = $this->bd->escape($description);
		return $this->_setDescription($description);
	}

	public function setPrixKilo($prix_kilo){
		$prix_kilo = $this->bd->escape($prix_kilo);
		return $this->_setPrixKilo($prix_kilo);
	}

	public function setPoidsUnite($poidsUnite){
		$poidsUnite = $this->bd->escape($poidsUnite);
		return $this->_setPoidsUnite($poidsUnite);
	}

	public function setImage($image){
		return $this->_setImage($image);
	}

	public function setNb($nb){
		$nb = $this->bd->escape($nb);
		return $this->_setNb($nb);
	}

	public function setIdUser($idUser){
		$idUser = $this->bd->escape($idUser);
		return $this->_setIdUser($idUser);
	}

	public function setIdTypeItem($idTypeItem){
		$idTypeItem = $this->bd->escape($idTypeItem);
		return $this->_setIdTypeItem($idTypeItem);
	}

	/*
	 * Private setters
	 */
	private function _setNom($nom){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Item SET nom='{$nom}' WHERE idItem={$this->getIdItem()}");
		return $res && $this->fetchInfo();
	}

	private function _setDescription($description){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Item SET description='{$description}' WHERE idItem={$this->getIdItem()}");
		return $res && $this->fetchInfo();
	}

	private function _setPrixKilo($prixKilo){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Item SET prixKilo='{$prixKilo}' WHERE idItem={$this->getIdItem()}");
		return $res && $this->fetchInfo();
	}

	private function _setPoidsUnite($poidsUnite){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Item SET poidsUnite={$poidsUnite} WHERE idItem={$this->getIdItem()}");
		return $res && $this->fetchInfo();
	}

	private function _setImage($image){
		$res = $this->bd->update_type_querry("image", "ProjetS3.Item", $image, "idItem='{$this->getIdItem()}'", 'b');
		return $res && $this->fetchImage();
	}

	private function _setNb($nb){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Item SET nb={$nb} WHERE idItem={$this->getIdItem()}");
		return $res && $this->fetchInfo();
	}

	private function _setIdUser($idUser){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Item SET idUser={$idUser} WHERE idItem={$this->getIdItem()}");
		return $res && $this->fetchInfo();
	}

	private function _setIdTypeItem($idTypeItem){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Item SET idTypeItem={$idTypeItem} WHERE idItem={$this->getIdItem()}");
		return $res && $this->fetchInfo();
	}
}

?>