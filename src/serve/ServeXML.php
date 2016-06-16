<?php
namespace web\ws\rest\serve {
    class ServeXML implements IServe
    {
    	private function writeElements($writer, array $data) {
    		foreach ($data as $key => $value) {
    			$writer->startElement($key);

    			if (is_array($value)) {
    				$this->writeElements($writer, $value);
    			} else if (is_object($value))  {
                    $this->writeElement($writer, $value);
                } else {
    				$writer->text($value);
    			}

    			$writer->endElement();
    		}
    	}

        private function writeElement($writer, $data) {
            $writer->startElement(get_class($data));

            foreach ($data as $prop => $value) {
                $writer->startElement($prop);

                if (is_array($value)) {
                    $this->writeElements($writer, $value);
                } else if (is_object($value)) {
                    $this->writeElement($writer, $value);
                } else {
                    $writer->text($value);
                }

                $writer->endElement();
            }

            $writer->endElement();
        }

        public function serveContent($data): string
        {
        	$writer = new \XmlWriter();
    		$writer->openMemory();
        	$writer->setIndent(true);

        	$writer->startDocument('1.0', 'UTF-8');
        	
        	if (is_array($data)) {
        		$writer->startElement('array');
        		$this->writeElements($writer, $data);
        	} else if (is_object($data)) {
                $writer->startElement(get_class($data));
                $this->writeElement($writer, $data);
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

        public function getContentType(): string {
        	return 'application/xml';
        }

        public function processContent($data): \SimpleXMLElement {
            // TODO: into objects and/or arrays
        	return new \SimpleXMLElement($data);
        }
    }
}
?>
