<?php
class Date {

	public static function arrayMonths() {
		return array(1=>'january', 2=>'february', 3=>'march', 4=>'april', 5=>'may', 6=>'june', 7=>'july', 8=>'august', 9=>'september', 10=>'october', 11=>'november', 12=>'december');
	}

	public static function daysMonth($month, $year) {
		return cal_days_in_month(CAL_GREGORIAN, $month, $year);
	}

	public static function nextMonth($month, $year) {
		return ($month>=12) ? array('month'=>1, 'year'=>$year+1) : array('month'=>$month+1, 'year'=>$year);
	}

	public static function prevMonth($month, $year) {
		return ($month<=1) ? array('month'=>12, 'year'=>$year-1) : array('month'=>$month-1, 'year'=>$year);
	}

	public static function textMonth($month) {
		$months = Date::arrayMonths();
		return __($months[__(intval($month))]);
	}

	public static function textMonthArray() {
		foreach (range(1,12) as $month) {
			$months[$month] = Date::textMonth($month);
		}
		return $months;
	}

	public static function textMonthArraySimple() {
		foreach (range(1,12) as $month) {
			$months[$month] = substr(html_entity_decode(Date::textMonth($month)), 0, 3);
		}
		return $months;
	}

	public static function sqlArray($date, $trim=true) {
		$result = array();
		$result['day'] = ($trim==true) ? intval(ltrim(substr($date, 8, 2),'0')) : intval(substr($date, 8, 2));
		$result['month'] = ($trim==true) ? intval(ltrim(substr($date, 5, 2),'0')) : intval(substr($date, 5, 2));
		$result['year'] = intval(substr($date, 0, 4));
		$result['hour'] = intval(substr($date, 11, 2));
		$result['minutes'] = intval(substr($date, 14, 2));
		return $result;
	}
	
	public static function sqlArrayUrl($date) {
		$result = Date::sqlArray($date);
		return $result['day'].'-'.$result['month'].'-'.$result['year'].'-'.$result['hour'].'-'.$result['minutes'];
	}

	public function sqlDate($date) {
		return substr($date, 0, 10);
	}

	public function sqlDay($date) {
		return substr($date, 8, 2);
	}

	public function sqlMonth($date) {
		return substr($date, 5, 2);
	}

	public function sqlYear($date) {
		return substr($date, 0, 4);
	}

	public function sqlTime($date) {
		return substr($date, 11, 5);
	}

	public function sqlDayMonth($date) {
		return Date::sqlDay($date).'-'.Date::sqlMonth($date);
	}

	public static function urlArraySql($url) {
		$urlArray = explode('-', $url);
		$result = array();
		$result['day'] = (isset($urlArray[0])) ? $urlArray[0] : '';
		$result['month'] = (isset($urlArray[1])) ? $urlArray[1] : '';
		$result['year'] = (isset($urlArray[2])) ? $urlArray[2] : '';
		$result['hour'] = (isset($urlArray[3])) ? $urlArray[3] : '';
		$result['minutes'] = (isset($urlArray[4])) ? $urlArray[4] : '';
		return $result;
	}

	public static function sqlInt($date) {
		$date = Date::sqlArray($date);
		return mktime($date['hour'], $date['minutes'], 0, $date['month'], $date['day'], $date['year']);
	}

	public static function sqlText($date, $withHour=false) {
		if ($date!='') {
			$dateArray = Date::sqlArray($date);
			$html = $dateArray['day'].' '.Date::textMonth($dateArray['month']).', '.$dateArray['year'];
			$html .= ($withHour) ? ' '.str_pad($dateArray['hour'], 2, "0", STR_PAD_LEFT).':'.str_pad($dateArray['minutes'], 2, "0", STR_PAD_LEFT) : '';
			return $html;
		}
	}

	public static function sqlTextSmall($date, $withHour=false) {
		if ($date!='') {
			$dateArray = Date::sqlArray($date);
			$html = $dateArray['day'].' '.substr(Date::textMonth($dateArray['month']),0,3);
			$html .= ($withHour) ? ' | '.str_pad($dateArray['hour'], 2, "0", STR_PAD_LEFT).':'.str_pad($dateArray['minutes'], 2, "0", STR_PAD_LEFT) : '';
			return $html;
		}
	}

