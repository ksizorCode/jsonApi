<?php
require "config.php";
require "header.php";

$slug = $_GET['slug'];

$stmt = $pdo->prepare("SELECT * FROM actores WHERE slug=?");
$stmt->execute([$slug]);
$a = $stmt->fetch();

$stmt = $pdo->prepare("
SELECT p.*
FROM peliculas p
JOIN peliculas_actores pa ON pa.pelicula_id=p.id
JOIN actores ac ON ac.id=pa.actor_id
WHERE ac.id=?
ORDER BY p.anio DESC
");

$stmt->execute([$a['id']]);
$pelis = $stmt->fetchAll();
?>

<h2>🎭 <?= $a['nombre'] ?></h2>

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