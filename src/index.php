<?php
// CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
// header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization, access-token');

/**
 *
 */
$container = require __DIR__ . '/App/bootstrap.php';

