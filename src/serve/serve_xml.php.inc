<?php
namespace ws\rest\serve;

require_once("serve.php.inc");
require_once("src/exception/internal_server_exception.php.inc");

class ServeXML implements IServe
{
	private function writeElements($writer, array $data) {
		foreach ($data as $key => $value) {
			$writer->startElement($key);

			if (is_array($value)) {
				$this->writeElements($writer, $value);
			} else {
				$writer->text($value);
			}

			$writer->endElement();
		}
	}

    public function serveContent($data)
    {
    	$writer = new \XmlWriter();
		$writer->openMemory();
    	$writer->setIndent(true);

    	$writer->startDocument('1.0', 'UTF-8');
    	
    	if (is_array($data)) {
    		$writer->startElement('array');
    		$this->writeElements($writer, $data);
    	} else {
    		$writer->startElement('data');
    		$writer->text($data);
    	}
    	
    	$writer->endElement();
    	$writer->endDocument();

    	$output = $writer->outputMemory();
    	unset($writer);

    	return $output;
    }

    public function getContentType() {
    	return 'application/xml';
    }

    public function processContent($data) {
    	return new \SimpleXMLElement($data);
    }
}
?>
