<?php
/**
 *   -------------------------------------------------------------------------
 *             PHP Form Validator (formvalidator.php)
 *             Version 1.0
 *   -------------------------------------------------------------------------
 *   Author: Md. Monjur-ul-Hasan. (M H Rasel)
 *   Email: mail@monjur-ul-hasan.info
 *   Release: 2 Nov 2009
 *   Copyright 2009
 *   Documentation: http://phpformvalidation.monjur-ul-hasan.info
 *
 *   @requires    PHP 4 >= 4.3.2
 *
 *   License: under  GNU GENERAL PUBLIC LICENSE, Version 1.0, August 2009
 *
 **/

require_once("class.validator.inc");

//create your won validator class and inharit it from the original Validator class
class ExtValidator extends Validator
{
	/** create a function with the name of your customize rule.
	 * @param mixed $con will contain the condition which can ba an array or simple variable
	 * @param mixed $value will contain the value postes via the form emelment for which you put this rule.
	 *
	 * "date2"=>array(
	 *   "LimAge"=>array(        // LimAge is an extended rules for check
	 *           "format"=>"ddmmyyyy", // other properties for this LimAge
	 *           "min"=>18,
	 *           "max"=>28
	 *           )
	 *    )
	 *   The above segment of rule array define a rule for a form element name ''date2' . the function will
	 *   get the ''LimAge' array under the $con parameter and the value of $_POST['date2'] under $value
	 *
	 *   Now you have to prepare your own body of the function.
	 *
	 *   the output of the function is either true or false.
	 *  true indicates according to the rule the value is correct
	 *  false means not correct.
	 */
	function LimAge($con,$value)
	{

		// check the date format using the bases date.
		if(!$this->date($con,$value))
		{
			//$this->_messages[LimAge] = "Invalid Age";
			return false;
		}

		$d = $value;
		if(!preg_match("/^((\d){1,2})[\/\.-]((\d){1,2})[\/\.-](\d{2,4})$/",$d,$matches))
		return false;//Bad Date Format
		$T = split("[\/\.-]",$d);
		if(is_array($con))
		{
			if(isset($con["format"]))
			$format = $con["format"];
			else $format = $this->_defaultDateFormat;   // use default format mm/dd/yy
		}
		else $format = $this->_defaultDateFormat;  // use default format mm/dd/yy
		$minAgeReq = $maxAgeReq = 0;
		if(isset($con['min']))
		$minAgeReq = $con['min'];
		if(isset($con['max']))
		$maxAgeReq = $con['max'];

		switch($format)
		{
			case "mmddyyyy":
				$M =(int) $T[0];
				$D =(int) $T[1];
				$Y =(int) $T[2];
				break;
			case "mmddyy":
				//print_r($T);
				$M =(int) $T[0];
				$D =(int) $T[1];
				$Y = (int)$T[2];
				break;
			case "ddmmyyyy":
				$D =(int) $T[0];
				$M =(int) $T[1];
				$Y = (int)$T[2];
				break;
			case "ddmmyy":
				$D =(int) $T[0];
				$M =(int) $T[1];
				$Y =(int) $T[2];
				break;
		}
		/***
		 * check for for age limit.
		 */
		$d_c = date('U');
		$d_g = mktime(1,1,1,$M,$D,$Y);
		$Y = ($d_c-$d_g)/(24*3600);
		$Y_diff = $Y/365;
		$curErr = array();
		if($minAgeReq!=0 && $Y_diff<=$minAgeReq)
		{
			$this->_messages[$this->_curElement] = "Not enough old";
			return false;
		}

		if($maxAgeReq!=0 && $Y_diff>=$maxAgeReq)
		{
			$this->_messages[$this->_curElement] = "not enough yourng";
			return false;
		}
		return true;
	}


}


?>