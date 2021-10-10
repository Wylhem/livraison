<?php
namespace Projet;

require_once 'Bd.php';

/*
 * verification:
 * error_verif_pseudo
 * error_verif_email
 * error_verif_password
 *
 * validation:
 * error_validate_email
 * error_validate_pseudo
 * error_validate_password
 *
 */
class User {
	private $bd;
	private $idUser;
	private $email;
	private $pseudo;
	private $foreName;
	private $familyName;
	private $isProducteur;
	private $imageProfil;

	function __construct(){
		$this->bd = initBD();
	}

	/*
	 * Main functions:
	 */
	public function inscription($email, $pseudo, $password, $passwordConfirm, $isProducteur){
		if($this->populateWithNewUser($email, $pseudo, $password, $passwordConfirm, $isProducteur)){
			$this->setConnected(TRUE);
			return TRUE;
		}
		return FALSE;
	}

	public function connexion($pseudo, $password){
		$pseudo = $this->bd->escape($pseudo);
		$password = $this->bd->escape($password);

		if($this->_populateWithPseudo($pseudo)){
			if($this->verifyHashMDP($password)){
				$this->setConnected(TRUE);
				return TRUE;
			}
		}
		return FALSE;
	}

	public function updateInfos($pseudo, $email, $foreName, $familyName){
		$pseudo = $this->bd->escape($pseudo);
		$email = $this->bd->escape($email);
		$foreName = $this->bd->escape($foreName);
		$familyName = $this->bd->escape($familyName);

		if($pseudo != $this->getPseudo()){
			$this->_setPseudo($pseudo);
		}

		if($email != $this->getEmail()){
			$this->_setEmail($email);
		}

		if($foreName != $this->getForeName()){
			$this->_setForeName($foreName);
		}

		if($familyName != $this->getFamilyName()){
			$this->_setFamilyName($familyName);
		}
	}

	public function changePasword($currentPassword, $password, $passwordConfirm){
		if($this->verifyHashMDP($currentPassword)){
			return $this->setPassword($password, $passwordConfirm);
		}
		return FALSE;
	}

	/*
	 * Cart Gestion
	 */
	public function setToCart($id, $nb){
		$cart = $_SESSION["cart"];
		$cart[$id] = $nb;
		$_SESSION["cart"] = $cart;
	}

	public function removeFromCart($id){
		$cart = $_SESSION["cart"];
		unset($cart[$id]);
		$_SESSION["cart"] = $cart;
	}

	public function getCart(){
		return $_SESSION["cart"];
	}

	public function dumpCart(){
		unset($_SESSION["cart"]);
		$_SESSION["cart"] = array();
	}

	/*
	 * Gestions de la connection
	 */
	public function isConnected(){
		return (isset($_SESSION["id"]));
	}

	public function setConnected($connected){
		if($connected){
			$_SESSION["id"] = $this->idUser;
			$_SESSION["cart"] = array();
		}else{
			unset($_SESSION["id"]);
			unset($_SESSION["cart"]);
		}
	}

	public function getConnectedId(){
		return $_SESSION["id"];
	}

	/*
	 * fetchInfo infos function:
	 */
	private function fetchInfo(){
		$info = $this->bd->row_query("SELECT idUser, email, pseudo, foreName, familyName, isProducteur FROM ProjetS3.Utilisateur WHERE idUser={$this->idUser}");
		$res = ($info !== NULL);
		if($res){
			$this->idUser = (int) $info["idUser"];
			$this->email = $info["email"];
			$this->pseudo = $info["pseudo"];
			$this->foreName = $info["foreName"];
			$this->familyName = $info["familyName"];
			$this->isProducteur = (int) $info["isProducteur"];
		}
		return $res;
	}

	private function fetchImage(){
		if($this->idUser !== NULL){
			$this->imageProfil = $this->bd->select_type_querry("imageProfil", "ProjetS3.Utilisateur", "idUser={$this->getIdUser()}");
		}
	}

	/*
	 * populate functions
	 */

	/*
	 * Populate with the connected User if the User is connected
	 */
	public function tryPopulateIfConnected(){
		if($this->isConnected()){
			$this->idUser = $this->getConnectedId();
			$this->fetchInfo();
		}
	}

