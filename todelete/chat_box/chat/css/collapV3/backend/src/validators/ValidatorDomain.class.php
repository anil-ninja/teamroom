<?php
/**
 * check only [a-z] or [A-Z] present 
 *
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 15.12.2014
 */
class ValidatorDomain implements Validator{

	/**not Done
	 *
	 * @param string $value 
	 * @Return same value or exception 
	 */
	public function validate($value){
		if($value === null)
			throw new Exception($value.' is null');

		$domain = $this->getDomainFromEmail($value);

		$acceptedDomains = array("yahoo.com", "gmail.com", "ymail.com", "yahoo.in", "yahoo.co.in", "mail.com");
		
		if (in_array($domain, $acceptedDomains)) {
    		return $value;
		}

		//throw new Exception(" invalid value for $value ");
 		/*throw new InvalidAttributeTypeException('3100', " invalid value for $value ");*/
 		throw new ValidationFailedException(get_class(), $value);
 				
	}

	private function getDomainFromEmail($email){
		// Get the data after the @ sign
		
		return substr(strrchr($email, "@"), 1);

	}

}

?>