<?php
/* --------------------------------------------------
 * FILES INCLUDES
 * --------------------------------------------------
 * There are 2 ways to include a file:
 * 		$load['type'][] = 'file_name';
 *		$load['type']['folder'][] = 'file_name';
 *
 * THE ORDER OF INCLUSIONS MATTER.
 */

/* --------------------------------------------------
 * public/css/core/
 * --------------------------------------------------
 */
$load['css']['core'][] = 'bootstrap.min';
$load['css']['core'][] = 'bootstrap-theme.min';
$load['css']['core'][] = 'font-awesome.min';
$load['css']['core'][] = 'w3';
$load['css']['core'][] = 'sidebar';

/* --------------------------------------------------
 * public/css/
 * --------------------------------------------------
 */
$load['css'][] = 'style';

/* --------------------------------------------------
 * public/js/core/
 * --------------------------------------------------
 */
$load['js']['core'][] = 'angular.min';
$load['js']['core'][] = 'angular-ui-router.min';
$load['js']['core'][] = 'jquery.min';
$load['js']['core'][] = 'bootstrap.min';
$load['js']['core'][] = 'ngMask.min';
$load['js']['core'][] = 'pjsidebar';
$load['js']['core'][] = 'angular-file-upload.min';
$load['js']['core'][] = 'w3';

/* --------------------------------------------------
 * public/js/
 * --------------------------------------------------
 */
$load['js'][] = 'app';
$load['js'][] = 'config';
$load['js'][] = 'directives';

/* --------------------------------------------------
 * public/js/controllers/
 * --------------------------------------------------
 */
$load['js']['controllers'][] = 'HomeController';