	public function populateIfConnected(){
		if($this->isConnected()){
			$this->idUser = $this->getConnectedId();
			return $this->fetchInfo();
		}else{
			header("Location: ../landing/landing.php");
			return FALSE;
		}
	}

	/*
	 * Try Populate with from outside of this class (public)
	 */
	public function populateWithId($idUser){
		$idUser = $this->bd->escape($idUser);
		return $this->_populateWithId($idUser);
	}

	public function populateWithPseudo($pseudo){
		$pseudo = $this->bd->escape($pseudo);
		return $this->_populateWithPseudo($pseudo);
	}

	public function populateWithEmail($email){
		$email = $this->bd->escape($email);
		return $this->_populateWithEmail($email);
	}

	public function populateWithNewUser($email, $pseudo, $password, $passwordConfirm, $isProducteur){
		$email = $this->bd->escape($email);
		$pseudo = $this->bd->escape($pseudo);
		$password = $this->bd->escape($password);
		$passwordConfirm = $this->bd->escape($passwordConfirm);
		$isProducteur = (int) $this->bd->escape($isProducteur);

		return $this->_populateWithNewUser($email, $pseudo, $password, $passwordConfirm, $isProducteur);
	}

	/*
	 * Try Populate with from inside of this class (private)
	 */
	private function _populateWithId($idUser){
		$this->idUser = $idUser;
		return $this->fetchInfo();
	}

	private function _populateWithPseudo($pseudo){
		$this->idUser = $this->bd->row_query("SELECT idUser FROM ProjetS3.Utilisateur WHERE pseudo='{$pseudo}'")["idUser"];
		if($this->idUser){
			$this->fetchInfo();
			return TRUE;
		}else{
			$_SESSION["error_verif_pseudo"] = "Ce Pseudo n'est pas associé à un compte existant.";
			return FALSE;
		}
	}

	private function _populateWithEmail($email){
		$this->idUser = $this->bd->row_query("SELECT idUser FROM ProjetS3.Utilisateur WHERE email='{$email}'")["idUser"];
		if($this->idUser){
			$this->fetchInfo();
			return TRUE;
		}else{
			$_SESSION["error_verif_email"] = "Cet email n'est pas associé à un compte existant.";
			return FALSE;
		}
	}

	private function _populateWithNewUser($email, $pseudo, $password, $passwordConfirm, $isProducteur){
		$error = FALSE;
		$error = (!$this->validateEmail($email)) || $error;
		$error = (!$this->validatePseudo($pseudo)) || $error;
		$error = (!$this->validatePassword($password, $passwordConfirm)) || $error;

		if($error){
			return FALSE;
		}

		$hash = password_hash($password, PASSWORD_ARGON2ID);

		if($this->bd->modify_query("INSERT INTO ProjetS3.Utilisateur (email, pseudo, hashmdp, isProducteur) VALUES('{$email}', '{$pseudo}', '{$hash}', {$isProducteur})")){
			if($this->_populateWithPseudo($pseudo)){
				return TRUE;
			}
		}
		return FALSE;
	}

	/*
	 * verify functions
	 * verifie les arguments avec les donnees deja set.
	 */
	private function verifyHashMDP($password){
		$hash = $this->bd->row_query("SELECT hashmdp FROM ProjetS3.Utilisateur WHERE idUser='".$this->idUser."'")["hashmdp"];
		if(password_verify($password, $hash)){
			return TRUE;
		}else{
			$_SESSION["error_verif_password"] = "Mot de Passe invalide.";
			return FALSE;
		}
	}

