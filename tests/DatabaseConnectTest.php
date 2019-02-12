<?php
 
require_once "..\php\Database.php";


class DatabaseConnectTest extends PHPUnit_Framework_TestCase {

  public function testPrendeTabellaComune() {
    $connObj = new Database();
    $tabella = 'comune';
    $this->assertTrue($connObj->prendeTabella($tabella) !== false);
  }

  public function testVerificaLogin() {
    $connObj = new Database();
    $tabella = 'login';
    $login = 'ciccio';
    $password = $connObj->prendeTabella($tabella)[0]['password'];
    $this->assertEquals($password,'ciccio');
  }

  public function testFailVerificaLogin() {
    $connObj = new Database();
    $tabella = 'login';
    $login = 'ciccio';
    $password = $connObj->prendeTabella($tabella)[0]['password'];
    $this->assertFalse($password ==='ciccio2');
  }

  public function testPrendeTabella() {
    $connObj = new Database();
    $tabella = 'iva';
    $iva = $connObj->prendeTabella($tabella)[0];
    $this->assertArrayHasKey('iva', $iva);
  }

  public function testFailNomeTabellaSbagliato() {
    $connObj = new Database();
    $tabella = 'iva2';
    $emess = null;
        try {
            $connObj->prendeTabella($tabella);
        } catch (Exception $e) { $emess = $e->getMessage(); }
        $this->assertEquals($emess, "MySQL error, tabella non encontrata: $tabella");
  }

  public function testAggiungeUpdateDelete () {
    $connObj = new Database();
    $tabella = 'iva';
    $nome = 'iva';
    $valore = 0.25;
    $valoreUpdate = 0.3;
    $sql = "INSERT INTO $tabella ($nome) VALUES ('$valore')"; 
    $id = $connObj->aggiunge2($sql)->id;
    $this->assertGreaterThan(1, $id);

    $sqlU = "UPDATE $tabella SET iva='$valoreUpdate' WHERE id=$id"; 
    $risposta = $connObj->aggiornaTabella2($sqlU);
    $this->assertEquals("Aggiornato", $risposta);

    $risposta = $connObj->delete($tabella, $id);
    $this->assertEquals("Eliminato con successo", $risposta);

  }  

}