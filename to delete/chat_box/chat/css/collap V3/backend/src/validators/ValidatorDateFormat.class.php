<?php
/**
 * check yyyy-mm-dd present 
 *
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 15.12.2014
 */
class ValidatorDateFormat implements Validator{

	/**not Done
	 *
	 * @param string $value 
	 * @Return same value or exception 
	 */
	public function validate($value){
		if($value === null)
			throw new Exception($value.' is null');

		if (($timestamp = strtotime($value)) === false) {
    		throw new Exception($value.' is invalid time');

		} 
    	
    	$value =  date('Y-m-d', $timestamp);
		
		$regex = "/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/i";
		//yyyy-mm-dd
		if( !preg_match( $regex , $value ) ){
 				//throw new Exception(" invalid value for $value ");
				/*throw new ValidationFailedException(get_class(), $value);*/
				throw new ValidationFailedException(get_class(), $value);
 			}
 		else
 				return $value;
	}

}


?>