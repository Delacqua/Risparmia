<?php
 
include_once "..\php\urls.php";


class ConsultaAziendeTest extends PHPUnit_Framework_TestCase {

    public function testUrlConsultaSito() {
        $url = 'http://127.0.0.1/prova/sito/php/aziende.php/'.DB_AZIENDE_LUCE;
        $array = get_headers($url);
        $string = $array[0];
        $this->assertTrue(strpos($string,"200")!==false);
  
      }  

    public function testConsultaAngularSito() {
      $url = 'http://127.0.0.1/prova/sito/php/aziende.php/'.DB_AZIENDE_LUCE;

      $data = (object) ['regione'=>'Lombardia', 'consumo' => 1200, 'f1' => 600, 'f2' => 600, 'f3' => 0,'potenza' => 3,'iva' => false];

        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n" . "Accept: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );

        $context  = stream_context_create($options);
        $postdata = file_get_contents($url, false, $context);
        $result = json_decode($postdata);


        $this->assertGreaterThan(1, count($result));
        $this->assertInternalType('string', $result[0]->nome);
        $this->assertInternalType('string', $result[0]->prodotto);
        $this->assertTrue(is_array($result[0]->fatturazioneE));
        $this->assertTrue(is_array($result[0]->serviziE));

        $prezzo = $result[0]->prezzoE;

        $this->assertInternalType('float', $prezzo->prezzoT);
  }


    public function testConsultaAngularDB() {

        $postdata = file_get_contents('http://127.0.0.1/prova/sito/php/aziende.php/'.DB_AZIENDE_LUCE);

        $result = json_decode($postdata);

        $this->assertGreaterThan(1, count($result));
        //$this->                  dataIni

            return $result;
  }


    /**
     * @depends testConsultaAngularDB
     */

    public function testConsultaAngularDBNome($result) {
        $this->assertInternalType('string', $result[0]->nome);
        $this->assertInternalType('string', $result[0]->prodotto);
    }

    /**
     * @depends testConsultaAngularDB
     */

    public function testConsultaAngularDBRegione($result) {
        $this->assertTrue(is_array($result[0]->getRegione()));
    }

    /**
     * @depends testConsultaAngularDB
     */

    public function testConsultaAngularDBPrezzo($result) {
        $this->assertTrue(is_array($result[0]->prezzo));
        $this->assertInternalType('float', $result[0]->prezzo[0]);
        $this->assertStringMatchesFormat('%f', $result[0]->f1);
        $this->assertStringMatchesFormat('%f', $result[0]->f2);
        $this->assertStringMatchesFormat('%f', $result[0]->f3);
    }

    /**
     * @depends testConsultaAngularDB
     */

    public function testConsultaAngularDBValoriDiversi($result) {
        $this->assertInternalType('float', $result[0]->energiaCotaFissa);
        $this->assertInternalType('float', $result[0]->energiaPotenza);
        $this->assertTrue(is_array($result[0]->energiaVariabile));
        $this->assertStringMatchesFormat('%f', $result[0]->energiaVariabile[0]);
        $this->assertTrue(is_array($result[0]->transportoVariabile));
        $this->assertStringMatchesFormat('%f', $result[0]->transportoVariabile[0]);
        $this->assertInternalType('float', $result[0]->transportoCotaFissa);
        $this->assertInternalType('int', $result[0]->perequazione);
    }


    /**
     * @depends testConsultaAngularDB
     */

    public function testConsultaAngularDBSevizi($result) {
        $this->assertTrue(is_array($result[0]->serviziAgg));
        $this->assertTrue(is_array($result[0]->fatturazione));
    }


    public function testUrlConsultaAngularVetrina() {

        $postdata = file_get_contents('http://127.0.0.1/prova/sito/php/aziende.php/'.DB_AZIENDE_LUCE_D);

        $result = json_decode($postdata);

        $this->assertGreaterThan(1, count($result));
        //$this->                  dataIni
      }


}