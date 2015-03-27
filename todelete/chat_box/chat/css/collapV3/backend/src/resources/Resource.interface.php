<?php

	/**
     * @author Jessy James
     */

    interface Resource {
        
        public function checkIfRequestMethodValid ($requestMethod);

        public function delete ($resourceVals, $data);

        public function put ($resourceVals, $data);

        public function post ($resourceVals, $data);

        public function get ($resourceVals, $data);
    }
