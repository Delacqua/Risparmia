angular.module('blueAppUrls',[])
.constant('route','../') //Route DB 
.constant('getAziende','php/aziende.php') //PHP consulta Aziende Luce
.constant('aluce','sito_aziendeluce') //nome della tabella Aziende Luce
.constant('aluceD','sito_aziendelucedestaque') //nome della tabella Aziende Luce in Evidenza
.constant('aluceI','sito_aziendeluceiva') //nome della tabella Aziende Luce IVA
.constant('aluceID','sito_aziendelucedestaque') //nome della tabella Aziende Luce IVA in Evidenza
.constant('updateAzienda','php/updateAzienda.php') //PUT, POST e DELETE aziende
.constant('updateUtente','php/update.php') //Aggiunge nuovi Utente
.constant('utenti','php/utenti.php') //Aggiorna Utenti 
.constant('utentePrivati','sito_utenteprivati') //tabella utente privati
.constant('utenteRichiama','sito_utenterichiama') //tabella utente privati
.constant('utenteIva','sito_utenteiva') //tabella utente iva
.constant('serviziUrl','php/servizi.php') //PUT, POST e DELETE servizi e fatturazione
.constant('servizi','sito_serviziagg') //tabella servizi
.constant('fatturazione','sito_fatturazione') //tabella fatturazione
.constant('getAltri','php/consultaDB.php') //Get: Regione, Comune, elettrodomestici, servizi, fatturazione, iva, accisa, altretasse, utenti
.constant('regione','sito_regione') //tabella regione
.constant('elettro','sito_elettrodomestici') //Tabella elettrodomestici
.constant('comune','sito_comune') //Tabella comune
.constant('getImposte','php/imposte.php') //PUT, POST e DELETE l'imposte
.constant('accisa','sito_accisa') //Tabella accisa
.constant('altritasse','sito_altritasse') //Tabella altritasse
.constant('iva','sito_iva') //Tabella altritasse
.constant('login','php/verifica.php') //Tabella login
.service('$urls',function(getAziende,aluce,aluceD,aluceI,aluceID,updateAzienda,utenti,utentePrivati,utenteIva,utenteRichiama,serviziUrl,servizi,fatturazione,getAltri,
    regione,elettro,comune,getImposte,accisa,altritasse,iva,route,updateUtente,login){ 
    this.route = route;
    this.getAziende = getAziende;
    this.aluce = aluce;
    this.aluceD = aluceD;
    this.aluceI = aluceI;
    this.aluceID = aluceID;
    this.updateAzienda = updateAzienda;
    this.updateUtente = updateUtente;
    this.utenti = utenti;
    this.utentePrivati = utentePrivati;
    this.utenteIva = utenteIva;
    this.utenteRichiama = utenteRichiama;
    this.serviziUrl = serviziUrl;
    this.servizi = servizi;
    this.fatturazione = fatturazione;
    this.getAltri = getAltri;
    this.regione = regione;
    this.elettro = elettro;
    this.comune = comune;
    this.getImposte = getImposte;
    this.accisa = accisa;
    this.altritasse = altritasse;
    this.iva = iva;
    this.login = login;
})
.constant('getAziendeGas','php/aziende.php') //PHP consulta Aziende Gas
.constant('agas','sito_aziendegas') //nome della tabella Aziende Luce
.constant('agasD','sito_aziendegasdestaque') //nome della tabella Aziende Luce in Evidenza
.constant('agasI','sito_aziendegasiva') //nome della tabella Aziende Luce IVA
.constant('agasID','sito_aziendegasdestaque') //nome della tabella Aziende Luce IVA in Evidenza
.constant('updateAziendaGas','php/updateAzienda.php') //PUT, POST e DELETE aziende
.constant('regioneGas','sito_regionegas') //nome della tabella Regione Gas
.constant('ivaGas','sito_ivagas') //nome della tabella Regione Gas
.constant('altriTasseGas','sito_altritassegas') //nome della tabella Regione Gas
.constant('elettroGas','sito_elettrodomesticigas') //Tabella elettrodomestici
.service('$urlsGas',function(getAziendeGas,agas,agasD,agasI,agasID,updateAziendaGas,regioneGas,ivaGas,altriTasseGas,elettroGas){ 
    this.getAziendeGas = getAziendeGas;
    this.agas = agas;
    this.agasD = agasD;
    this.agasI = agasI;
    this.agasID = agasID;
    this.updateAziendaGas = updateAziendaGas;
    this.regioneGas = regioneGas;
    this.ivaGas = ivaGas;
    this.altriTasseGas = altriTasseGas;
    this.elettroGas = elettroGas;
});