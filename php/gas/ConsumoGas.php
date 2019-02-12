<?php

//--------

include_once '..\php\urls.php';

//-------------


class ConsumoGas {

	private $consumo;
	private $regione;

	public function __construct ($obj) {
		$this->regione = $obj->regione;
		$this->expandConsumo($obj);
	}

//------- get / set

	public function getConsumo() {
		return $this->consumo;
	}

	public function getRegione() {
		return $this->regione;
	}


// ----------------------------

	private function expandConsumo($obj) {
		if ($obj->consumo) {
			   $this->consumo = $obj->consumo;
	    }
	        else {
		        $this->stimaConsumo($obj);
		    }	
		
	}

	private function stimaConsumo($obj) {
		$stimaConsumo = new StimaConsumoGas($obj);
		$this->consumo = $stimaConsumo->getConsumo();
	}

}