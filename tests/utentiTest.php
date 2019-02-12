<?php

include_once "..\php\urls.php";


class utentiTest extends PHPUnit_Framework_TestCase {

    public function testUrlUpdate() {
        $url = 'http://127.0.0.1/prova/sito/php/update.php';
        $array = get_headers($url);
        $string = $array[0];
        $this->assertTrue(strpos($string,"200")!==false);
      }

    public function testAggiungeUtentiPrivati () {
        $url = 'http://127.0.0.1/prova/sito/php/update.php';

        $utente = (object) ['nome'=>'classTest', 'cognome' => 'TestClass', 'telefono' => '333443344', 'fornitore' => 'Enel', 
        'accetta' => true,'comune' => 'milano', 'regione' => 'Lombardia'];

        $data = (object) ['tabella' => DB_UTENTE_PRIVATI, 'item'=> $utente];

        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n" . "Accept: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );

        $context  = stream_context_create($options);
        $postdata = file_get_contents($url, false, $context);
        $array = get_headers($postdata);
        $string = $array[0];

        $this->assertTrue(strpos($string,"200")!==false);
        $this->assertEquals($postdata,"email");
        

    }

    public function testAggiungeUtentiIva () {
        $url = 'http://127.0.0.1/prova/sito/php/update.php';

        $utente = (object) ['ragioneSociale'=>'classTest','telefono' => '333443344', 'accetta' => true,'comune' => 'milano', 
        'regione' => 'Lombardia', 'iva' => true];

        $data = (object) ['tabella' => DB_UTENTE_PRIVATI, 'item' => $utente];

        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n" . "Accept: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );

        $context  = stream_context_create($options);
        $postdata = file_get_contents($url, false, $context);
        $array = get_headers($postdata);
        $string = $array[0];

        $this->assertTrue(strpos($string,"200")!==false);
        $this->assertEquals($postdata,"email");

    }

    public function testAggiungeUtentiPrivatiEscapeString () {
        $url = 'http://127.0.0.1/prova/sito/php/update.php';

        $utente = (object) ['nome'=>'classTest2', 'cognome' => 'a 1*1 / [ { b', 'telefono' => '1+1', 'fornitore' => 'Enel', 
        'accetta' => true,'comune' => 'milano', 'regione' => 'Lombardia'];

        $data = (object) ['tabella' => DB_UTENTE_PRIVATI, 'item' => $utente];

        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n" . "Accept: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );

        $context  = stream_context_create($options);
        $postdata = file_get_contents($url, false, $context);
        $array = get_headers($postdata);
        $string = $array[0];

        $this->assertTrue(strpos($string,"200")!==false);
        $this->assertEquals($postdata,"email");

    }

    public function testUrlConsultaUtenti() {
        $url = 'http://127.0.0.1/prova/sito/php/consultaDB.php/'.DB_UTENTE_PRIVATI;
        $array = get_headers($url);
        $string = $array[0];
        $this->assertTrue(strpos($string,"200")!==false);
      }


    public function testVerificaUtentiPrivati () {
        $url = 'http://127.0.0.1/prova/sito/php/consultaDB.php/'.DB_UTENTE_PRIVATI;
        $postdata = file_get_contents($url,false);
        $postdata = json_decode($postdata);

        $utenti = [];        

        foreach ($postdata as $value) {
            if ($value->nome == "classTest") {
                $utenti[0] = $value;
            }

            if ($value->nome == "classTest2") {
                $utenti[1] = $value;
            }
        }


        $this->assertEquals(2,count($utenti));

            return $utenti;
    }

    /**
     * @depends testVerificaUtentiPrivati
     */

    public function testVerificaUtentiPrivatiDati ($utenti) {
        $this->assertEquals("classTest",$utenti[0]['nome']);
        $this->assertEquals("TestClass",$utenti[0]['cognome']);
        $this->assertEquals("333443344",$utenti[0]['telefono']);
        $this->assertEquals("Enel",$utenti[0]['fornitore']);
        $this->assertEquals(true,$utenti[0]['accetta']);
        $this->assertEquals("milano",$utenti[0]['comune']);
        $this->assertEquals("Lombardia",$utenti[0]['regione']);

            return $utenti;
    }

    /**
     * @depends testVerificaUtentiPrivati
     */

    public function testVerificaUtentiPrivatiEscapeString ($utenti) {
        $this->assertEquals(false,strpos($utenti[1]['cognome'],"*"));
        $this->assertEquals(false,strpos($utenti[1]['cognome'],"/"));
        $this->assertEquals(false,strpos($utenti[1]['cognome'],"["));
        $this->assertEquals(false,strpos($utenti[1]['cognome'],"{"));

    }



}