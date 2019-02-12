<?php

include_once "..\php\urls.php";
include_once "..\php\Database.php";
include_once "..\php\luce\DatabaseLuce.php";
include_once "..\php\luce\prezzo.php";


class PrezzoTest extends PHPUnit_Framework_TestCase {

    public function testPrezzoUscitaProperty() {
    	   	$calcolaPrezzo = new Prezzo();
	        $calcolaPrezzo->setConsumo(1000);
	        $calcolaPrezzo->setEnergia(1,[1, 1, 1,1]);
	        $calcolaPrezzo->setPrezzo([1, 1, 1, 1],[500,500,0]);
	        $calcolaPrezzo->setTransporto(1, [1,1,1,1] );
	        $calcolaPrezzo->setPotenza(1.5,1);
	        
	        $objPrezzo = $calcolaPrezzo->expandPrezzo();

	        $this->assertObjectHasAttribute('prezzoT', $objPrezzo);
	        $this->assertObjectHasAttribute('energia', $objPrezzo);
	        $this->assertObjectHasAttribute('imposte', $objPrezzo);
	        $this->assertObjectHasAttribute('rede', $objPrezzo);
	        $this->assertObjectHasAttribute('iva', $objPrezzo);

	            return $objPrezzo;
            
      }

    /**
     * @depends testPrezzoUscitaProperty
     */

    public function testPrezzoUscitaFormato ($objPrezzo) {
    		$this->assertInternalType('float', $objPrezzo->prezzoT);
        	$this->assertInternalType('float', $objPrezzo->energia);
        	$this->assertInternalType('float', $objPrezzo->imposte);
        	$this->assertInternalType('float', $objPrezzo->rede);
        	$this->assertInternalType('float', $objPrezzo->iva);
    }

    /**
     * @depends testPrezzoUscitaProperty
     */

    public function testPrezzoUscitaTotale ($objPrezzo) {
    		$this->assertEquals($objPrezzo->prezzoT , ($objPrezzo->energia + $objPrezzo->rede + $objPrezzo->imposte + $objPrezzo->iva));
    }


    /**
     * @depends testPrezzoUscitaProperty
     */

    public function testPrezzoUscitaIva ($objPrezzo) {
	    	$dataDB = new DatabaseLuce();
	  		$IVA = $dataDB->prendeTabella(DB_IVA);
	  		$percentualeIVA = $IVA[0]['iva'];

    		$this->assertEquals($objPrezzo->prezzoT , ($objPrezzo->energia + $objPrezzo->rede + $objPrezzo->imposte) * (1 + $percentualeIVA) );
    }

}