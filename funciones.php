<?php

function limpiar($texto)
{
    return htmlspecialchars(
        trim($texto),
        ENT_QUOTES,
        'UTF-8'
    );
}

function url_amigable($texto)
{
    $texto = strtolower($texto);

    $texto = preg_replace(
        '/[^a-z0-9]+/',
        '-',
        $texto
    );

    return trim($texto,'-');
}

function obtenerDirector($id,$pdo)
{
    $sql = "
        SELECT nombre
        FROM directores
        WHERE id = ?
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$id]);

    return $stmt->fetchColumn();
}


function slug($text){
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/','-',$text);
    return trim($text,'-');
}