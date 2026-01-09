<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin'] = 'admin/index';
$route['admin/users'] = 'admin/users';
$route['admin/users/(:num)'] = 'admin/user_details/$1';
$route['admin/users/toggle_status/(:num)'] = 'admin/toggle_user_status/$1';
$route['admin/users/delete/(:num)'] = 'admin/delete_user/$1';

// Routes pour chef de projet
$route['project_manager'] = 'project_manager/index';
$route['project_manager/projects'] = 'project_manager/projects';
$route['project_manager/create_project'] = 'project_manager/create_project';
$route['project_manager/project_details/(:num)'] = 'project_manager/project_details/$1';
$route['project_manager/delete_project/(:num)'] = 'project_manager/delete_project/$1';
$route['project_manager/create_task/(:num)'] = 'project_manager/create_task/$1';
$route['project_manager/analytics'] = 'project_manager/analytics';
$route['dashboard'] = 'dashboard/index';
$route['projects'] = 'projects/index';
$route['projects/create'] = 'projects/create';
$route['projects/delete/(:num)'] = 'projects/delete/$1';
$route['projects/edit/(:num)'] = 'projects/edit/$1';
$route['tasks'] = 'tasks/index';
$route['tasks/create'] = 'tasks/create';
$route['tasks/delete/(:num)'] = 'tasks/delete/$1';
$route['tasks/edit/(:num)'] = 'tasks/edit/$1';
