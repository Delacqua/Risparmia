<?php

class Vetrina { 

	public function seleziona($arrayDB) {
		$selezionata = array();

		if (count($arrayDB) > 0) {
			$scegli = rand(0, count($arrayDB)-1);
			$selezionata[0] = $arrayDB[$scegli];
		}
			return $selezionata;
	}

}