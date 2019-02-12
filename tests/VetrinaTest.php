<?php

include_once "..\php\urls.php";
include_once "..\php\Vetrina.php";

class VetrinaTest extends PHPUnit_Framework_TestCase {

    public function testPrezzoSelezionaArrayRandon() {
            $vetrina = vetrina::seleziona(["Azienda 1","Azienda 2"]);
            $this->assertEquals(1,count($vetrina));
            $this->assertContains($vetrina[0], ["Azienda 1","Azienda 2"]);
      }

}