<?php

class PrezzoGas {

	private $consumo; //consumo (totale in m3)
	private $prezzoMateria; // prezzo
  private $prezzoFissoMateria; // array prezzo fisso (Quota Fissa , Prezzo * consumo )
	private $rede; // array transporto, stoccaggio
  private $transportoVariabile; //array transporto variabile (zona1, zona2 ... / consumo 140, 480 ...)
  private $tabellaTransporto; //array (QuotaFissa (t1a = tutti)(t1b = g4-g6)(t1c = g10-g40)(t1d = <g40), Quotamisura (t1e = g4-g6) (t1f = g10-g40)(t1g = <g40), variabile (t3 - array(zona1, zona2 ...) )
  private $tabellaAccisa; // array fascia (accisaNord - accisaSud ) (addizionale regione) (iva)

  private $regione; //regione
  private $zona; //zona referente a regione

	private $prezzoExpand; //oggeto prezzo (Totale, materia, rete, imposte, iva)	



	public function __construct() {
        $this->setTasse();
  	}



// ----- Set e get

	public function setConsumo ($consumo) {
		  $this->consumo = $consumo;
	}

	public function setPrezzoMateria ($prezzoMateria) {
    	$this->prezzoMateria = $prezzoMateria;
	}

	public function setTasseFise ($tasseFisse) {
		  $this->tasseFisse = $tasseFisse;
 	}

	public function setTransporto ($transporto, $stoccaggio) {
  		$this->rede =  array($transporto,$stoccaggio);
 	}

  public function setRegione ($regione) {
      $this->regione =  $regione;
      $this->sceglieZona();
  }

	public function getPrezzoExpand () {
		  return $this->expandPrezzo();
	}




	private function setTasse () {
  		$dataDB = new DatabaseGas();

      $this->transportoVariabile = $dataDB->prendeTabella(DB_FASCIA_TRANSPORTO_GAS);
      $this->tabellaTransporto = $dataDB->prendeTabella(DB_TRANSPORTO_GAS);
      $this->tabellaAccisa = $dataDB->prendeTabella(DB_ACCISA_GAS);
      $prezzoFisso = $dataDB->prendeTabella(DB_ALTRE_TASSE_GAS);

      $this->prezzoFissoMateria = [$prezzoFisso[0]['valore'] , $prezzoFisso[1]['valore']];

	}

//-----------------------------	


// Prezzo  Azienda--- 
	private function expandPrezzo () {

  		$prezzoMateria = $this->prezzoMateria();
  		$totale = $prezzoMateria;
  		$transporto = $this->prezzoTransporto($this->consumo);
  		$totale += $transporto;
  		$imposte = $this->prezzoImposte($totale);
  		$totale += $imposte;
  		$iva = $this->prezzoIva($totale);
  		$totale += $iva;

  		$prezzoExpand = (object) ['prezzoMateria' =>$prezzoMateria, 'transporto' => $transporto, 'imposte' => $imposte, 'iva' => $iva, 'prezzoT' => $totale ];

  			return $prezzoExpand;
	}


// Prezzo Materia -----------------------------------------

  public function prezzoMateria() {
      $prezzoConsumo = $this->prezzoMateria * $this->consumo;
      
      $QVD = $this->prezzoFissoMateria[0];
      $CCI = $this->prezzoFissoMateria[1] * $this->consumo;

      $totaleMateria = $prezzoConsumo + $QVD + $CCI;

  	  		return $totaleMateria;
  	}

// -----------------------------------------

//Transporto -------------------------------- //array[regione] (QuotaFissa (t1a = tutti)(t1b = g4-g6)(t1c = g10-g40)(t1d = <g40), Quotamisura (t1e = g4-g6) (t1f = g10-g40)(t1g = <g40), variabile (t3 - array[fascia1, fascia2 ...] )

  	private function prezzoTransporto($consumo) {
        $regione = $this->zona;
        $gs = $this->tabellaTransporto[$regione]["gs"];
        $re = $this->tabellaTransporto[$regione]["re"];
        $rs = $this->tabellaTransporto[$regione]["rs"];

        $ug3Int = $this->tabellaTransporto[$regione]["ug3int"];
        $ug3Ui = $this->tabellaTransporto[$regione]["ug3ui"];
        $ug3Ft = $this->tabellaTransporto[$regione]["ug3ft"];

        $transportoFisso = $this->tabellaTransporto[$regione]["t1a"] + $this->tabellaTransporto[$regione]["t1b"];
        
        $transportoMisura = $this->tabellaTransporto[$regione]["t1e"];

        $oneri = ($this->consumo * $gs) + ($this->consumo * $re) + ($this->consumo * $rs);

        $oneriUg3 = ($this->consumo * $ug3Int) + ($this->consumo * $ug3Ui) + ($this->consumo * $ug3Ft);

        $transporto = $transportoFisso + $transportoMisura + $oneri + $oneriUg3 + $this->accisaTransporto();


    			return $transporto;
  	}

//accisa --------------------------------
    private function accisaTransporto() {
        $regione = "zona".$this->zona;
        $accisa = DividereFascia::accisaGas($this->consumo,$this->transportoVariabile, $regione);
            return $accisa;
    }


//----------------------------------------

    private function sceglieZona() {
        $dataDB = new DatabaseGas();

        $listaRegione = $dataDB->prendeTabella(DB_AZIENDE_GAS_REGIONE);
        $gruppo = 0;

        foreach ($listaRegione as $value) {
          
            if ( in_array($this->regione, AdattaString::uscitaArray($value['regione'])) ) {
                $this->zona = $value['gruppo'];
                break;
            }
        }
    }

// --------------------------------

//Altre  Imposte -----------------------------------------    

  	private function prezzoImposte($parciale) {
  		$accisaF = DividereFascia::fasciaArray($this->consumo,$this->tabellaAccisa);
      $regioneMezzo = $this->regioneMezzo($this->regione);

      if (isset($this->tabellaAccisa[$this->regione])) {
          $regione = $this->regione;
      }
        else { $regione = "Umbria"; }

      $imposte = 0;

      foreach ($accisaF as $key => $value) {
          $imposte += $this->tabellaAccisa[$key][$regioneMezzo] * $value;
          $imposte += $this->tabellaAccisa[$key][$regione] * $value;
      }

  			return $imposte;
  	}

    //sceglie regione mezzogiorno (accisanord, accisasud)
    private function regioneMezzo($regione) {
        $arrayM = array('Abruzzo', 'Molise', 'Campania', 'Puglia', 'Basilicata', 'Calabria', 'Sicilia', 'Sardegna');

        if ( in_array($regione, $arrayM) ) {
            return "accisasud";
        }
          else {
              return "accisanord";
          }
    }


// -----------------------------------------

// IVA -----------------------------------------

 	  private function prezzoIva($parciale) {
      $accisaF = DividereFascia::fasciaArray($this->consumo,$this->tabellaAccisa);

      $iva = 0;

      foreach ($accisaF as $key => $value) {
          $_parciale = $parciale * ($value / $this->consumo);
          $iva += $this->tabellaAccisa[$key]['iva'] * $_parciale;
      }      
     			return $iva;
  	}
// -----------------------------------------

}