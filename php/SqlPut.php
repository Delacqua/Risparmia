<?php

class SqlPut {

//scieglie tabella sql
	public function sqlPutDB ($tabella,$data) {

		switch ($tabella) {
			case DB_IVA:
				$sql = self::sqlIva($tabella,$data);
				break;
			case DB_ALTRE_TASSE:
				$sql = self::sqlAltreTasse($tabella,$data);
				break;
			case DB_ACCISA:
				$sql = self::sqlAccisa($tabella,$data);
				break;
			case DB_IVA_GAS:
				$sql = self::sqlIvaGas($tabella,$data);
				break;		
			case DB_ALTRE_TASSE_GAS:
				$sql = self::sqlAtreTasseGas($tabella,$data);
				break;
		}
		
			return $sql;
	}



//------------------------------------------------

	private function sqlIva ($tabella, $data) {
		$sql = "UPDATE $tabella SET iva=$data->valore WHERE id=$data->id";	
			return $sql;
	}

	private function sqlAltreTasse ($tabella, $data) {
		$sql = "UPDATE $tabella SET nome='$data->nome', valore='$data->valore' WHERE id=$data->id";
			return $sql;
	}

	private function sqlAccisa ($tabella, $data) {
		$sql = "UPDATE $tabella SET fascia='$data->fascia' WHERE id=$data->id";
			return $sql;
	}

	private function sqlIvaGas ($tabella, $data) {
		$sql = "UPDATE $tabella SET iva=$data->valore WHERE id=$data->id";
			return $sql;
	}

	private function sqlAtreTasseGas ($tabella, $data) {
		$sql = "UPDATE $tabella SET nome='$data->nome', valore='$data->valore' WHERE id=$data->id";
			return $sql;
	}

}