	/*
	 * validate functions
	 * verifie que les arguments peuvent etre set.
	 */
	public function validateEmail($email){
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$_SESSION["error_validate_email"] = "Cet email n'est pas un email valide.";
		}elseif($this->bd->count_query("SELECT COUNT(*) FROM ProjetS3.Utilisateur WHERE email='{$email}'") > 0){
			$_SESSION["error_validate_email"] = "Cet email est déjà utilisé.";
		}else{
			return TRUE;
		}
		return FALSE;
	}

	public function validatePseudo($pseudo){
		if($this->bd->count_query("SELECT COUNT(*) FROM ProjetS3.Utilisateur WHERE pseudo='{$pseudo}'") > 0){
			$_SESSION["error_validate_pseudo"] = "Ce Pseudo est deja utilisé";
		}else{
			return TRUE;
		}
		return FALSE;
	}

	public function validatePassword($password, $passwordConfirm){
		if($password != $passwordConfirm){
			$_SESSION["error_validate_password"] = "Les mots de Passes sont différents";
		}elseif(strlen($password) < 8){
			$_SESSION["error_validate_password"] = "Votre mot de passe est trop court.";
		}else{
			return TRUE;
		}
		return FALSE;
	}

	/*
	 * getters functions
	 */
	public function getIdUser(){
		return $this->idUser;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getPseudo(){
		return $this->pseudo;
	}

	public function getForeName(){
		return $this->foreName;
	}

	public function getFamilyName(){
		return $this->familyName;
	}

	public function isProducteur(){
		return $this->isProducteur;
	}

	public function getImageProfil(){
		if($this->imageProfil === NULL){
			$this->fetchImage();
		}
		return $this->imageProfil;
	}

	/*
	 * setters functions
	 */
	/*
	 * public setters (for outside the class)
	 */
	public function setEmail($email){
		$email = $this->bd->escape($email);
		if($this->validateEmail($email)){
			return $this->_setEmail($email);
		}
		return FALSE;
	}

	public function setPseudo($pseudo){
		$pseudo = $this->bd->escape($pseudo);
		if($this->validatePseudo($pseudo)){
			return $this->_setPseudo($pseudo);
		}
		return FALSE;
	}

	public function setForeName($foreName){
		$foreName = $this->bd->escape($foreName);
		return $this->_setForeName($foreName);
	}

	public function setFamilyName($familyName){
		$familyName = $this->bd->escape($familyName);
		return $this->_setFamilyName($familyName);
	}

	public function setPassword($password, $passwordConfirm){
		$password = $this->bd->escape($password);
		$passwordConfirm = $this->bd->escape($passwordConfirm);
		if($this->validatePassword($password, $passwordConfirm)){
			return $this->_setPassword($password);
		}
		return FALSE;
	}

	public function setProducteur($isProducteur){
		$isProducteur = $this->bd->escape($isProducteur);
		return $this->_setProducteur($isProducteur);
	}

	public function setImage($imageProfil){
		if($imageProfil !== NULL){
			return $this->_setImageProfil($imageProfil);
		}
	}

	/*
	 * private setter (for inside the class)
	 */
	private function _setEmail($email){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Utilisateur SET email='{$email}' WHERE idUser='{$this->getIdUser()}'");
		return $res && $this->fetchInfo();
	}

	private function _setPseudo($pseudo){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Utilisateur SET pseudo='{$pseudo}' WHERE idUser='{$this->getIdUser()}'");
		return $res && $this->fetchInfo();
	}

	private function _setForeName($foreName){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Utilisateur SET forename='{$foreName}' WHERE idUser='{$this->getIdUser()}'");
		return $res && $this->fetchInfo();
	}

	private function _setFamilyName($familyName){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Utilisateur SET familyName='{$familyName}' WHERE idUser='{$this->getIdUser()}'");
		return $res && $this->fetchInfo();
	}

	private function _setPassword($password){
		$hash = password_hash($password, PASSWORD_ARGON2ID);
		$res = $this->bd->modify_query("UPDATE ProjetS3.Utilisateur SET hashmdp='{$hash}' WHERE idUser='{$this->getIdUser()}'");
		return $res && $this->fetchInfo();
	}

	private function _setProducteur($isProducteur){
		$res = $this->bd->modify_query("UPDATE ProjetS3.Utilisateur SET isProducteur='{$isProducteur}' WHERE idUser='{$this->getIdUser()}'");
		return $res && $this->fetchInfo();
	}

	private function _setImageProfil($imageProfil){
		$res = $this->bd->update_type_querry("imageProfil", "ProjetS3.Utilisateur", $imageProfil, "idUser='{$this->getIdUser()}'", 'b');
		return $res && $this->fetchImage();
	}
}
?>