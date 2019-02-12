<?php

include_once "..\php\urls.php";
include_once "..\php\AdattaString.php";

class AdattaStringTest extends PHPUnit_Framework_TestCase {

    public function testConvertireArrayToStringDB() {
            $arr = [0, 12, 55, 30];
            $strDB = "0#12#55#30";
            $this->assertEquals(AdattaString::entrataArray($arr),$strDB);
      }

    public function testConvertireStringToStringDB() {
            $str = "0, 12, 55, 30";
            $strDB = "0#12#55#30";
            $this->assertEquals(AdattaString::entrataString($str),$strDB);
    }

    public function testConvertireStringToStringDB2() {
            $str = "0,12, 55,30";
            $strDB = "0#12#55#30";
            $this->assertEquals(AdattaString::entrataString($str),$strDB);
    }

    public function testConvertireStringDB_to_String() {
            $str = "0, 12, 55, 30";
            $strDB = "0#12#55#30";
            $this->assertEquals($str,AdattaString::uscitaInline($strDB));
    }

    public function testConvertireStringDB_to_String2() {
            $str = "0, nome - aaa, 55, 30";
            $strDB = "0#nome - aaa#55#30";
            $this->assertEquals($str,AdattaString::uscitaInline($strDB));
    }

    public function testConvertireStringDB_to_Array() {
            $arr = [0, 12, 55, 30];
            $strDB = "0#12#55#30";
            $this->assertEquals($arr,AdattaString::uscitaArray($strDB));
    }


}