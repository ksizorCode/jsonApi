<?php
require "config.php";
require "header.php";

$slug = $_GET['slug'];

$stmt = $pdo->prepare("SELECT * FROM categorias WHERE slug=?");
$stmt->execute([$slug]);
$c = $stmt->fetch();

$stmt = $pdo->prepare("
SELECT p.*
FROM peliculas p
JOIN peliculas_categorias pc ON pc.pelicula_id=p.id
WHERE pc.categoria_id=?
ORDER BY p.anio DESC
");

$stmt->execute([$c['id']]);
$pelis = $stmt->fetchAll();
?>

<h2>🎭 <?= $c['nombre'] ?></h2>

<div class="grid">

<?php foreach($pelis as $p): ?>

<a class="card" href="pelicula.php?slug=<?= $p['slug'] ?>">

    <img src="<?= $p['cartel'] ?>">

    <div class="card-body">
        <div class="title"><?= $p['titulo'] ?></div>
        <div class="meta"><?= $p['anio'] ?></div>
    </div>

</a>

<?php endforeach; ?>

</div>

<?php require "footer.php"; ?>