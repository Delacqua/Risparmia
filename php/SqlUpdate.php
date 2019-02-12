<?php

class SqlUpdate {

//scieglie tabella sql
	public function sqlUpdateDB ($tabella,$data) {

		if ($tabella == DB_AZIENDE_LUCE || $tabella == DB_AZIENDE_IVA || $tabella == DB_AZIENDE_LUCE_D || $tabella == DB_AZIENDE_IVA_D) {
			$sql = self::sqlAziendaLuce($tabella,$data);
		}

		if ($tabella == DB_AZIENDE_GAS || $tabella == DB_AZIENDE_GAS_IVA || $tabella == DB_AZIENDE_GAS_D || $tabella == DB_AZIENDE_GAS_IVA_D) {
			$sql = self::sqlAziendaGas($tabella,$data);
		}
		
		return $sql;
	}



//------------------------------------------------

	private function sqlAziendaLuce ($tabella, $data) {

		$data->serviziAgg = AdattaString::entrataArray($data->serviziAgg);
		$data->fatturazione = AdattaString::entrataArray($data->fatturazione);
		$data->regione = AdattaString::entrataArray($data->regione);
		$data->energiaVariabile = AdattaString::entrataArray($data->energiaVariabile);
		$data->transportoVariabile = AdattaString::entrataArray($data->transportoVariabile);

		$sql = "UPDATE $tabella SET 
			nome='$data->nome',
			prodotto='$data->prodotto',
			logo='$data->logo', 
			prezzo='$data->prezzo',
			f1='$data->f1',
		 	f2='$data->f2',
		 	f3='$data->f3',
		 	serviziAgg='$data->serviziAgg',
		 	fatturazione='$data->fatturazione',
		 	energiaCotaFissa='$data->energiaCotaFissa',
		 	energiaPotenza='$data->energiaPotenza',
		 	energiaVariabile='$data->energiaVariabile',
		 	transportoCotaFissa='$data->transportoCotaFissa',
		 	transportoVariabile='$data->transportoVariabile',
		 	perequazione='$data->perequazione',
		 	regione='$data->regione'
			WHERE id=$data->id";

		return $sql;
	}


	private function sqlAziendaGas ($tabella, $data) {
		$data->prezzoMateria = AdattaString::entrataArray($data->prezzoMateria);
		$data->serviziAgg = AdattaString::entrataArray($data->serviziAgg);
		$data->fatturazione = AdattaString::entrataArray($data->fatturazione);
		$data->regione = AdattaString::entrataArray($data->regione);

		$sql = "UPDATE $tabella SET 
			nome='$data->nome',
			prodotto='$data->prodotto',
			logo='$data->logo',
			prezzo='$data->prezzo',
			prezzoMateria='$data->prezzoMateria',
		 	transporto='$data->transporto',
		 	stoccaggio='$data->stoccaggio',
		 	serviziAgg='$data->serviziAgg',
		 	fatturazione='$data->fatturazione',
		 	tasseFise='$data->tasseFise',
		 	regione='$data->regione'
			WHERE id=$data->id";

		return $sql;
	}



}
