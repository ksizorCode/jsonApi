<?php
require "config.php";
require "header.php";

if($_POST){

$slug = strtolower(str_replace(' ','-',$_POST['titulo']));

$stmt = $pdo->prepare("
INSERT INTO peliculas
(titulo,slug,anio,sinopsis,cartel,director_id)
VALUES (?,?,?,?,?,?)
");

$stmt->execute([
$_POST['titulo'],
$slug,
$_POST['anio'],
$_POST['sinopsis'],
$_POST['cartel'],
$_POST['director']
]);

header("Location: index.php");
}

$directores = $pdo->query("SELECT * FROM directores");
?>

<h2>Nueva película</h2>

<form method="POST">

<input name="titulo" placeholder="Título"><br>
<input name="anio" placeholder="Año"><br>
<input name="cartel" placeholder="URL cartel"><br>

<textarea name="sinopsis"></textarea><br>

<select name="director">
<?php foreach($directores as $d): ?>
<option value="<?= $d['id'] ?>"><?= $d['nombre'] ?></option>
<?php endforeach; ?>
</select>

<button>Guardar</button>

</form>

<?php
require "footer.php"; ?>