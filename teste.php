<?php 
	
	include_once(dirname(__FILE__) . '/php/urls.php');

	echo "teste </br>";

	function fasciaArray ($totale, $arrayFascie) {
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


	$valore = 1000;

	$dataDB = new DatabaseGas();

    $listaRegione = $dataDB->prendeTabella(DB_ACCISA_GAS);

	$arrayPrezzo = array('fascia'=>200,'fascia'=>600,'fascia'=>1000);


	var_dump(fasciaArray($valore,$listaRegione));