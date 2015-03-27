<?php

/**
 * check only [a-z] or [A-Z] present 
 *
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 11.12.2014
 */
class ValidatorAlphabetic implements Validator {

    /**
     *
     * @param string $value 
     * @Return same value or null 
     */
    public function validate($value) {
	if ($value === null)
	    throw new Exception($value . ' is null');

	$regex = "/^[a-zA-Z\s]+$/";

	if (!preg_match($regex, $value)) {
	    //throw new Exception(" invalid value for $value ");
	    /*throw new InvalidAttributeTypeException('3100', " invalid value for $value ");*/
        throw new ValidationFailedException(get_class(), $value);
	} else {
	    return $value;
	}
    }

}

?>