<?php

require_once "config.php";

// ==========================
// ID DE LA PELÍCULA
// ==========================

$id = $_GET["id"] ?? null;

if (!$id) {
    die("ID no válido");
}

// ==========================
// GUARDAR CAMBIOS
// ==========================

if ($_POST) {

    $titulo = $_POST["titulo"];
    $anio = $_POST["anio"];
    $sinopsis = $_POST["sinopsis"];
    $cartel = $_POST["cartel"];
    $director_id = $_POST["director_id"];

    // slug simple (puedes mejorar luego)
    $slug = strtolower(str_replace(" ", "-", $titulo));

    $stmt = $pdo->prepare("
        UPDATE peliculas
        SET titulo = ?,
            slug = ?,
            anio = ?,
            sinopsis = ?,
            cartel = ?,
            director_id = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $titulo,
        $slug,
        $anio,
        $sinopsis,
        $cartel,
        $director_id,
        $id
    ]);

    header("Location: ../pelicula.php?slug=" . $slug);
    exit;
}

// ==========================
// CARGAR PELÍCULA
// ==========================

$stmt = $pdo->prepare("SELECT * FROM peliculas WHERE id = ?");
$stmt->execute([$id]);
$pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pelicula) {
    die("Película no encontrada");
}

// ==========================
// DIRECTORES
// ==========================

$directores = $pdo->query("SELECT * FROM directores ORDER BY nombre ASC");

require_once "header.php";

?>

<h2>✏️ Editar película</h2>

<form method="POST">

    <label>Título</label><br>
    <input type="text" name="titulo" value="<?= htmlspecialchars($pelicula["titulo"]) ?>"><br><br>

    <label>Año</label><br>
    <input type="number" name="anio" value="<?= $pelicula["anio"] ?>"><br><br>

    <label>Cartel (URL)</label><br>
    <input type="text" name="cartel" value="<?= $pelicula["cartel"] ?>"><br><br>

    <label>Sinopsis</label><br>
    <textarea name="sinopsis" rows="5"><?= htmlspecialchars($pelicula["sinopsis"]) ?></textarea><br><br>

    <label>Director</label><br>
    <select name="director_id">

        <?php foreach ($directores as $d): ?>
            <option value="<?= $d["id"] ?>"
                <?= $d["id"] == $pelicula["director_id"] ? "selected" : "" ?>>
                <?= htmlspecialchars($d["nombre"]) ?>
            </option>
        <?php endforeach; ?>

    </select>

    <br><br>

    <button type="submit">💾 Guardar cambios</button>

</form>

<hr>

<a href="../pelicula.php?slug=<?= $pelicula["slug"] ?>">← Volver a la película</a>

<?php require_once "footer.php"; ?>