<?php

// api.php?type=peliculas&cantidad=10
// api.php?type=directores
// api.php?type=director&name=christopher-nolan
// api.php?type=pelicula&name=toy-story

require_once "config.php";

header("Content-Type: application/json; charset=utf-8");

// ==========================
// PARAMETROS
// ==========================

$type = $_GET['type'] ?? null;
$name = $_GET['name'] ?? null;
$cantidad = $_GET['cantidad'] ?? 10;

// ==========================
// RESPUESTA BASE
// ==========================

$response = [
    "status" => "ok",
    "type" => $type,
    "data" => []
];

// ==========================
// 1. LISTA DE PELICULAS
// ==========================

if ($type === "peliculas") {

    $stmt = $pdo->prepare("
        SELECT p.id, p.titulo, p.slug, p.anio, p.cartel,
               d.nombre AS director, d.slug AS director_slug
        FROM peliculas p
        JOIN directores d ON d.id = p.director_id
        ORDER BY p.id DESC
        LIMIT ?
    ");

    $stmt->bindValue(1, (int)$cantidad, PDO::PARAM_INT);
    $stmt->execute();

    $response["data"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ==========================
// 2. LISTA DE DIRECTORES
// ==========================

elseif ($type === "directores") {

    $stmt = $pdo->query("
        SELECT id, nombre, slug
        FROM directores
        ORDER BY nombre ASC
    ");

    $response["data"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ==========================
// 3. DIRECTOR + SUS PELICULAS
// ==========================

elseif ($type === "director" && $name) {

    // director
    $stmt = $pdo->prepare("
        SELECT * FROM directores WHERE slug = ?
    ");
    $stmt->execute([$name]);
    $director = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$director) {
        echo json_encode(["status"=>"error","msg"=>"Director no encontrado"]);
        exit;
    }

    // peliculas
    $stmt = $pdo->prepare("
        SELECT id, titulo, slug, anio, cartel
        FROM peliculas
        WHERE director_id = ?
        ORDER BY anio DESC
    ");
    $stmt->execute([$director["id"]]);

    $response["data"] = [
        "director" => $director,
        "peliculas" => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ];
}

// ==========================
// 4. PELICULA COMPLETA
// ==========================

elseif ($type === "pelicula" && $name) {

    // pelicula + director
    $stmt = $pdo->prepare("
        SELECT p.*, d.nombre AS director, d.slug AS director_slug
        FROM peliculas p
        JOIN directores d ON d.id = p.director_id
        WHERE p.slug = ?
    ");
    $stmt->execute([$name]);
    $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pelicula) {
        echo json_encode(["status"=>"error","msg"=>"Película no encontrada"]);
        exit;
    }

    // actores
    $stmt = $pdo->prepare("
        SELECT a.nombre, a.slug
        FROM actores a
        JOIN peliculas_actores pa ON pa.actor_id = a.id
        WHERE pa.pelicula_id = ?
    ");
    $stmt->execute([$pelicula["id"]]);
    $actores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // categorias
    $stmt = $pdo->prepare("
        SELECT c.nombre, c.slug
        FROM categorias c
        JOIN peliculas_categorias pc ON pc.categoria_id = c.id
        WHERE pc.pelicula_id = ?
    ");
    $stmt->execute([$pelicula["id"]]);
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response["data"] = [
        "pelicula" => $pelicula,
        "actores" => $actores,
        "categorias" => $categorias
    ];
}

// ==========================
// ERROR
// ==========================

else {
    $response = [
        "status" => "error",
        "msg" => "Parámetros inválidos"
    ];
}

// ==========================
// OUTPUT
// ==========================

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);