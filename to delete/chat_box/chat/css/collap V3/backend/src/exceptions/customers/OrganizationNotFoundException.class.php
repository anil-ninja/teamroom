    <?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class OrganizationNotFoundException extends ApiException {

        function __construct ($orgId, $previous = null) {

            parent::__construct(
                /* Code */              '7005', 
                /* Message */           isset($orgId) ? "Organization with org_id '$orgId' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }