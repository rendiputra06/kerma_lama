<?php
defined('BASEPATH') or exit('No direct script access allowed');



// switch ($_SERVER['HTTP_HOST']) {
//     case 'localhost/t2/cia':
//         $route['default_controller']             = 'auth';
//         break;
//     default:
//         $route['default_controller']             = 'home';
//         break;
//     }

$route['default_controller']            = 'publik';
$route['dashboard']                     = 'beranda';

$route['deactivate/(:num)']             = 'auth/deactivate/$1';
$route['activate/(:num)']               = 'auth/activate/$1';
$route['login']                         = 'auth/login2';
$route['logout']                        = 'auth/logout';

$route['activation']                    = 'auth/activation';
$route['registration']                  = 'auth/register';
$route['cancel']                        = 'auth/clear';
$route['generate/(:num)']               = 'auth/generate/$1';
$route['activation/user/(:num)/(:any)'] = 'auth/activation_user/$1/$2';

$route['404_override']                     = '';
$route['translate_uri_dashes']             = FALSE;
