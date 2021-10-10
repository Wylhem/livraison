<?php
namespace Projet;

require_once 'Bd.php';
require_once 'Item.php';

class Commande {
	private $bd;
	private $idCommande;
	private $date;
	private $isValidated;
	private $idUser;
	private $idProducteur;
	private $idLivraison;
	private $listItems = array();

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
		$info = $this->bd->row_query("SELECT idCommande, dateCommande, isValidated, idUser, idProducteur, idLivraison FROM ProjetS3.Commande WHERE idCommande={$this->getIdCommande()}");
		$res = ($info !== NULL);
		if($res){
			$this->idCommande = (int) $info["idCommande"];
			$this->date = $info["dateCommande"];
			$this->isValidated = (int) $info["isValidated"];
			$this->idUser = (int) $info["idUser"];
			$this->idProducteur = (int) $info["idProducteur"];
			$this->idLivraison = (int) $info["idLivraison"];
		}
		return $res && $this->refreshListItems();
	}

	private function refreshListItems(){
		$info = $this->bd->query("SELECT idItem, nb, prixKiloAcaht, poidsUniteAchat FROM ProjetS3.DansCommande WHERE idCommande={$this->getIdCommande()}");
		$res = ($info !== NULL);
		if($res){
			while($row = $info->fetch_assoc()){
				$infos = array();
				$infos["nb"] = $row["nb"];
				$infos["prixKilo"] = $row["prixKiloAcaht"];
				$infos["poidsUnite"] = $row["poidsUniteAchat"];
				$this->listItems[$row["idItem"]] = $infos;
			}
		}
		return $res;
	}

	public function calculatePrix(){
		$prix = 0;
		foreach($this->listItems as $idItem => $infos){
			$prix += ($infos["nb"] * $infos["prixKilo"] * $infos["poidsUnite"]) / 1000;
		}
		return $prix;
	}

	/*
	 * Public populators
	 */
	public function populateWithId($idCommande){
		$idCommande = $this->bd->escape($idCommande);
		return $this->_populateWithId($idCommande);
	}

	public function populateNewCommande($idUser){
		// pour l'instant, on ne gère qu'un producteur donc on prend le premier producteur
		$idProducteur = (int) $this->bd->row_query("SELECT idUser FROM ProjetS3.Utilisateur WHERE isProducteur=1 ORDER BY idUser ASC LIMIT 1")["idUser"];
		return $this->_populateNewCommande(date('Y-m-d H:i:s'), $idUser, $idProducteur);
	}

	/*
	 * Private populators
	 */
	private function _populateWithId($idCommande){
		$this->idCommande = $idCommande;
		return $this->fetchInfo();
	}

	private function _populateNewCommande($date, $idUser, $idProducteur){
		if($this->bd->modify_query("INSERT INTO ProjetS3.Commande (dateCommande, idUser, idProducteur) VALUES('{$date}', {$idUser}, {$idProducteur})")){
			$this->idCommande = $this->bd->row_query("SELECT idCommande FROM ProjetS3.Commande WHERE idUser={$idUser} ORDER BY idCommande DESC LIMIT 1")["idCommande"];
			$res = ($this->idCommande !== NULL);
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
	public function getIdCommande(){
		return $this->idCommande;
	}

	public function getDate(){
		return $this->date;
	}

	public function isValidated(){
		return $this->isValidated;
	}

	public function getIdUser(){
		return $this->idUser;
	}

	public function getIdProducteur(){
		return $this->idProducteur;
	}

	public function getIdLivraison(){
		return $this->idLivraison;
	}

	public function getItems(){
		return $this->listItems;
	}

	/*
	 * Public setters
	 */
	public function setDate($date){
		$date = $this->bd->escape($date);
		return $this->_setDate($date);
	}

	public function setValidated($isValidated){
		$isValidated = $this->bd->escape($isValidated);
		return $this->_setValidated($isValidated);
	}

	public function setIdUser($idUser){
		$idUser = $this->bd->escape($idUser);
		return $this->_setIdUser($idUser);
	}

	public function setIdProducteur($idProducteur){
		$idProducteur = $this->bd->escape($idProducteur);
		return $this->_setIdProducteur($idProducteur);
	}

	public function setIdLivraison($idLivraison){
		$idLivraison = $this->bd->escape($idLivraison);
		return $this->_setIdLivraison($idLivraison);
	}

	public function setItem($idItem, $nb){
		$idItem = $this->bd->escape($idItem);
		$nb = $this->bd->escape($nb);
		$item = new Item();
		$item->populateWithId($idItem);
		$prixKiloAcaht = $item->getPrixKilo();
		$poidsUniteAchat = $item->getPoidsUnite();
		$set = isset($this->listItems[$idItem]);
		if($set){
			$dif = $nb - $this->listItems[$idItem]["nb"];
		}else{
			$dif = $nb;
		}
		
		if($item->getNb() >= $dif){
			$item->setNb($item->getNb() - $dif);
			if($set){
				return $this->_setNbItem($idItem, $nb, $prixKiloAcaht, $poidsUniteAchat);
			}else{
				return $this->_addItem($idItem, $nb, $prixKiloAcaht, $poidsUniteAchat);
			}
		}else{
			return FALSE;
		}
	}

	/*
	 * Private setters
	 */
	private function _setDate($date){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Commande SET dateCommande='{$date}' WHERE idCommande={$this->getIdCommande()}");
		return $res && $this->fetchInfo();
	}

	private function _setValidated($isValidated){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Commande SET isValidated='{$isValidated}' WHERE idCommande={$this->getIdCommande()}");
		return $res && $this->fetchInfo();
	}

	private function _setIdUser($idUser){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Commande SET idUser={$idUser} WHERE idCommande={$this->getIdCommande()}");
		return $res && $this->fetchInfo();
	}

	private function _setIDProducteur($idPoducteur){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Commande SET idProducteur='{$idPoducteur}' WHERE idCommande={$this->getIdCommande()}");
		return $res && $this->fetchInfo();
	}

	private function _setIdLivraison($idLivraison){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Commande SET idLivraison={$idLivraison} WHERE idCommande={$this->getIdCommande()}");
		return $res && $this->fetchInfo();
	}

	private function _addItem($idItem, $nb, $prixKiloAcaht, $poidsUniteAchat){
		$res = $this->bd->modify_query("INSERT INTO ProjetS3.DansCommande (idItem, idCommande, nb, prixKiloAcaht, poidsUniteAchat) VALUES({$idItem}, {$this->getIdCommande()}, {$nb}, {$prixKiloAcaht}, {$poidsUniteAchat})");
		return $res && $this->refreshListItems();
	}

	private function _setNbItem($idItem, $nb, $prixKiloAcaht, $poidsUniteAchat){
		$res = $this->bd->modify_query("UPDATE ProjetS3.DansCommande SET nb={$nb}, prixKiloAcaht={$prixKiloAcaht}, poidsUniteAchatWHERE={$poidsUniteAchat} idItem={$idItem} AND idCommande={$this->getIdCommande()}");
		return $res && $this->refreshListItems();
	}
}

?>