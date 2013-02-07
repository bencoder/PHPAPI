<?php

class example_api extends controller {

	protected $api_name = "example";


	/**
		Returns data1 and data2
		@postparam: data1
		@postparam: data2
	*/
	function echo_post() {
		$d1 = $_POST["data1"];
		$d2 = $_POST["data2"];

		if (empty($d1) || empty($d2))
			return helpers::create_error(101);
		
		return helpers::create_response(array("data1" => $d1, "data2" => $d2));
	}
	
	
	/**
		Returns the first parameter in the query string
		@numparams: 1
	*/
	function echo_data($data) {
		return helpers::create_response($data);
	}

}
