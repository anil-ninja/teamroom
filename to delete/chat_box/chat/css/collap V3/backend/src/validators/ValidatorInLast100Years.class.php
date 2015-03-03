<?php
/**
 * check only [a-z] or [A-Z] present 
 *
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 15.12.2014
 */
class ValidatorInLast100Years implements Validator{

	/**not Done
	 *
	 * @param string $value 
	 * @Return same value or exception 
	 */
	public function validate($value){
		if($value === null)
			throw new Exception($value.' is null');

		

		if( $this->getYears($value) <= 100 )
 				return $value;
  		else
  				/*throw new InvalidAttributeTypeException('3100', " invalid value for $value ");*/
            throw new ValidationFailedException(get_class(), $value);
 				//throw new Exception(" invalid value for $value ");	
	}

	private function getYears($date) {
    	$date_ts = strtotime($date);
    	$date_year = date('Y', $date_ts);
    	$years = date('Y') - $date_year;
    	if(strtotime('+' . $years . ' years', $date_ts) > time()) $years--;
    	return $years;
	
	}

}

?>