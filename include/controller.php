<?php

class controller {
	public $data = array();

	public function run($args) {
		$func = array_shift($args); //get the first argument as the function to call, $args becomes the arguments to that function
		if (!$func)
			$func = "docs";
		
		try {
			//call the function with the remaining arguments
			return call_user_func_array(array($this,$func), $args);
		} catch(Exception $e) {
			return false;
		}
		return false;
	}

	//this will be called if we try and access a function that doesn't exist
	//changes the fatal error to be not so fatal :)
    public function __call($name, $args)
    {
        throw new Exception('Undefined method ' . $name . '() called');
    }
    
    private function getDocTags($str, $tag = '') {
		if (empty($tag)) {
			return array();
		}

		$matches = array();
		$match_count = preg_match_all("/".$tag.":(.*)(\\r\\n|\\r|\\n)/U", $str, $matches);
		if ($match_count == 0) {
			return array();
		}
		
		$matches_result = array();
		foreach($matches[1] as $match) {
			$matches_result[] = trim($match);
		}

		return $matches_result;
	}
    
    public function docs() {
    	$class_name = get_class($this);
    	$reflector = new ReflectionClass($class_name);
    	$ref_methods = $reflector->getMethods();
		$methods = array();
    	foreach($ref_methods as $ref_method) {
    		$doc = $ref_method->getDocComment();
    		if ($doc != "") {
    			$method = array();
				$method["docs"] = helpers::cleandoc($doc);
    			$method["name"] = $ref_method->getName();
				$method["postparams"] = $this->getDocTags($doc, 'postparam');
				$numparams = $this->getDocTags($doc, 'numparams');
				if (count($numparams) > 0) { 
					$method["numparams"] = $numparams[0];
				} else {
					$method["numparams"] = 0;
				}
				
	    		$methods[] = $method;
    		}
    	}
    	
    	$api_name = $this->api_name;
    	
    	include("doc_template.php");
    	
    	exit();
    }
}
