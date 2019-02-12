<?php

include_once '..\php\urls.php';

 class StimaConsumo {

  private $persone;
 	private $dimensione;
 	private $consumoAgg;
 	private $potenza;
 	private $elettroDB;
 	private $tabellaDimensione;
 	private $tabellaConsumoPersone;

 	
 	public function stima($persone,$dimensione,$consumoAgg) {
 		$this->persone = $persone;
 		$this->dimensione = $dimensione;
 		$this->consumoAgg = $consumoAgg;
 		$this->elettroDB = $this->setTabellaElettro();
 		$this->potenza = 3;
 		$this->setTabellaDimensione();
 		$this->setTabellaConsumoPersone();

        return $this->stimaArray();
 	}


 	private function stimaArray() {
 		$consumoPersone = $this->tabellaConsumoPersone[$this->persone];
 		$consumoMq = $consumoPersone * $this->aggiustaDimensione ();
 		$consumoElletro = $consumoMq + $this->consumoElettro();
 		$f1 = intval($consumoElletro * 0.6);
 		$f2 = intval($consumoElletro * 0.4);
 		$f3 = 0;

 		    return array('consumo'=>intval($consumoElletro), 'f1'=>$f1, 'f2'=>$f2, 'f3'=>$f3);

 	}


// ------ Set / Get

 	private function potenza() {
 		return $this->potenza;
 	}

 	public function setTabellaDimensione () {
 		$this->tabellaDimensione = array( '3' => 80 );
 	}

 	private function setTabellaConsumoPersone () {
 		$this->tabellaConsumoPersone = array(	
                        '1' => 1640, 
					 							'2' => 2210,
					 							'3' => 2690,
					 							'4' => 3140,
					 							'5' => 3580,
					 							'6' => 4010,
					 							'7' => 4430	);
 	}

  private function setTabellaElettro () {
    $dataDB = new DatabaseLuce();
      return $dataDB->prendeTabella(DB_ELLETRO);
  }


//------------------------------

 	//percentuale de aumento in base a media delle case (0.00)
 	private function aggiustaDimensione () {
 		$frazioneMq = 10; 
 		$aggiusteMq = 0.1;


 		$result = abs($this->tabellaDimensione['3'] - $this->dimensione);
 		$result = $result / $frazioneMq;

 		if ($this->tabellaDimensione['3'] > $this->dimensione ) {
 			$result = 1 - ($result * $aggiusteMq) ;
 		}
 			else {
 				$result = 1 + ($result * $aggiusteMq);
 			}

 		return $result;
 	}

 	//compara consumo medio con il numero de elletronici
 	private function consumoPersone() {
 		return 1000;
 	}

 	private function consumoElettro() {
 		$consumoElletroMedio = 990; // consumo che è già stato considerato

    	$consumoElletro = 0;

        foreach ($this->consumoAgg as $key => $value) {
          if ($value->selezionato) {
              	$consumoElletro = $consumoElletro + $this->elettroDB[$key]['potenza'];
          }
        }

        $consumoElletro = $consumoElletro - $consumoElletroMedio;

        return $consumoElletro;
 	}
 }