	public static function sqlTextSimple($date, $withHour=0) {
		if ($date!='') {
			$dateArray = Date::sqlArray($date);
			$html = Text::dateNumber($dateArray['day']).'-'.Text::dateNumber($dateArray['month']).'-'.$dateArray['year'];
			$html .= ($withHour==1) ? ' '.$dateArray['hour'].':'.$dateArray['minutes'] : '';
			return $html;
		}
	}

	public static function sqlHour($date) {
		if ($date!='') {
			$dateArray = Date::sqlArray($date);
			return $dateArray['hour'].':'.$dateArray['minutes'];
		}
	}

	public static function postFormat($postValue) {
		return str_pad($_POST[$postValue.'yea'], 2, "0", STR_PAD_LEFT).'-'.str_pad($_POST[$postValue.'mon'], 2, "0", STR_PAD_LEFT).'-'.str_pad($_POST[$postValue.'day'], 2, "0", STR_PAD_LEFT);
	}
	
	public static function arrayText($date, $withHour=0) {
		if (is_array($date)) {
			$html = $date['day'].' '.Date::textMonth($date['month']).', '.$date['year'];
			$html .= ($withHour==1) ? ' | '.$dateArray['hour'].':'.$dateArray['minutes'] : '';
			return $html;
		}
	}

	public static function sqlUrl($date) {
		if ($date!='') {
			$dateArray = Date::sqlArray($date);
			$html = intval($dateArray['year']).'_'.intval($dateArray['month']).'_'.$dateArray['day'];
			return $html;
		}
	}
	
	public static function minutes($hour, $minutes) {
		return intval($hour)*60 + intval($minutes);
	}

	public static function differenceInt($dateStart, $dateEnd) {
		$start = Date::sqlInt($dateStart);
		$end = Date::sqlInt($dateEnd);
		return $end - $start;
	}

	public static function difference($dateStart, $dateEnd) {
		$difference = Date::differenceInt($dateStart, $dateEnd);
		$result = array();
		$result['hours'] = $difference/3600;
		$result['minutes'] = $difference/60;
		$result['days'] = $difference/86400;
		return $result;
	}
	
	public static function pubDate($date) {
		$values = Date::sqlArray($date);
		return date('D, d M Y H:i:s O', mktime($values['hour'], $values['minutes'], 0, $values['month'], $values['day'], $values['year']));
	}
	
	public static function pubDateToday() {
		return date('D, d M Y H:i:s O');
	}

	public function dayStartEnd($dateStartIni, $dateEndIni, $month, $year) {
		$dateStart = Date::sqlArray($dateStartIni);
		$dateEnd = Date::sqlArray($dateEndIni);
		$dateIniMonth = Date::sqlInt($year.'-'.$month.'-01 00:00:00');
		if (($dateStart['month']==$month && $dateStart['year']==$year) || ($dateEnd['month']==$month && $dateEnd['year']==$year) || ($dateIniMonth>=Date::sqlInt($dateStartIni) && $dateIniMonth<=Date::sqlInt($dateEndIni))) {
			if (Date::differenceInt($dateStartIni, $dateEndIni) < 0) {
				$dateAux = $dateStart;
				$dateStart = $dateEnd;
				$dateEnd = $dateAux;
			}
			if ($dateStart['month'] < $month) {
				$dateStart['day'] = 1;
			}
			if ($dateEnd['month'] > $month) {
				$dateEnd['day'] = Date::daysMonth($month, $year);
			}
			$results = array();
			if ($dateStart['year']!=$year && $dateEnd['year']!=$year) {
				$results = array('dayStart'=>0, 'dayEnd'=>0);
			} else {
				$results['dayStart'] = ($dateStart['year']!=$year) ? 1 : $dateStart['day'];
				$results['dayEnd'] = ($dateEnd['year']!=$year) ? Date::daysMonth($month, $year) : $dateEnd['day'];
			}
		} else {
			$results = array('dayStart'=>0, 'dayEnd'=>0);
		}
		return $results;
	}
	
}
?>