<?php

class AdattaString {

//put string with a separator # from Array
	public function entrataArray ($todosArray) {
		$stringDb = implode('#', $todosArray);
		return $stringDb;
	}

//put string with a separator # from string
	public function entrataString ($todosString) {
		$stringDb = str_replace(',','#', $todosString);
		$stringDb = str_replace('# ','#', $stringDb);
		$stringDb = str_replace(' #','#', $stringDb);
		return $stringDb;
	}

//get string with a separator # and transform in html   -------------------   Deprecated
	public function uscitaHtml ($todosString) {
		$pieces = explode("#", $todosString);
		foreach ($pieces as $key => $value) {
			$pieces[$key] = "<li>" . $value . "</li>";
		}
		$stringHtml = implode(' ', $pieces);
		
		return $stringHtml;
	}

//get string with a separator # and transform in string
	public function uscitaInline ($todosString) {
		$pieces = explode("#", $todosString);
		foreach ($pieces as $key => $value) {
			$pieces[$key] = $value . ", ";
		}
		$stringInline = implode('', $pieces);
		$stringInline = rtrim($stringInline,', ');
		
		return $stringInline;
	}

//get string with a separator # and transform in array
	public static function uscitaArray ($todosString) {
			$pieces = explode("#", $todosString);
			return $pieces;
	}

}

