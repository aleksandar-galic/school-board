<?php

namespace App\Logger;

class LogAsXML implements Logger
{
	public function render($data)
	{
		// creating object of SimpleXMLElement
		$xml_data = new \SimpleXMLElement('<?xml version="1.0"?><data></data>');

		// function call to convert array to xml
		$this->arrayToXML($data,$xml_data);

		//saving generated xml file; 
		$result = $xml_data->asXML('logs/log.xml');
	}

	private function arrayToXML($data, &$xml_data)
	{
		foreach( $data as $key => $value ) {
			if (is_array($value)) {
				if (is_numeric($key)) {
                	$key = 'item'.$key; //dealing with <0/>..<n/> issues
           		}
            	$subnode = $xml_data->addChild($key);
            	array_to_xml($value, $subnode);
        	} else {
        		$xml_data->addChild("$key",htmlspecialchars("$value"));
        	}
    	}
	}
}
