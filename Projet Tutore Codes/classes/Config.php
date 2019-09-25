<?php

Class Connect{

	private $HOST = "mysql:host=localhost;dbname=pfe";
	private $UNAME = "sydney";
	private $MDP = "thePassW0rd!3";
	
	private $arr = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

	private $connexion;

	public function ouvrir(){
		$this->connexion = new PDO($this->HOST, $this->UNAME, $this->MDP, $this->arr);
		return $this->connexion;
	}

	public function fermer(){
		$this->connexion = null;
	}

}

?>