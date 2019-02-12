<?php
 
include_once "..\php\urls.php";

class UrlsTest extends PHPUnit_Framework_TestCase {

  public function testUrlDB_const() {

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $database = "Test";

    $conn = new mysqli($servername, $username, $password, $database);

    $result = $conn->query("SHOW TABLES LIKE '".DB_AZIENDE_LUCE."'");
    $this->assertGreaterThan(0,count($result));

    $result = $conn->query("SHOW TABLES LIKE '".DB_AZIENDE_LUCE_D."'");
    $this->assertGreaterThan(0,count($result));

    $result = $conn->query("SHOW TABLES LIKE '".DB_AZIENDE_IVA."'");
    $this->assertGreaterThan(0,count($result));

    $result = $conn->query("SHOW TABLES LIKE '".DB_AZIENDE_IVA_D."'");
    $this->assertGreaterThan(0,count($result));

    $result = $conn->query("SHOW TABLES LIKE '".DB_UTENTE_PRIVATI."'");
    $this->assertGreaterThan(0,count($result));

    $result = $conn->query("SHOW TABLES LIKE '".DB_UTENTE_IVA."'");
    $this->assertGreaterThan(0,count($result));

    $result = $conn->query("SHOW TABLES LIKE '".DB_SERVIZI_AGG."'");
    $this->assertGreaterThan(0,count($result));
    
    $result = $conn->query("SHOW TABLES LIKE '".DB_FATTURAZIONE."'");
    $this->assertGreaterThan(0,count($result));

    $result = $conn->query("SHOW TABLES LIKE '".DB_REGIONE."'");
    $this->assertGreaterThan(0,count($result));

    $result = $conn->query("SHOW TABLES LIKE '".DB_ELLETRO."'");
    $this->assertGreaterThan(0,count($result));

    $result = $conn->query("SHOW TABLES LIKE '".DB_COMUNE."'");
    $this->assertGreaterThan(0,count($result));
    
    $result = $conn->query("SHOW TABLES LIKE '".DB_ACCISA."'");
    $this->assertGreaterThan(0,count($result));

    $result = $conn->query("SHOW TABLES LIKE '".DB_IVA."'");
    $this->assertGreaterThan(0,count($result));

    $result = $conn->query("SHOW TABLES LIKE '".DB_ALTRE_TASSE."'");
    $this->assertGreaterThan(0,count($result));

  }


/*    

      $result = $conn->query("SHOW TABLES");

      $risultato = $result->fetch_all(MYSQLI_ASSOC); 

      $arrayTabella = array();

      foreach ($risultato as $key => $value) {
        foreach ($value as $nome) {
          array_push($arrayTabella, $nome);
        }
      }

      $verifica = true;

      $temp = array();

      foreach ($tabellaArray as $key2 => $value2) {

            if (in_array($value2, $arrayTabella)) {

              }  
              else {
                $verifica = false;
                array_push($temp, $value2);
              }
      }


      $this->assertTrue($tabellaArray[0]);

  }
*/

}