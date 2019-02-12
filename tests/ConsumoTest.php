<?php

include_once "..\php\urls.php";
include_once "..\php\luce\Consumo.php";

class ConsumoTest extends PHPUnit_Framework_TestCase {

	protected function getPotenzaAggiunta() {
        $potenzaAggiunta = array (
            (object) ["selezionato" => true,"nome" => "Forno Elettrico"],
            (object) ["selezionato" => true,"nome" => "Lavatrice"],
            (object) ["selezionato" => true,"nome" => "Congelatore"],
            (object) ["selezionato" => false,"nome" => "Lavastoviglie"],
            (object) ["selezionato" => false,"nome" => "Condizionatore"],
            (object) ["selezionato" => false,"nome" => "Scaldabagno elettrico"] );

                return $potenzaAggiunta;
    }

    public function testConstruiOggeto() {
            $obj = (object) ["comune" => 'Milano', "regione" => 'Lombardia', "consumo" => 1000, "f1" => 1000, "f2" => 500, "f3" => 0, "potenza" => 3, "iva" =>false];
    		$consumo = new Consumo($obj);
    		$this->assertInstanceOf('Consumo', $consumo);

    			return $consumo;
      }


    /**
     * @depends testConstruiOggeto
     */

    public function testHaLaPropertyPotenza ($objConsumo) {
    		$this->assertEquals(3, $objConsumo->getPotenza());
    }

    /**
     * @depends testConstruiOggeto
     */

    public function testHaLaPropertyConsumo ($objConsumo) {
    		$this->assertEquals(1000, $objConsumo->getConsumo());

    			return $objConsumo;
    }

    /**
     * @depends testHaLaPropertyConsumo
     */

    public function testHaLaPropertyArrayConsumo ($objConsumo) {
    		$arr = $objConsumo->getArrayConsumo();
    		$this->assertTrue(is_array($arr));
    		$this->assertEquals(3, count($arr));
    		$this->assertEquals(500, $arr[0]);
    		$this->assertEquals(500, $arr[1]);
    		$this->assertEquals(0, $arr[2]);
    }


    public function testConstruiOggetoStima () {
            $obj = (object) ["comune" => 'Milano', "regione" => 'Lombardia', "consumo" => false, "potenzaAggiunta" => $this->getPotenzaAggiunta(), 
            "personeSelected" => 3, "dimensioneCasa" => 75, "potenza" => 3, "iva" =>false];
            $consumo = new Consumo($obj);
            $this->assertInstanceOf('Consumo', $consumo);
   			
    			return $consumo;
    }

    /**
     * @depends testConstruiOggetoStima
     */

    public function testHaLaConsumoStima($objConsumo) {
            $this->assertEquals(2555, $objConsumo->getConsumo());

                return $objConsumo;
    }

    /**
     * @depends testHaLaMethodStima
     */

    public function testHaLaPropertyArrayConsumoStima ($objConsumo) {
    		$arr = $objConsumo->getArrayConsumo();
    		$this->assertTrue(is_array($arr));
    		$this->assertEquals(3, count($arr));
    		$this->assertEquals($objConsumo->getConsumo(), $arr[0]+$arr[1]+$arr[2]);
/*
    		$this->assertEquals(1533, $arr[0]);
    		$this->assertEquals(1022, $arr[1]);
    		$this->assertEquals(0, $arr[2]);
  */
    }

}