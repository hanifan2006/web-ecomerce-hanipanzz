<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'shop';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';
$route['forgot-password'] = 'auth/forgot';
$route['reset-password/(:any)'] = 'auth/reset/$1';
$route['install'] = 'install/index';

$route['admin'] = 'admin/dashboard';
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/products/create'] = 'admin/products/create';
$route['admin/products/edit/(:num)'] = 'admin/products/edit/$1';
$route['admin/products/delete/(:num)'] = 'admin/products/delete/$1';
$route['admin/products/export'] = 'admin/products/export_excel';
$route['admin/orders/history'] = 'admin/orders/history';
$route['admin/orders/view/(:num)'] = 'admin/orders/view/$1';
$route['admin/orders/export'] = 'admin/orders/export_excel';
$route['admin/customers/export'] = 'admin/customers/export_excel';
$route['admin/users/create'] = 'admin/users/create';
$route['admin/users/edit/(:num)'] = 'admin/users/edit/$1';
$route['admin/users/delete/(:num)'] = 'admin/users/delete/$1';
$route['admin/roles/edit/(:num)'] = 'admin/roles/edit/$1';
$route['admin/menus/create'] = 'admin/menus/create';
$route['admin/menus/edit/(:num)'] = 'admin/menus/edit/$1';
$route['admin/menus/delete/(:num)'] = 'admin/menus/delete/$1';

$route['tentang-kami'] = 'pages/about';
$route['akun'] = 'shop/account';
$route['akun/edit-profil'] = 'shop/account_edit';
$route['akun/update'] = 'shop/account_update';
$route['pesanan-saya'] = 'shop/orders';
$route['produk/(:num)'] = 'shop/product/$1';
