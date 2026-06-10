<?php

// ========================================
// BASE DE DATOS
// ========================================

define('DB_HOST', 'localhost');
define('DB_PORT', '10041');
define('DB_NAME', 'pelis');
define('DB_USER', 'root');
define('DB_PASS', 'root');

// ========================================
// SITIO WEB
// ========================================

define('SITE_NAME', 'Filmoteca');
define('SITE_URL', 'http://localhost/pelis');

define('IMG_DEFAULT', 'https://placehold.co/400x600');

define('ITEMS_PER_PAGE', 12);

// ========================================
// PDO
// ========================================

try {

    $pdo = new PDO(
        "mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch(PDOException $e){

    die(
        "Error de conexión: " .
        $e->getMessage()
    );

}