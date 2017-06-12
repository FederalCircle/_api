<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

class Test extends Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load_model('test_model');
		$this->load_lib('test_lib');
	}

	public function test(){

	}


}
?>
