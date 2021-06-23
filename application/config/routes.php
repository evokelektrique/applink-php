<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home/index';
$route['404_override'] = 'home/error_404';
$route['translate_uri_dashes'] = FALSE;

///////////
// Admin //
///////////
$route['dashboard/admin'] = 'admin/index';
$route['dashboard/admin/stats'] = 'admin/stats';
$route['dashboard/admin/links/delete/(:num)'] = 'admin/admin_link_delete/$1';
$route['dashboard/admin/links/edit/(:num)'] = 'admin/admin_link_edit/$1';
$route['dashboard/admin/links/validate_edit/(:num)'] = 'admin/admin_link_validate_edit/$1';
$route['dashboard/admin/links'] = 'admin/links';
$route['dashboard/admin/texts/delete/(:num)'] = 'admin/admin_text_delete/$1';
$route['dashboard/admin/texts/edit/(:num)'] = 'admin/admin_text_edit/$1';
$route['dashboard/admin/texts/validate_edit/(:num)'] = 'admin/admin_text_validate_edit/$1';
$route['dashboard/admin/texts'] = 'admin/texts';

$route['dashboard/admin/transactions'] = 'admin/admin_transactions_list';
$route['dashboard/admin/transactions/edit/(:num)'] = 'admin/admin_transactions_edit/$1';
$route['dashboard/admin/transactions/validate_edit/(:num)'] = 'admin/admin_transactions_validate_edit/$1';

$route['dashboard/admin/settings'] = 'admin/settings';
$route['dashboard/admin/settings/validate_edit'] = 'admin/settings_validate_edit';
// Users
$route['dashboard/admin/users'] = 'admin/admin_users_list';
$route['dashboard/admin/users/edit/(:num)'] = 'admin/admin_users_edit/$1';
$route['dashboard/admin/users/validate_edit/(:num)'] = 'admin/admin_users_validate_edit/$1';
// Messages
$route['dashboard/admin/message'] = 'admin/message';
$route['dashboard/admin/message/create'] = 'admin/create_message';
$route['dashboard/admin/message/validate'] = 'admin/message_validate';
$route['dashboard/admin/message/edit/(:num)'] = 'admin/message_edit/$1';
$route['dashboard/admin/message/validate_edit/(:num)'] = 'admin/message_validate_edit/$1';
$route['dashboard/admin/message/delete/(:num)'] = 'admin/message_delete/$1';

///////////
// Pages //
///////////
$route['login'] = 'login/index';
$route['register'] = 'register/index';
$route['recover'] = 'recover/index';

//////////
// News //
//////////
$route['dashboard/news/(:num)'] = 'news/index/$1';
// Messages
$route['dashboard/admin/news'] = 'admin/news';
$route['dashboard/admin/news/create'] = 'admin/create_news';
$route['dashboard/admin/news/validate'] = 'admin/news_validate';
$route['dashboard/admin/news/edit/(:num)'] = 'admin/news_edit/$1';
$route['dashboard/admin/news/validate_edit/(:num)'] = 'admin/news_validate_edit/$1';
$route['dashboard/admin/news/delete/(:num)'] = 'admin/news_delete/$1';

//////////////
// Messages //
//////////////
$route['dashboard/messages/(:num)'] = 'messages/index/$1';

////////////////
// Short link //
////////////////
$route['dashboard'] = 'dashboard/index';
$route['dashboard/shortlink'] = 'shortlink/index';
// Single
$route['dashboard/shortlink/single'] = 'shortlink/single';
// Group
$route['dashboard/shortlink/group'] = 'shortlink/group';
// Links list
$route['dashboard/links'] = 'links/index';
$route['dashboard/links/delete/(:num)'] = 'links/delete/$1';
$route['dashboard/links/edit/(:num)'] = 'links/edit/$1';
$route['dashboard/links/validate_edit/(:num)'] = 'links/validate_edit/$1';
$route['dashboard/links/qrcode/(:any)'] = 'links/qrcode/$1';

////////////////
// Short Text //
////////////////
$route['dashboard/texts'] = 'texts/index';
$route['dashboard/shorttext'] = 'shorttext/index';
$route['dashboard/texts'] = 'texts/index';
$route['dashboard/texts/delete/(:num)'] = 'texts/delete/$1';
$route['dashboard/texts/edit/(:num)'] = 'texts/edit/$1';
$route['dashboard/texts/validate_edit/(:num)'] = 'texts/validate_edit/$1';
$route['dashboard/texts/qrcode/(:any)'] = 'texts/qrcode/$1';




///////////////////////////////
// Forgot Password (Recover) //
///////////////////////////////
$route['recover/token/(:any)'] = 'recover/token/$1';



//////////////
// Withdraw //
//////////////
$route['dashboard/withdraw'] = 'withdraw/index';
$route['dashboard/withdraw/list'] = 'withdraw/list';
$route['dashboard/withdraw/validate'] = 'withdraw/validate';


/////////////
// Profile //
/////////////


$route['dashboard/profile'] = 'profile/index';
$route['dashboard/profile/validate'] = 'profile/validate';

$route['dashboard/profile/change_password'] = 'profile/change_password';
$route['dashboard/profile/validate_password'] = 'profile/validate_password';




//////////////
// Redirect //
//////////////
$route['redirect/validate/(:any)'] = 'redirect/validate/$1';
$route['(:any)'] = 'redirect/index/$1';
