<?php

/**
 * ValidatorFactory
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 20.12.2014
 */



class ValidatorFactory{

	public static function get($validatorName) {

        switch ($validatorName) {

        	case 'ValidatorAlphabetic': 
        		$validatorObj = self  :: getValidatorAlphabetic();
            break;
			case 'ValidatorDateFormat': 
				$validatorObj = self  :: getValidatorDateFormat();
        	break;
        	case 'ValidatorInLast100Years': 
        		$validatorObj = self  :: getValidatorInLast100Years();
        	break;
        	case 'ValidatorNumber': 
        		$validatorObj = self  :: getValidatorNumber();
        	break;
        	case 'ValidatorAlphanumericSpecialChar': 
        		$validatorObj = self  :: getValidatorAlphanumericSpecialChar();
        	break;
        	case 'ValidatorDomain': 
        		$validatorObj = self  :: getValidatorDomain();
        	break;
        	case 'ValidatorMaritalStatusList': 
        		$validatorObj = self  :: getValidatorMaritalStatusList();
        	break;
        	case 'ValidatorNumericRange': 
        		$validatorObj = self  :: getValidatorNumericRange();
        	break;
        	case 'ValidatorArrayOfString': 
        		$validatorObj = self  :: getValidatorArrayOfString();
        	break;
        	case 'ValidatorEmail': 
        		$validatorObj = self  :: getValidatorEmail();
        	break;
        	case 'ValidatorMobileNo': 
        		$validatorObj = self  :: getValidatorMobileNo();
        	break;
        	case 'ValidatorString': 
        		$validatorObj = self  :: getValidatorString();
        	break;
        	case 'ValidatorBoolean': 
        		$validatorObj = self  :: getValidatorBoolean();
        	break;
        	case 'ValidatorEnum': 
        		$validatorObj = self  :: getValidatorEnum();
        	break;
        	case 'ValidatorNoSpace': 
        		$validatorObj = self  :: getValidatorNoSpace();
        	break;
        	case 'ValidatorUrl': 
        		$validatorObj = self  :: getValidatorUrl();
        	break;
        	case 'ValidatorExternalId': 
        		$validatorObj = self  :: getValidatorExternalId();
        	break;
        	case 'ValidatorNotNegative': 
        		$validatorObj = self  :: getValidatorNotNegative();
        	break;
        	case 'ValidatorCountryList': 
        		$validatorObj = self  :: getValidatorCountryList();
        	break;
        	case 'ValidatorNotNull': 
        		$validatorObj = self  :: getValidatorNotNull();
        	break;
        	default:
                require_once 'exceptions/validators/FieldValidatorNotFoundException.class.php';
                throw new FieldValidatorNotFoundException('name', $validatorName);
            break;
        }

    	return $validatorObj;
    }
	
	/**
	 * @return ValidatorAlphabetic
	 */
	public static function getValidatorAlphabetic(){
        require_once('Validator.class.php');
		require_once('ValidatorAlphabetic.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');
		
		return new ValidatorAlphabetic();
	}

	/**
	 * @return ValidatorDateFormat
	 */
	public static function getValidatorDateFormat(){
        require_once('Validator.class.php');
		require_once('ValidatorDateFormat.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');

		return new ValidatorDateFormat();
	}

	/**
	 * @return ValidatorInLast100Years
	 */
	public static function getValidatorInLast100Years(){
        require_once('Validator.class.php');
		require_once('ValidatorInLast100Years.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');
		return new ValidatorInLast100Years();
	}

	/**
	 * @return ValidatorNumber
	 */
	public static function getValidatorNumber(){
        require_once('Validator.class.php');
		require_once('ValidatorNumber.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');
		return new ValidatorNumber();
	}

	/**
	 * @return ValidatorAlphanumericSpecialChar
	 */
	public static function getValidatorAlphanumericSpecialChar(){
        require_once('Validator.class.php');
		require_once('ValidatorAlphanumericSpecialChar.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');

		return new ValidatorAlphanumericSpecialChar();
	}

	/**
	 * @return ValidatorDomain
	 */
	public static function getValidatorDomain(){
        require_once('Validator.class.php');
		require_once('ValidatorDomain.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');

		return new ValidatorDomain();
	}

	/**
	 * @return ValidatorMaritalStatusList
	 */
	public static function getValidatorMaritalStatusList(){
        require_once('Validator.class.php');
		require_once('ValidatorMaritalStatusList.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');

		return new ValidatorMaritalStatusList();
	}

	/**
	 * @return ValidatorNumericRange
	 */
	public static function getValidatorNumericRange(){
        require_once('Validator.class.php');
		require_once('ValidatorNumericRange.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');

		return new ValidatorNumericRange();
	}

	/**
	 * @return ValidatorArrayOfString
	 */
	public static function getValidatorArrayOfString(){
        require_once('Validator.class.php');
		require_once('ValidatorArrayOfString.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');
		
		return new ValidatorArrayOfString();
	}

	/**
	 * @return ValidatorEmail
	 */
	public static function getValidatorEmail(){
        require_once('Validator.class.php');
		require_once('ValidatorEmail.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');
		
		return new ValidatorEmail();
	}

	/**
	 * @return ValidatorMobileNo
	 */
	public static function getValidatorMobileNo(){
        require_once('Validator.class.php');
		require_once('ValidatorMobileNo.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');

		return new ValidatorMobileNo();
	}

	/**
	 * @return ValidatorString
	 */
	public static function getValidatorString(){
        require_once('Validator.class.php');
		require_once('ValidatorString.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');
		
		return new ValidatorString();
	}

	/**
	 * @return ValidatorBoolean
	 */
	public static function getValidatorBoolean(){
        require_once('Validator.class.php');
		require_once('ValidatorBoolean.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');
		
		return new ValidatorBoolean();
	}

	/**
	 * @return ValidatorEnum
	 */
	public static function getValidatorEnum(){
        require_once('Validator.class.php');
		require_once('ValidatorEnum.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');

		return new ValidatorEnum();
	}

	/**
	 * @return ValidatorNoSpace
	 */
	public static function getValidatorNoSpace(){
        require_once('Validator.class.php');
		require_once('ValidatorNoSpace.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');

		return new ValidatorNoSpace();
	}

	/**
	 * @return ValidatorUrl
	 */
	public static function getValidatorUrl(){
        require_once('Validator.class.php');
		require_once('ValidatorUrl.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');

		return new ValidatorUrl();
	}

	/**
	 * @return ValidatorExternalId
	 */
	public static function getValidatorExternalId(){
        require_once('Validator.class.php');
		require_once('ValidatorExternalId.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');

		return new ValidatorExternalId();
	}

	/**
	 * @return ValidatorNotNegative
	 */
	public static function getValidatorNotNegative(){
        require_once('Validator.class.php');
		require_once('ValidatorNotNegative.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');

		return new ValidatorNotNegative();
	}

	/**
	 * @return ValidatorCountryList
	 */
	public static function getValidatorCountryList(){
        require_once('Validator.class.php');
		require_once('ValidatorCountryList.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');

		return new ValidatorCountryList();
	}

	

	/**
	 * @return ValidatorNotNull
	 */
	public static function getValidatorNotNull(){
        require_once('Validator.class.php');
		require_once('ValidatorNotNull.class.php');
        require_once('exceptions/validators/ValidationFailedException.class.php');
		
		return new ValidatorNotNull();
	}

}
?>
