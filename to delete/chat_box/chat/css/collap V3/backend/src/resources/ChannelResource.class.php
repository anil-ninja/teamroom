<?php

	/**
     * @author Jessy James
     */

    require_once 'resources/Resource.interface.php';
    require_once 'dao/DAOFactory.class.php';
    require_once 'models/Channel.class.php';
    require_once 'models/SourceTypes.class.php';
    require_once 'exceptions/MissingParametersException.class.php';
    require_once 'exceptions/MalformedRequestDataException.class.php';
    require_once 'exceptions/UnsupportedResourceMethodException.class.php';
    require_once 'resources/IntouchCustomfieldsResource.class.php';

    class ChannelResource implements Resource {

        private $channelDAO;
        private $channels;

        public function __construct () {
            $DAOFactory     = new DAOFactory();
            $this -> channelDAO = $DAOFactory -> getChannelsDAO();
        }
        
        public function checkIfRequestMethodValid ($requestMethod) {
            return in_array($requestMethod, array ('get', 'put', 'post', 'delete'));
        }

        public function delete ($resourceVals, $data) {
            global $logger, $warnings_payload; 
            $channelName = $resourceVals ['channels'];

            if (! isset($channelName)) {
                $warnings_payload [] = 'DELETE call to /channels must be succeeded ' .  
                                            'by /channel_name i.e. DELETE /channels/channel_name';
                throw new UnsupportedResourceMethodException();
            }
            $logger -> debug ("Delete channel with name: " . $channelName);-
            
            $result = $this -> channelDAO -> delete($channelName);
            $logger -> debug ("Channel Deleted? " . $result);

            if ($result) 
                $result = array('code' => '2003');
            else 
                $result = array('code' => '2004');

            return $result;
        }

        public function put ($resourceVals, $data) {
            global $logger, $warnings_payload;
            $update = false;
            
            $channelName = $resourceVals ['channels'];
            if (! isset($channelName)) {
                $warnings_payload [] = 'PUT call to /channels must be succeeded ' . 
                                        'by /channel_name i.e. PUT /channels/channel_name';
                throw new UnsupportedResourceMethodException();
            }
            if (! isset($data))
                throw new MissingParametersException('No fields specified for updation');

            $channelObj = $this -> channelDAO -> read('name', $channelName);

            if(! is_object($channelObj)) 
                return array('code' => '2004');

            $newDescription = $data ['description'];
            if (isset($newDescription)) {
                if ($newDescription != $channelObj -> getSources()) {
                    $update = true;
                    $channelObj -> setDescription($newDescription);
                }
            }

            $newSources = $data ['sources'];
            if (isset($newSources)) {
                if ($newSources != $channelObj -> getSources()){
                    $update = true;
                    $channelObj -> setSources($newSources);
                }
            }

            if ($update) {
                $logger -> debug('PUT Channel object: ' . $channelObj -> toString());
                $result = $this -> channelDAO -> update($channelObj);
                $logger -> debug('Updated entry: ' . $result);
            }

            $channel = $channelObj -> toArray();
            $this -> channels [] = $channel;

            if(! isset($channel ['id'])) 
                return array('code' => '2004');

            return array('code' => '2002', 
                            'data' => array(
                                'channels' => $this -> channels
                            )
            );
        }

        public function post ($resourceVals, $data) {
            global $logger, $warnings_payload;

            $channelName = $resourceVals ['channels'];
            if (isset($channelName)) {
                $warnings_payload [] = 'POST call to /channels must not have ' . 
                                            '/channel_name appended i.e. POST /channels';
                throw new UnsupportedResourceMethodException();
            }

            $this -> sanitize($data);

            $channelObj = new Channel($data ['name'], $data ['description'], $data ['sources']);
            $logger -> debug ("POSTed Channel: " . $channelObj -> toString());

            $this -> channelDAO -> create($channelObj);
            $channel = $channelObj -> toArray();

            if(! isset($channel ['id'])) 
                return array('code' => '2011');

            $this -> channels[] = $channel;
            return array ('code' => '2001', 
                            'data' => array(
                                'channels' => $this -> channels
                            )
            );
        }

        public function get ($resourceVals, $data) {
            $channelName = $resourceVals ['channels'];

            if (isset ($channelName)) 
                $result = $this -> getChannelDetails($channelName);

            else 
                $result = $this -> getListOfAllChannels();

            return $result;
        }

        private function getListOfAllChannels() {
            global $logger;
            $logger -> debug ('Fetch list of channels with their details...');
            
            $listOfChannelObjs = $this -> channelDAO -> readAll();

            if(empty($listOfChannelObjs)) 
                return array('code' => '2004');

            foreach ($listOfChannelObjs as $channelObj) {
                $channel = $channelObj -> toArray();
                $this -> channels [] = $channel;
            }
            $logger -> debug ('Fetched list of Channels: ' . json_encode($this -> channels));

            return array('code' => '2000', 
                            'data' => array(
                                'channels' => $this -> channels
                            )
            );
        }

        private function getChannelDetails($channelName) {
            global $logger; 
            $logger -> debug ('Fetch Channel Details with channel_name: ' . $channelName);
            $channelObj = $this -> channelDAO -> read('name', $channelName);

            if(empty($channelObj)) 
                return array('code' => '2004');
            
            $channel = $channelObj -> toArray();
            $this -> channels [] = $channel;
            $logger -> debug ('Fetched Channel: ' . json_encode($this -> channels));

            return array('code' => '2000', 
                            'data' => array(
                                'channels' => $this -> channels
                            )
            );
        }

        private function sanitize ($data) {
            if (! isset($data ['name'])) 
                throw new MissingParametersException ("Channel 'name' field is missing");

            if (! isset($data ['description'])) 
                throw new MissingParametersException ("Channel 'description' field is missing");

            if (empty($data ['name'])) 
                throw new MissingParametersException ("Channel 'name' field cannot be empty");

            if (! ctype_alpha($data ['name']))
                throw new MalformedRequestDataException("Channel 'name' field must be an alphabetic value");

            $sources = $data['sources'];
            if (isset($sources) && !is_array($sources)) {
                throw new MalformedRequestDataException(
                    "Channel's 'sources' field must be an array of source-names");
            } else if (isset($sources) && is_array($sources)) {
                foreach ($sources as $sourceName) {
                    $isValid = SourceTypes::isValidName($sourceName);
                    if (! $isValid) {
                        throw new MalformedRequestDataException("Channel's source '$sourceName' is invalid; " . 
                        "Source names must be one of '" . join(', ', SourceTypes::getConstants()) . "'");
                    }
                }
            }
        }
    }