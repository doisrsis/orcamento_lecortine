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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

// Rotas públicas - Formulário de Orçamento
$route['orcamento'] = 'orcamento/index';
$route['orcamento/etapa1'] = 'orcamento/etapa1';
$route['orcamento/etapa2'] = 'orcamento/etapa2';
$route['orcamento/etapa3'] = 'orcamento/etapa3';
$route['orcamento/etapa4'] = 'orcamento/etapa4';
$route['orcamento/etapa5'] = 'orcamento/etapa5';
$route['orcamento/etapa6'] = 'orcamento/etapa6';
$route['orcamento/etapa7'] = 'orcamento/etapa7';
$route['orcamento/etapa8'] = 'orcamento/etapa8';
$route['orcamento/resumo'] = 'orcamento/resumo';
$route['orcamento/consultoria'] = 'orcamento/consultoria';
$route['orcamento/sucesso'] = 'orcamento/sucesso';
$route['orcamento/ajax_cores/(:num)'] = 'orcamento/ajax_cores/$1';

// Rotas de autenticação
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['recuperar-senha'] = 'auth/recuperar_senha';

// Rotas administrativas
$route['admin'] = 'admin/dashboard';
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/categorias'] = 'admin/categorias';
$route['admin/produtos'] = 'admin/produtos';
$route['admin/colecoes'] = 'admin/colecoes';
$route['admin/tecidos'] = 'admin/tecidos';
$route['admin/extras'] = 'admin/extras';
$route['admin/precos'] = 'admin/precos';
$route['admin/orcamentos'] = 'admin/orcamentos';
$route['admin/configuracoes'] = 'admin/configuracoes';
