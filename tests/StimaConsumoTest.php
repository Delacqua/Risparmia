<?php

include_once "..\php\urls.php";
include_once "..\php\luce\StimaConsumo.php";

class StimaConsumoTest extends PHPUnit_Framework_TestCase {

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


    public function testFormatoUscita() {

        $stimaConsumo = new StimaConsumo();
        $arrayStima = $stimaConsumo->stima(3, 75, $this->getPotenzaAggiunta());
        $this->assertTrue(is_array($arrayStima));
        $this->assertInternalType('int', $arrayStima['consumo']);
        $this->assertInternalType('int', $arrayStima['f1']);
        $this->assertInternalType('int', $arrayStima['f2']);
        $this->assertInternalType('int', $arrayStima['f3']);
    }

    public function testValoreF1eF2eF3() {

        $stimaConsumo = new StimaConsumo();
        $arrayStima = $stimaConsumo->stima(3, 75, $this->getPotenzaAggiunta());

        $this->assertEquals($arrayStima['consumo'],$arrayStima['f1']+$arrayStima['f2']+$arrayStima['f3']);
  }

    public function testArrayPotenzaAggiunta1() {

        $potenzaAggiunta = $this->getPotenzaAggiunta();
        $stimaConsumo = new StimaConsumo();
        $arrayStimaP = $stimaConsumo->stima(3, 75, $potenzaAggiunta);

        foreach ($potenzaAggiunta as $key => $value) {
            if ($value->selezionato) {
                $potenzaAggiunta[$key]->selezionato = false;
            }

        }

        $stimaConsumo = new StimaConsumo();
        $arrayStimaS = $stimaConsumo->stima(3, 75, $potenzaAggiunta);

        $this->assertEquals($arrayStimaS['consumo']+990, $arrayStimaP['consumo']);
  
    }


    public function test_6_Persone() {

        $stimaConsumo = new StimaConsumo();
        $arrayStimaP = $stimaConsumo->stima(3, 75, $this->getPotenzaAggiunta());

        $stimaConsumo = new StimaConsumo();
        $arrayStimaS = $stimaConsumo->stima(6, 75, $this->getPotenzaAggiunta());

        $this->assertGreaterThan($arrayStimaS['consumo'], $arrayStimaP['consumo']+1320);
  
    }
  
}