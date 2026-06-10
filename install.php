<?php

require_once "config.php";

// ==========================
// CONEXIÓN SOLO MYSQL SERVER (sin DB)
// ==========================

try {
    $pdoServer = new PDO(
        "mysql:host=" . DB_HOST . ";charset=utf8",
        DB_USER,
        DB_PASS
    );

    $pdoServer->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {
    die("Error conexión MySQL: " . $e->getMessage());
}

// ==========================
// CREAR BASE DE DATOS
// ==========================

$pdoServer->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

// ==========================
// CONECTAR YA A LA BD
// ==========================

$pdo = new PDO(
    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
    DB_USER,
    DB_PASS
);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ==========================
// CHECK INSTALACIÓN
// ==========================

$tables = $pdo->query("SHOW TABLES")->fetchAll();

if (count($tables) > 0) {
    die("
        <h2>⚠️ Ya está instalado</h2>
        <p>La base de datos ya contiene tablas.</p>
        <a href='index.php'>Ir al inicio</a>
    ");
}

// ==========================
// CARGAR SQL
// ==========================

$sql = file_get_contents("pelis.sql");

if (!$sql) {
    die("No se encuentra pelis.sql");
}

// ==========================
// EJECUTAR SQL
// ==========================

$queries = explode(";", $sql);

try {

    foreach ($queries as $q) {
        $q = trim($q);

        if (!empty($q)) {
            $pdo->exec($q);
        }
    }

    // ==========================
    // LOCK DE INSTALACIÓN
    // ==========================

    file_put_contents("installed.lock", "ok");

    echo "
    <h1>🎬 Instalación completada</h1>
    <p>Base de datos instalada correctamente.</p>
    <a href='index.php'>Entrar a la web</a>
    ";

} catch (Exception $e) {
    die("Error instalando BD: " . $e->getMessage());
}