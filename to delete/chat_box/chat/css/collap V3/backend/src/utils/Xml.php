<?php

require_once "utils/XML/Serializer.php";

class Xml extends Base {
	private $logger;
	private $serializer;

	function __construct() {
		global $logger;
		$this->logger = $logger;

		$this->serializer = false;
	}

	function setupSerializer($addDecl = TRUE, $rootName = 'root', $defaultTagName = 'item'){

		if($this->serializer == false){
			$serializer_options = array (
			   'addDecl' => $addDecl,
			   'encoding' => 'ISO-8859-1',
			   'indent' => '  ',
			   'rootName' => $rootName,
			   'defaultTagName' => $defaultTagName, //each row is an item
			);

			$this->serializer = new XML_Serializer($serializer_options);
		}

	}

	/**
	 * @param $data
	 * @param $clear_data Clear the data variable
	 * @return unknown_type
	 */
	function serialize(&$data, $clear_data = false, $rootName = 'root', $addDecl = TRUE) {
		//serialize an array
		$serializer_options = array (
	   'addDecl' => $addDecl,
	   'encoding' => 'ISO-8859-1',
	   'indent' => '  ',
	   'rootName' => $rootName,
	   'defaultTagName' => 'item',
		);
		// Instantiate the serializer with the options
		$Serializer = new XML_Serializer($serializer_options);
		// Serialize the data structure

		try {
			//$this->logger->debug("Serializing into XML:".print_r($data, true));
			$status = $Serializer->serialize($data);

			//Clear the original data if set
			if($clear_data)
			$data = array();

			//$this->logger->debug("Serialization Status: ".var_export($status, true));
			// Check whether serialization worked
			if (PEAR::isError($status)) {
				$this->logger->error("Error in XML serialization: ".var_export($status, true));
				die($status->getMessage());
			}
			//echo "here";//var_dump($Serializer);
			//echo "Status: $status";
		} catch (Exception $e) {
			$this->logger->error("Exception in serialization: ".var_export($e, true));
		}
		// Display the XML document
		return  $Serializer->getSerializedData();
	}

	/**
	 * Try to emulate SAX type serialization, because otherwise it goes out of memory
	 * @param $data
	 * @param $output Sets the output to this variable
	 * @param $clear_data If set, $data is cleared once serialization is done
	 * @return unknown_type
	 */
	function serializeLowMemory(&$data, &$output, $clear_data = false, $batch_size = 1000) {

		if($this->serializer == false){
			$serializer_options = array (
			   'addDecl' => FALSE,
			   'encoding' => 'ISO-8859-1',
			   'indent' => '  ',
			   'rootName' => 'item',
			   'defaultTagName' => 'item', //each row is an item
			);

			$this->serializer = new XML_Serializer($serializer_options);
		}


		list($temp_file_name, $http) = Util::getTemporaryFile('xml-serialize', 'xml');

		$this->logger->debug("Using temporary file for XML Serialization: $temp_file_name");

		$fh = fopen($temp_file_name, 'w');
		fwrite($fh, "<?xml version='1.0' encoding='ISO-8859-1'?>\n<root>\n");

		if (Util::is_assoc($data)) {

			foreach ($data as $top_level_tag_key => &$data_value) {

				$first = true;

				fwrite($fh, "<$top_level_tag_key>\n");
				if (is_array($data_value)) {
					$count = 0; $string = "";
					$timer = new Timer('SerializationTimer');
					$timer->start();
					foreach ($data_value as $second_level_key => &$second_level_value) {
						$string .= $this->serializeXml($second_level_value)."\n";
						$count++;
						if ($count % $batch_size == 0){

							$timer->stop();

							fwrite($fh, $string);
							$string = "";
							$this->logger->debug("$top_level_tag_key > Serialized upto row - ".$count++.". Time Taken : ".$timer->getLastLapTime()."s. Current Memory usage: ".(memory_get_usage()/1000000)."MB");

							$timer->start();
						}

						if($first){
							$this->logger->debug("$top_level_tag_key > XML Serialization Sample Data : Key is $second_level_key\nValue is ".print_r($second_level_value, true));
							$first = false;
						}
						//if clear data is set, clear the second level value
						if($clear_data)
						$second_level_value = false;

						//fflush($fh);
					}

					//the last batch might not be complete
					if($string != ""){

						$timer->stop();

						fwrite($fh, $string);
						$string = "";
					}

				}
				fwrite($fh, "</$top_level_tag_key>\n");

				if($clear_data)
				$data_value = false;
			}
		}
		fwrite($fh, "\n</root>");
		fclose($fh);

		$output = file_get_contents($temp_file_name);
	}

	public function serializeXml($data) {

		try {

			$status = $this->serializer->serialize($data);

			if (PEAR::isError($status)) {
				$this->logger->error("Error in XML serialization: ".var_export($status, true));
				die($status->getMessage());
			}
		} catch (Exception $e) {
			$this->logger->error("Exception in serialization: ".var_export($e, true));
		}

		return $this->serializer->getSerializedData();
	}

	static function parse($xml_string) {
		try {
			$xml_element = new SimpleXMLElement($xml_string);
			return $xml_element;
		} catch (Exception $e) {
			return array();
		}
	}
}
?>
