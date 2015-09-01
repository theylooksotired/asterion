<?php
class Csv {

	static public function toArrays($fileName) {
		$csv = Csv::loadData($fileName);
		$arrays = array();
		$header = true;
		foreach (preg_split("/((\r?\n)|(\r\n?))/", $csv) as $line){
			if ($header) {
				$headers = explode(';', $line);
				$header = false;
			} else {
				$info = explode(';', $line);
				$arrayIns = array();
				$arrayInsCounter = 0;
				foreach ($headers as $headersItem) {
					$arrayIns[$headersItem] = $info[$arrayInsCounter];
					$arrayInsCounter++;
				}
				array_push($arrays, $arrayIns);
			}
		} 
		return $arrays;
	}

	static public function loadData($fileName) {
		$file = APP_FILE.'data/'.$fileName.'.csv';
		if (is_file($file)) {
			return file_get_contents($file);
		}
	}

}
?>