<?php
/**
 * <PROJECT_NAME>
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright 2017, Poli Júnior Engenharia
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	<PROJECT_NAME>
 * @author <AUTHOR>
 * @copyright 2017, <COPYRIGHT>
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link <REPOSITORY_LINK>
 */

defined('BASE_PATH') OR exit('No direct script access allowed');

# Imports the parents of the objects that will be loaded
require_once CORE_PATH.'Model.php';
require_once CORE_PATH.'Lib.php';


/**
 * Establishes the inheritance basis for all controllers instantiated
 * in the execution of the system.
 *
 * Different from others MVC's frameworks, here controllers are used
 * to make the hard logic that frontend javascript can't, sensive data,
 * database communication, validation and confirmation of infos, are
 * hadled in a controller.
 *
 * @package		<PROJECT_NAME>
 * @subpackage	Core
 * @author 		<AUTHOR>
 * @link		<DOC_LINK>
 */
class Controller
{
	/**
	 * Each key is the name of an Model object,
	 * each value is an instance of it.
	 * Ex.: $this->model['myModel'] = new myModel();
	 *
	 * @var array
	 */
	protected $model = array();

	/**
	 * Each key is the name of an Lib object, each
	 * value is an instance of it.
	 * Ex.: $this->lib['myLib'] = new myLib();
	 *
	 * @var array
	 */
	protected $lib = array();

	/**
	 * Instace of an object received by JSON from
	 * the frontend AngularJS.
	 *
	 * @var object
	 */
	private $post;

	/**
	 * Variable to be returned to frontend.
	 *
	 * @var array
	 */
	protected $return;


	protected $modelname;

	function __construct(){
		session_start();
		$this->post = json_decode(file_get_contents("php://input"));
		$this->return = array('success' => TRUE, 'error' => "");
	}

	/**
	 * On the end of script execution, echo the encode
	 * of whatever is set to Controller::return.
	 */
	function __destruct(){
		if(isset($this->return)){
			 echo json_encode($this->return);
		}
	}

	/*
	 * ----------------------
	 * Saving some time by setting success to false and just entering the message on error
	 *
	*/
	public function setMessage($message){
		$this->return['success'] = FALSE;
		$this->return['error'] .= $message;
	}

	/**
	 * If there's no $index, return an array with
	 * the post received.
	 * If is defined $index, check if the post
	 * received from the front end has the property
	 * and then return it.
	 *
	 * @param 	string 	$index The property name to be searched in Model::post.
	 *
	 * @return 	mixed 	Property received by JSON from the frontend.
	 */

	public function get_post($index = NULL){
		if(isset($this->post)){
			if(is_null($index)){
				$properties = get_object_vars($this->post);
				$post = array();
				foreach ($properties as $name => $value) {
					$post[$name] = $this->post->$name;
				}
				return $post;
			}
			else if(property_exists($this->post, $index)){
				return $this->post->$index;
			}
			else {
				echo "<strong>WARNING:</strong> $index was not found in JSON post.".PHP_EOL;
				return NULL;
			}
		}
		else {
			echo "<strong>WARNING:</strong> JSON post is not set.".PHP_EOL;
			return NULL;
		}
	}

	/**
	 * Set an key in Controller::model that points
	 * to an instance of a Model child in models
	 * folder.
	 *
	 * @param 	string 	$file 	Name of the file to be searched in models folder.
	 *
	 * @return object Return an instance of the model loaded.
	 */
	public function load_model($file){
		if(file_exists(MODELS_PATH.$file.'.php')){
			require_once MODELS_PATH.$file.'.php';
			$this->model[$file] = new $file;
		}
		return $this->model[$file];
	}

	/**
	 * Set an key in Controller::lib that points
	 * to an instance of a Lib child in libraries
	 * folder.
	 *
	 * @param 	string 	$file 	Name of the file to be searched in libraries folder.
	 *
	 * @return object Return an instance of the lib loaded.
	 */
	public function load_lib($file){
		if(file_exists(LIB_PATH.$file.'.php')){
			require_once LIB_PATH.$file.'.php';
			$this->lib[$file] = new $file;
		}
		return $this->lib[$file];
	}

	public function validateData($data){
		return is_null($data);
	}

	public function add($table, $where, $field){
		$data = $this->get_post();

		//Non valid content on data array
		if($this->validateData($data)){
			$this->setMessage('Data not set.');
			return;
		}

		$status = $this->model[$this->modelname]->select($table, $where . $data[$field] . "'");

		//Already exists
		if($status){
			$this->setMessage('Already exists.');
			return;
		}

		//Adding a new object
		$status = $this->model[$this->modelname]->insert($table, $data);

		if(!$status){
			$this->setMessage('Error during insert process.');
			return;
		}

	}
	public function remove($data, $table){

		if(is_null($data)){
			$this->return['success'] = FALSE;
			$this->return['error'] .= 'Data not match.';
			return;
		}

		$status = $this->model[$this->modelname]->delete($table, "WHERE id = '" . $data . "'");

		if(!$status){
			$this->return['success'] = FALSE;
			$this->return['error'] .= "Erro ao deletar, nao existe!";
			return;
		}

	}
	public function update($table){
		$data = $this->get_post();

		if(is_null($data)){
			$this->return['success'] = FALSE;
			$this->return['error'] .= 'Data not match.';
			return;
		}

		$status = $this->model[$this->modelname]->select($table, "WHERE id = '" . $data[id] . "'");

		if(!$status){
			$this->return['success'] = FALSE;
			$this->return['error'] .= 'Nao existe.';
			return;
		}

		$status = $this->model[$this->modelname]->update($table, $data, "WHERE id = '" . $data['id'] . "'");

		if(!$status){
			$this->return['success'] = FALSE;
			$this->return['error'] .= 'Erro no update.';
			return;
		}
	}

}
