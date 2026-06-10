<?php
require "config.php";
require "header.php";

$pelis = $pdo->query("SELECT * FROM peliculas ORDER BY id DESC")->fetchAll();
?>

<h2>🎛 Admin Películas</h2>

<a href="nuevo.php">➕ Nueva película</a>

<?php foreach($pelis as $p): ?>

<div style="margin:10px 0;padding:10px;background:#222">

    <strong><?= $p['titulo'] ?></strong>

    <a href="editar.php?id=<?= $p['id'] ?>">✏️ Editar</a>

</div>

<?php endforeach; ?>

<?php require "../footer.php"; ?>