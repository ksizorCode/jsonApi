<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Filmoteca</title>
<link rel="stylesheet" href="assets/style.css">

<link rel="manifest" href="manifest.json">

<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('assets/service-worker.js');
}
</script>
</head>

<body>

<header>

    <a href="index.php"><strong>🎬 Filmoteca</strong></a>

    <nav style="display:flex;gap:10px;flex-wrap:wrap">

        <a href="index.php">🏠 Inicio</a>

        <a href="filtros.php?type=categorias">🎭 Categorías</a>

        <a href="filtros.php?type=directores">🎬 Directores</a>

        <a href="filtros.php?type=actores">🎭 Actores</a>

    </nav>

</header>

<main class="container">