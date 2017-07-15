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

/**
 * Establishes the inheritance basis for all models instantiated
 * in the execution of controllers.
 *
 * Models are objects that defines the communication with the
 * database. Selections, insertions, updates and deletes basic
 * functions are defined in Model class and all other variants and
 * specifics database interactions are made by Model childs in
 * models folder.
 *
 * All models must be instantiated as properties of a controller
 * and will be used by them to transmit the product of the logic
 * of the methods to the database.
 *
 * 
 * @package		<PROJECT_NAME>
 * @subpackage	Core
 * @author 		<AUTHOR>
 * @link		<DOC_LINK>
 */
class Model
{
	/**
	 * An instance of mysqli class.
	 *
	 * @var object
	 */
	public $conn;

	/**
	 * The result of executing a query.
	 *
	 * @var int|array|null
	 */
	private $result;

	/**
	 * Init the Model::conn and echo an error in
	 * connection if it exists.
	 */ 
	function __construct(){
		$this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($this->conn->connect_error){
			die(json_encode(array('success'=> 0, 'error'=> "<h1>CONNECTION ERROR #".$this->conn->connect_errno."</h1>".$this->conn->connect_error)));
		}
		/*UTF-8 Configs*/
		$this->conn->query("SET NAMES 'utf8'");
		$this->conn->query('SET character_set_connection=utf8');
		$this->conn->query('SET character_set_client=utf8');
		$this->conn->query('SET character_set_results=utf8');
	}

	/**
	 * Return the Model::result. If an id was specified, return only the array with that id.
	 *
	 * @param 	int 	$id 	The id to filter the results in Model::result.
	 * @return 	int|array|null
	 */
	public function get_result($id = NULL){
		if(is_null($id)){
			return $this->result;
		}
		elseif(is_array($this->result)) {
			foreach ($this->result as $value) {
				#Index 0 of $keys is suposed to be the column id.
				$keys = array_keys($value);
				if($value[$keys[0]] == $id){
					return $value;
				}
			}
			/* If the above return was not reached, the
			 * array does not contain the specified id.
			 */
			return NULL;
		}
	}

	/**
	 * Set all non numeric values of an array to 'value'.
	 *
	 * @param 	array 	$data 	Array that will have its values parsed.
	 *
	 * @return 	array 	Return all values in an indexed array.
	 */
	protected function parse_values($data){
		$return = array();
		foreach ($data as $value) {
			$return[] = (is_numeric($value))?$value:"'$value'";
		}
		return $return;
	}

	/**
	 * Execute the query and echos on screen any error.
	 * Set the Model::result to the number of affected rows.
	 * 
	 * @param	string 	$sql 	The query to be executed.
	 * @param 	int 	$resultmode 	Default param of mysqli::query() method.
	 *
	 * @return 	object|null 	Returns the result of the last query.
	 */
	public function query($sql, $resultmode = MYSQLI_STORE_RESULT){
		$query = $this->conn->query($sql, $resultmode);
		$this->result = $this->conn->affected_rows;

		if($this->conn->error){
			echo "<h1>SQL ERROR #".$this->conn->errno."</h1>".$this->conn->error;
		}
		return $query;
	}

	/**
	 * Update the database using the keys of array parameter
	 * as columns and the values as values.
	 *
	 * @param 	string 	$table 	Clause to select the target table.
	 * @param 	string 	$where 	Clause to filter the query result.
	 *
	 * @param 	string|array 	$columns 	Set the columns that will be in the query.
	 *
	 * @return 	bool 	Return a boolean acording with the rolls affecteds by the query.
	 */
	public function select($table, $where='', $columns='*'){
		if(is_array($columns)){
			$columns = implode(',', $columns);
		}
		$sql = "SELECT $columns FROM $table $where";
		$query = $this->query($sql);

		if($this->conn->affected_rows > 1){
			$this->result = array();
			while($temp = $query->fetch_assoc()) {
				$this->result[] = $temp;
			}
		}
		else{
			$this->result = $query->fetch_assoc();
		}
		return ($this->result)?TRUE:FALSE;
	}

	/**
	 * Insert a new row in the table using the $data array keys
	 * as columns and values as values. Also sets the Model::result
	 * to the id of the new row. 
	 *
	 * @param 	string 	$table 	Clause to select the target table.
	 * @param 	array 	$data 	Data to be inserted in the table columns.
	 *
	 * @return 	bool 	Return a boolean acording to the success of the query.
	 */
	public function insert($table, $data){
		$columns = array_keys($data);
		$columns = implode(',', $columns);

		$values = $this->parse_values($data);
		$values = implode(',', $values);

		$sql = "INSERT INTO $table ($columns) VALUES ($values)";

		# mysqli::query() return bool on INSERT statement
		$query_success = $this->query($sql);

		# Change the Model::result from affected rows to the new id
		$this->result = $this->conn->insert_id;

		return $query_success;
	}

	/**
	 * Update the database using the keys of array parameter
	 * as columns and the values as values.
	 *
	 * @param 	string 	$table 	Clause to select the target table.
	 * @param 	array 	$data 	Data to be changed in the table columns.
	 * @param 	string 	$where 	Clause to limit the query action range.
	 *
	 * @return 	bool 	Return a boolean acording with the rolls affecteds by the query.
	 */
	public function update($table, $data, $where){
		$columns_change = array();
		foreach ($data as $key => $value) {
			#Change to 'value' all non numerics
			$value = (is_numeric($value))?$value:"'$value'";
			$columns_change[]= $key."=".$value;
		}
		$columns_change=implode(',', $columns_change);

		$sql = "UPDATE $table SET $columns_change $where";

		$this->query($sql);
		#Model::query() automatically set Model::result to the number of affected rows. 
		return ($this->result)?TRUE:FALSE;
	}

	/**
	 * Delete the rows of the specified table that fit the WHERE clause.
	 *
	 * @param 	string 	$table 	Clause to select the target table.
	 * @param 	string 	$where 	Clause to limit the query action range.
	 *
	 * @return 	bool 	Return a boolean acording with the rolls affecteds by the query.
	 */
	public function delete($table, $where){
		$sql = "DELETE FROM $table $where";
		$this->query($sql);
		#Model::query() automatically set Model::result to the number of affected rows. 
		return ($this->result)?TRUE:FALSE;
	}
}
