<?php
require "config.php";
require "header.php";

$sql = "
SELECT p.*, d.nombre AS director
FROM peliculas p
JOIN directores d ON d.id=p.director_id
ORDER BY p.anio DESC
";

$pelis = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Catálogo de películas</h2>

<div class="grid">

<?php foreach($pelis as $p): ?>

<a class="card" href="pelicula.php?slug=<?= $p['slug'] ?>">

    <img src="<?= $p['cartel'] ?>">

    <div class="card-body">
        <div class="title"><?= $p['titulo'] ?></div>
        <div class="meta"><?= $p['director'] ?> · <?= $p['anio'] ?></div>
    </div>

</a>

<?php endforeach; ?>

</div>

<?php require "footer.php"; ?>