<?php

class DividereFascia {

//Divide per fascia
	public function fasciaArray ($totale, $arrayFascie) {
		$fasciaArray = [0];

		foreach ($arrayFascie as $key => $value) {
			if ($value['fascia'] < $totale) {
				$fasciaArray[] = $value['fascia'] - $fasciaArray[$key];
			}
				else {
					$fasciaArray[] = $totale - array_sum($fasciaArray);
				}
		}

		array_shift($fasciaArray);
		return $fasciaArray;
	}


	public function accisaGas ($totale, $arrayFascie,$zona) {
		$fascie = DividereFascia::fasciaArray($totale, $arrayFascie);
		$soma = 0;

		foreach ($fascie as $key => $value) {
			$soma += $value * $arrayFascie[$key][$zona];
		}
			return $soma;

	}


}