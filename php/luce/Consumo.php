<?php

//--------

include_once '..\php\urls.php';

//-------------


class Consumo {

	private $potenza;
	private $arrayConsumo;
	private $consumo;
	private $regione;

	public function __construct ($obj) {
		$this->expandConsumo($obj);
		$this->regione = $obj->regione;
	}

//------- get / set

	public function getPotenza() {
		return $this->potenza;
	}

	public function getArrayConsumo() {
		return $this->arrayConsumo;
	}

	public function getConsumo() {
		return $this->consumo;
	}

	public function getRegione() {
		return $this->regione;
	}



// ----------------------------

	private function expandConsumo($obj) {

	//Aziende Luce
		$this->potenza = $obj->potenza;

        if ($obj->consumo) {
            $this->setConsumo($obj->consumo, $obj->f1, $obj->f2, $obj->f3);
          }
	          else {
	            $this->stimaConsumo($obj->personeSelected, $obj->dimensioneCasa, $obj->potenzaAggiunta);
	          }	
	}

	private function setConsumo ($consumo, $f1, $f2, $f3) {
		$this->consumo = $consumo;
		$this->arrayConsumo = array($f1, $f2, $f3);
	}

	private function stimaConsumo($personeSelected,$dimensioneCasa,$potenzaAggiunta) {
		$stimaConsumo = new StimaConsumo();
		$arrayConsumo = $stimaConsumo->stima($personeSelected, $dimensioneCasa, $potenzaAggiunta);
		$this->arrayConsumo = array($arrayConsumo['f1'],$arrayConsumo['f2'],$arrayConsumo['f3']);
		$this->consumo = $arrayConsumo['consumo'];
	}

}