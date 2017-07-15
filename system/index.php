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

/* --------------------------------------------------
 * FOLDERS NAMES
 * --------------------------------------------------
 * Folders names used to define constant paths in
 * system folder. If any folder inside system folder
 * had its name changed and not changed here, the
 * system will not work.
 *  
 */
$core_folder = 'core';

$controllers_folder = 'controllers';

$libraries_folder = 'libraries';

$models_folder = 'models';

/* --------------------------------------------------
 * DEFINITION OF SOURCE PATHS
 * --------------------------------------------------
 */
define('SYSTEM_FOLDER', end(explode(DIRECTORY_SEPARATOR, dirname(__FILE__))));

define('BASE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

if(is_dir($core_folder)){
	define('CORE_PATH', BASE_PATH.$core_folder.DIRECTORY_SEPARATOR);
}
else die(json_encode(array('success'=> 0, 'error'=> 'Core folder was not set correctly.')));

if(is_dir($controllers_folder)){
	define('CONTROLLERS_PATH', BASE_PATH.$controllers_folder.DIRECTORY_SEPARATOR);
}
else die(json_encode(array('success'=> 0, 'error'=> 'Controllers folder was not set correctly.')));

if(is_dir($libraries_folder)){
	define('LIB_PATH', BASE_PATH.$libraries_folder.DIRECTORY_SEPARATOR);
}
else die(json_encode(array('success'=> 0, 'error'=> 'Libraries folder was not set correctly.')));

if(is_dir($models_folder)){
	define('MODELS_PATH', BASE_PATH.$models_folder.DIRECTORY_SEPARATOR);
}
else die(json_encode(array('success'=> 0, 'error'=> 'Models folder was not set correctly.')));

/* --------------------------------------------------
 * 
 * --------------------------------------------------
 */
require_once CORE_PATH.'init.php';
?>