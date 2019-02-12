<?php

include_once "..\php\gas\PrezzoGas.php";
include_once "..\php\Database.php";
include_once "..\php\gas\DatabaseGas.php";
include_once "..\php\urls.php";
include_once "..\php\AdattaString.php";
include_once "..\php\DividereFascia.php";

class PrezzoGasTest extends PHPUnit_Framework_TestCase {

    public function testSetPrezzoGas() {
            $prezzoGas = new PrezzoGas();
            $prezzoGas->setConsumo(500);
            $prezzoGas->setPrezzoMateria([0.2,0.2,0.2,0.2,0.2,0.2,0.2,0.2,0.2]);
            $prezzoGas->setTransporto(0.05,0.05);
            $prezzoGas->setRegione("Umbria");

            $this->assertInstanceOf('prezzoGas', $prezzoGas);

                return $prezzoGas;
      }

    /**
     * @depends testSetPrezzoGas
     */

    public function testPrezzoExpandFormato($prezzoGas) {
            $prezzoExpand = $prezzoGas->getPrezzoExpand();

            $this->assertInternalType('float', $prezzoExpand->prezzoT);
            $this->assertInternalType('float', $prezzoExpand->prezzoMateria);
            $this->assertInternalType('float', $prezzoExpand->transporto);
            $this->assertInternalType('float', $prezzoExpand->imposte);
            $this->assertInternalType('float', $prezzoExpand->iva);
    }

    /**
     * @depends testSetPrezzoGas
     */

    public function testPrezzoExpandValore($prezzoGas) {
            $prezzoExpand = $prezzoGas->getPrezzoExpand();

            $this->assertEquals(423.81042, $prezzoExpand->prezzoT);
            $this->assertEquals(40, $prezzoExpand->prezzoMateria);
            $this->assertEquals(4, $prezzoExpand->transporto);
            $this->assertEquals(4.84, $prezzoExpand->imposte);
            $this->assertEquals(40, $prezzoExpand->iva);
    }

}