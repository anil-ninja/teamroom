<?php

    interface AppCache {

        public function setIntoHash($hashName, $hashKey, $hashValue);

        public function getFromHash($hashName, $hashKey);

        public function getAllFromHash($hashName);

        public function removeFromHash($hashName, $hashKey);
    }