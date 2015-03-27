<?php
/**
 * Intreface Validator
 *
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 11.12.2014
 */
interface Validator{

	/**
	 *
	 * @param value validate according to implemantation
	 * @Return same value or null 
	 */
	public function validate($value);

}

?>