<?php
require "config.php";
require "header.php";

$type = $_GET['type'] ?? 'categorias';

switch($type){

case 'categorias':
    $stmt = $pdo->query("SELECT * FROM categorias");
    echo "<h2>Categorías</h2>";
    foreach($stmt as $c){
        echo "<p><a href='categoria.php?slug={$c['slug']}'>{$c['nombre']}</a></p>";
    }
break;

case 'directores':
    $stmt = $pdo->query("SELECT * FROM directores");
    echo "<h2>Directores</h2>";
    foreach($stmt as $d){
        echo "<p><a href='director.php?slug={$d['slug']}'>{$d['nombre']}</a></p>";
    }
break;

case 'actores':
    $stmt = $pdo->query("SELECT * FROM actores");
    echo "<h2>Actores</h2>";
    foreach($stmt as $a){
        echo "<p><a href='actor.php?slug={$a['slug']}'>{$a['nombre']}</a></p>";
    }
break;

}

require "footer.php";