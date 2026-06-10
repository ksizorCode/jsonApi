<?php
require "config.php";
require "header.php";

$slug = $_GET['slug'];

$stmt = $pdo->prepare("SELECT * FROM directores WHERE slug=?");
$stmt->execute([$slug]);
$d = $stmt->fetch();

$stmt = $pdo->prepare("
SELECT * FROM peliculas
WHERE director_id=?
ORDER BY anio DESC
");

$stmt->execute([$d['id']]);
$pelis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>🎬 <?= $d['nombre'] ?></h2>

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