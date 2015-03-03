<?php
/**
 * check only [a-z] or [A-Z] present 
 *
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 15.12.2014
 */
class ValidatorAlphanumericSpecialChar implements Validator{

	/**not Done
	 *
	 * @param string $value 
	 * @Return same value or exception 
	 */
	public function validate($value){
		if($value === null)
			throw new Exception($value.' is null');

		$regex = "/^[0-9a-zA-Z\s\r\n@!#\$\^%&*()+=\-\[\]\\\';,\.\/\{\}\|\":<>\?]+$/i";
		
		if( !preg_match( $regex , $value ) )
 				//throw new Exception(" invalid value for $value ");
				/*throw new InvalidAttributeTypeException('3101', " invalid value for $value ");*/
			throw new ValidationFailedException(get_class(), $value);
 		else
 				return $value;
	}

}

?>