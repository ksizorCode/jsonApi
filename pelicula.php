<?php

require "config.php";
require "header.php";

$slug = $_GET['slug'] ?? null;

/* =========================
   PELÍCULA + DIRECTOR
========================= */

$stmt = $pdo->prepare("
SELECT p.*, d.nombre AS director, d.slug AS director_slug
FROM peliculas p
JOIN directores d ON d.id = p.director_id
WHERE p.slug = ?
");

$stmt->execute([$slug]);
$peli = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$peli){
    echo "<p>Película no encontrada</p>";
    require "footer.php";
    exit;
}

/* =========================
   ACTORES
========================= */

$stmt = $pdo->prepare("
SELECT a.nombre, a.slug
FROM actores a
JOIN peliculas_actores pa ON pa.actor_id = a.id
WHERE pa.pelicula_id = ?
");

$stmt->execute([$peli['id']]);
$actores = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   CATEGORÍAS
========================= */

$stmt = $pdo->prepare("
SELECT c.nombre, c.slug
FROM categorias c
JOIN peliculas_categorias pc ON pc.categoria_id = c.id
WHERE pc.pelicula_id = ?
");

$stmt->execute([$peli['id']]);
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- =========================
     DETALLE PELÍCULA
========================= -->

<div class="detail">

    <img src="<?= $peli['cartel'] ?>">

    <div>

        <h1><?= htmlspecialchars($peli['titulo']) ?></h1>

        <p>
            🎬 Director:
            <a href="director.php?slug=<?= $peli['director_slug'] ?>">
                <?= $peli['director'] ?>
            </a>
        </p>

        <p>📅 Año: <?= $peli['anio'] ?></p>

        <p><?= $peli['sinopsis'] ?></p>

        <hr>

        <!-- =========================
             CATEGORÍAS
        ========================== -->

        <h3>🎭 Categorías</h3>

        <?php foreach($categorias as $c): ?>
            <a class="badge" href="categoria.php?slug=<?= $c['slug'] ?>">
                <?= $c['nombre'] ?>
            </a>
        <?php endforeach; ?>

        <hr>

        <!-- =========================
             ACTORES
        ========================== -->

        <h3>🎬 Actores</h3>

        <?php foreach($actores as $a): ?>
            <a class="badge" href="actor.php?slug=<?= $a['slug'] ?>">
                <?= $a['nombre'] ?>
            </a>
        <?php endforeach; ?>

    </div>

</div>

<?php require "footer.php"; ?>