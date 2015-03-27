<?php 

    /**
     * @author Jessy James
     */

    require_once 'ApiException.class.php';

    class UnauthorizedException extends ApiException {

        function __construct ($previous = null) {

            parent::__construct(
                /* Code */              '1000', 
                /* Custom Message */    null, 
                /* Previous */          $previous
            );
        }
    }