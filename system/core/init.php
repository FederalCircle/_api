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

/* --------------------------------------------------
 * CONFIGS IMPORT
 * --------------------------------------------------
 */
require_once 'config.php';

/* --------------------------------------------------
 * READING URL
 * --------------------------------------------------
 */
$url = explode('/', $_SERVER['REQUEST_URI']);
array_shift($url);
array_shift($url);
if($_SERVER['HTTP_HOST']=='localhost') array_shift($url);
if(empty($url[count($url)-1])){
	unset($url[count($url)-1]);
}

/* -----------------------------
 * READING URL 2.0 need testing
 * ------------------------------
*/

// $url = explode('/', $_SERVER['REQUEST_URI']);
// $i;
// for($i = 0;$i < count($url);$i++){
// 	if($url[0] == 'system'){
// 		array_shift($url);
// 		break;
// 	}
// 	array_shift($url);
// }
// if(empty($url[count($url)-1])){
// 	unset($url[count($url)-1]);
// }

/* --------------------------------------------------
 * LOADING FILES/OBJECTS/METHODS
 * --------------------------------------------------
 */
require_once CORE_PATH.'Controller.php';

if(isset($url[0])){
	#Load the controller
	if(file_exists(CONTROLLERS_PATH.$url[0].'.php')){
		require_once CONTROLLERS_PATH.$url[0].'.php';
		$_CONTROLLER = new $url[0];

		#Execute the controller method
		if(isset($url[1])){
			if(method_exists($_CONTROLLER, $url[1])){
				call_user_method($url[1], $_CONTROLLER);
			}
			else echo 'The '.CONTROLLERS_PATH.'<strong>'.$url[0].'.php</strong>'.' Class does not have <strong>'.$url[1].'( )</strong> method.';
		}
	}
	else echo 'The file '.CONTROLLERS_PATH.'<strong>'.$url[0].'.php</strong>'.' does not exist.';
}
