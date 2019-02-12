<?php

class PrezzoGas {

	private $consumo; //consumo (totale in m3)
	private $prezzoMateria; // array prezzo (Prezzo Materia, Costo di Commercializzazione al Dettaglio, Costo di Commercializzazione all’Ingrosso)
  private $prezzoFissoMateria; // array prezzo fisso (Quota Fissa , Oneri )
	private $rede; // array transporto, stoccaggio
  private $transportoVariabile; //array transporto variabile (zona1, zona2 ... / consumo 140, 480 ...)
  private $transportoFisso; //array (QuotaFissa, Oneri)
	private $tasseFise; // array imposte (Tutte le tasse meno iva) 
	private $IVA; // percentuale espresso in 0.00
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

	public function setIva ($IVA) {
  		$this->IVA =  $IVA;
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

      $this->transportoVariabile = $dataDB->prendeTabella(DB_ACCISA_GAS);

  		$this->tasseFise = [0.05,0.05]; 
      $this->prezzoFissoMateria = [36,12];
      $this->transportoFisso = [12,0];

      $percentualeIVA = $dataDB->prendeTabella(DB_IVA_GAS); //DB iva
      $this->IVA = $percentualeIVA[0]['iva'];

	}

//-----------------------------	


// Prezzo  Azienda--- 
	private function expandPrezzo () {

  		$prezzoMateria = $this->prezzoMateria();
  		$totale = $prezzoMateria;
  		$transporto = $this->prezzoTransporto($totale);
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
      $prezzoConsumo = $this->prezzoMateria[0] * $this->consumo;
      $QVD = $this->prezzoMateria[1] * $this->consumo;
      $CCI = $this->prezzoMateria[1] * $this->consumo;

      $somaPrezzoFisso = 0;

      foreach ($this->prezzoFissoMateria as $value) {
          $somaPrezzoFisso += $value;
      }

//      $totaleMateria = $prezzoConsumo + $QVD + $CCI + $somaPrezzoFisso;

      $totaleMateria = $prezzoConsumo;

	  		return $totaleMateria;
  	}

// -----------------------------------------

//Transporto --------------------------------

  	public function prezzoTransporto($parciale) {
    		$transportoVariabile = 0;

    		foreach ($this->rede as $value) {
    		    $transportoVariabile += $parciale*$value;
    		}

        $transportoFisso = 0;
        
        foreach ($this->transportoFisso as $value) {
            $transportoFisso += $value;
        }

        $transporto = $transportoVariabile + $transportoFisso + $this->accisaTransporto();

    			return $transporto;
  	}

//accisa --------------------------------
    public function accisaTransporto() {
        $regione = "zona".$this->zona;
        $accisa = DividereFascia::accisaGas($this->consumo,$this->transportoVariabile, $regione);

            return $accisa;
    }


//----------------------------------------

    public function sceglieZona() {
        $dataDB = new DatabaseGas();

        $listaRegione = $dataDB->prendeTabella(DB_AZIENDE_GAS_REGIONE);
        $gruppo = 0;

        foreach ($listaRegione as $value) {
          
            if ( in_array($this->regione, AdattaString::uscitaArray($value['regione'])) ) {
                //$this->zona = "zona".$value['gruppo']; 
                $this->zona = $value['gruppo'];
                break;
            }
        }
    }

// --------------------------------

//Altre  Imposte -----------------------------------------    

  	public function prezzoImposte($parciale) {
  		$imposte = 0;

  		foreach ($this->tasseFise as $value) {
  		    $imposte += $parciale*$value;
  		}

  			return $imposte;
  	}

// -----------------------------------------

// IVA -----------------------------------------

 	public function prezzoIva($parciale) {
  		$iva = 0;

  		$iva = $parciale * $this->IVA;

  			return $iva;
  	}
// -----------------------------------------

}