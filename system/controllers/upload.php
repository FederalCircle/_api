<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

class Upload extends Controller{

	function __construct(){
		parent::__construct();
	}

	public function test(){

	}

	public function upload(){
		if ( !empty( $_FILES ) ) {

		    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
		    $uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $_FILES[ 'file' ][ 'name' ];

		    move_uploaded_file( $tempPath, $uploadPath );

        $this->return['msg'] = 'File transfer completed';

		} else {

		    $this->setMessage('No files.');

		}
	}

}
?>
