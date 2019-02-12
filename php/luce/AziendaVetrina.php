<?php

class AziendaVetrina extends AziendaFornitori {

    private $quantitaEsibe;
    private $comuneEvidenza;

    public function __construct($objDB,$objConsumo) {
       parent::__construct($objDB,$objConsumo);
       $this->quantitaEsibe = $objDB['quantitaEsibe'];
       $this->comuneEvidenza = $objDB['comuneEvidenza'];

    }


//----------------- set / get 

    function getQuantitaEsibe () {
        return $this->quantitaEsibe;
    }

    function getComuneEvidenza () {
        return $this->comuneEvidenza;
    }


}
