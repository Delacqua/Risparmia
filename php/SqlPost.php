<?php

class SqlPost {

//scieglie tabella sql
	public function sqlPostDB ($tabella,$data) {

		switch ($tabella) {
			case DB_ALTRE_TASSE:
			case DB_ALTRE_TASSE_GAS:
				$sql = self::sqlAltreTasse($tabella,$data);
				break;
			case DB_ACCISA:
				$sql = self::sqlAccisa($tabella,$data);
				break;
			case DB_AZIENDE_LUCE:
			case DB_AZIENDE_LUCE_D:
			case DB_AZIENDE_IVA:
			case DB_AZIENDE_IVA_D:
				$sql = self::sqlAziendaLuce($tabella,$data);
				break;
			case DB_AZIENDE_GAS:
			case DB_AZIENDE_GAS_D:
			case DB_AZIENDE_GAS_IVA:
			case DB_AZIENDE_GAS_IVA_D:
				$sql = self::sqlAziendaGas($tabella,$data);
				break;
		}
		
			return $sql;
	}



//------------------------------------------------

	private function sqlAltreTasse ($tabella, $data) {
		$sql = "INSERT INTO $tabella (nome,valore) VALUES ('$data->nome', '$data->valore')";
			return $sql;
	}

	private function sqlAccisa ($tabella, $data) {
		$sql = "INSERT INTO $tabella (fascia) VALUES ('$data->fascia')";
			return $sql;
	}

	private function sqlAziendaLuce ($tabella, $data) {
		$data->serviziAgg = AdattaString::entrataArray($data->serviziAgg);
		$data->fatturazione = AdattaString::entrataArray($data->fatturazione);
		$data->regione = AdattaString::entrataArray($data->regione);
		$data->energiaVariabile = AdattaString::entrataArray($data->energiaVariabile);
		$data->transportoVariabile = AdattaString::entrataArray($data->transportoVariabile);

		$sql = "INSERT INTO $tabella
			(nome, prodotto, logo, prezzo, f1, f2, f3, serviziAgg, fatturazione, energiaCotaFissa, energiaPotenza, energiaVariabile, transportoCotaFissa, transportoVariabile, perequazione, regione)
			VALUES 
            ('$data->nome', '$data->prodotto', '$data->logo', '$data->prezzo', '$data->f1', '$data->f2', '$data->f3','$data->serviziAgg', '$data->fatturazione', '$data->energiaCotaFissa', '$data->energiaPotenza','$data->energiaVariabile','$data->transportoCotaFissa', '$data->transportoVariabile', '$data->perequazione', '$data->regione')";

		return $sql;
	}

	private function sqlAziendaGas ($tabella, $data) {
		$data->prezzoMateria = AdattaString::entrataArray($data->prezzoMateria);
		$data->serviziAgg = AdattaString::entrataArray($data->serviziAgg);
		$data->fatturazione = AdattaString::entrataArray($data->fatturazione);
		$data->regione = AdattaString::entrataArray($data->regione);

		$sql = "INSERT INTO $tabella 
			(nome, prodotto, logo, prezzo, prezzoMateria, transporto, stoccaggio, serviziAgg, fatturazione, tasseFise, regione)
			VALUES
			('$data->nome', '$data->prodotto', '$data->logo','$data->prezzo', '$data->prezzoMateria', '$data->transporto', '$data->stoccaggio', '$data->serviziAgg', '$data->fatturazione', '$data->tasseFise', '$data->regione')";

		return $sql;
	}

}
