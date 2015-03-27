<?php

	/**
     * @author rajnish
     */

    interface Resource {
        
        public function checkIfRequestMethodValid ($requestMethod);

        public function delete ($resourceVals, $data, $userId);

        public function put ($resourceVals, $data, $userId);

        public function post ($resourceVals, $data, $userId);

        public function get ($resourceVals, $data, $userId);
    }
