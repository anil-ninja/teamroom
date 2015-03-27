<?php
/**
 * check only [a-z] or [A-Z] present 
 *
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 15.12.2014
 */
class ValidatorNumericRange implements Validator{

	/**not Done
	 *
	 * @param string $value 
	 * @Return same value or exception 
	 */
	public function validate($value){
		if($value === null)
			throw new Exception($value.' is null');

		$regex = "/^[a-zA-Z0-9-_+.]+@[a-zA-Z0-9-_.]+\.[a-zA-Z]+$/i";

		if( !preg_match( $regex , $value ) )
				/*throw new InvalidAttributeTypeException('3100', " invalid value for $value ");*/
			throw new ValidationFailedException(get_class(), $value);
 				//throw new Exception(" invalid value for $value ");
 		else
 				return $value;
	}

}

?>