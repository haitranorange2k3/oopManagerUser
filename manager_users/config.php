<!-- Cac hang so cua PRJ -->
<?php

const _MODULE = 'home';
const _ACTION = 'dashboard';

const _CODE = true;

// Thiet lap host
define('_WEB_HOST', 'http://'. $_SERVER['HTTP_HOST']. '/phpytb/manager_users/');
define('_WEB_HOST_TEMPLATES', _WEB_HOST . '/templates');

// Thiet lap path 
define('_WEB_PATH', __DIR__);
define('_WEB_PATH_TEMPLATES', _WEB_PATH . '/templates');

// Thong tin ket noi
const _HOST = 'localhost';
const _DB = 'qlsv';
const _USER = 'root';
const _PASS = '';