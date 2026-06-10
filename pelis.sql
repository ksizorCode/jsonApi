-- =========================================
-- LIMPIEZA
-- =========================================

DROP TABLE IF EXISTS peliculas_actores;
DROP TABLE IF EXISTS peliculas_categorias;
DROP TABLE IF EXISTS peliculas_paises;
DROP TABLE IF EXISTS peliculas;
DROP TABLE IF EXISTS actores;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS directores;
DROP TABLE IF EXISTS paises;

-- =========================================
-- PAISES
-- =========================================

CREATE TABLE paises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE
);

-- =========================================
-- DIRECTORES
-- =========================================

CREATE TABLE directores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    slug VARCHAR(160) NOT NULL UNIQUE
);

-- =========================================
-- ACTORES
-- =========================================

CREATE TABLE actores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    slug VARCHAR(160) NOT NULL UNIQUE
);

-- =========================================
-- CATEGORIAS
-- =========================================

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE
);

-- =========================================
-- PELICULAS
-- =========================================

CREATE TABLE peliculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    anio YEAR NOT NULL,
    sinopsis TEXT,
    cartel VARCHAR(255),
    director_id INT NOT NULL,

    FOREIGN KEY (director_id) REFERENCES directores(id)
);

-- =========================================
-- RELACIONES N:M
-- =========================================

CREATE TABLE peliculas_actores (
    pelicula_id INT,
    actor_id INT,
    PRIMARY KEY (pelicula_id, actor_id),
    FOREIGN KEY (pelicula_id) REFERENCES peliculas(id) ON DELETE CASCADE,
    FOREIGN KEY (actor_id) REFERENCES actores(id) ON DELETE CASCADE
);

CREATE TABLE peliculas_categorias (
    pelicula_id INT,
    categoria_id INT,
    PRIMARY KEY (pelicula_id, categoria_id),
    FOREIGN KEY (pelicula_id) REFERENCES peliculas(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
);

CREATE TABLE peliculas_paises (
    pelicula_id INT,
    pais_id INT,
    PRIMARY KEY (pelicula_id, pais_id),
    FOREIGN KEY (pelicula_id) REFERENCES peliculas(id) ON DELETE CASCADE,
    FOREIGN KEY (pais_id) REFERENCES paises(id) ON DELETE CASCADE
);

-- =========================================
-- PAISES
-- =========================================

INSERT INTO paises (nombre, slug) VALUES
('Estados Unidos','estados-unidos'),
('Corea del Sur','corea-del-sur'),
('España','espana'),
('México','mexico'),
('Reino Unido','reino-unido'),
('Australia','australia');

-- =========================================
-- DIRECTORES
-- =========================================

INSERT INTO directores (nombre, slug) VALUES
('Christopher Nolan','christopher-nolan'),
('Bong Joon-ho','bong-joon-ho'),
('Denis Villeneuve','denis-villeneuve'),
('David Fincher','david-fincher'),
('Damien Chazelle','damien-chazelle'),
('George Miller','george-miller'),
('Alfonso Cuarón','alfonso-cuaron'),
('Guillermo del Toro','guillermo-del-toro'),

-- clásicos / nuevos añadidos
('Steven Spielberg','steven-spielberg'),
('David Frankel','david-frankel'),
('Louis Leterrier','louis-leterrier'),
('Pete Docter','pete-docter'),
('Brad Bird','brad-bird'),
('Andrew Stanton','andrew-stanton');

-- =========================================
-- ACTORES
-- =========================================

INSERT INTO actores (nombre, slug) VALUES
('Cillian Murphy','cillian-murphy'),
('Emily Blunt','emily-blunt'),
('Robert Downey Jr.','robert-downey-jr'),
('Song Kang-ho','song-kang-ho'),
('Matthew McConaughey','matthew-mcconaughey'),
('Anne Hathaway','anne-hathaway'),
('Jessica Chastain','jessica-chastain'),
('Timothée Chalamet','timothee-chalamet'),
('Rebecca Ferguson','rebecca-ferguson'),
('Oscar Isaac','oscar-isaac'),
('Ryan Gosling','ryan-gosling'),
('Emma Stone','emma-stone'),
('Jesse Eisenberg','jesse-eisenberg'),
('Andrew Garfield','andrew-garfield'),
('Charlize Theron','charlize-theron'),
('Tom Hardy','tom-hardy'),

-- extras cine comercial
('Meryl Streep','meryl-streep'),
('Anne Hathaway (2)','anne-hathaway-2');

-- =========================================
-- CATEGORIAS
-- =========================================

INSERT INTO categorias (nombre, slug) VALUES
('Drama','drama'),
('Thriller','thriller'),
('Acción','accion'),
('Ciencia Ficción','ciencia-ficcion'),
('Aventura','aventura'),
('Romance','romance'),
('Musical','musical'),
('Biografía','biografia'),
('Comedia Negra','comedia-negra'),
('Fantasía','fantasia'),
('Animación','animacion'),
('Superhéroes','superheroes');

-- =========================================
-- PELICULAS
-- =========================================

INSERT INTO peliculas (titulo, slug, anio, sinopsis, cartel, director_id)
VALUES

('El Caballero Oscuro','el-caballero-oscuro',2008,
'Batman enfrenta al Joker en Gotham.',
'https://picsum.photos/seed/batman/400/600',
1),

('Interstellar','interstellar',2014,
'Viaje espacial para salvar la humanidad.',
'https://picsum.photos/seed/interstellar/400/600',
1),

('Parásitos','parasitos',2019,
'Diferencias de clases sociales en Corea.',
'https://picsum.photos/seed/parasitos/400/600',
2),

('Dune','dune',2021,
'El destino de Paul Atreides.',
'https://picsum.photos/seed/dune/400/600',
3),

('La Red Social','la-red-social',2010,
'Creación de Facebook.',
'https://picsum.photos/seed/facebook/400/600',
4),

('La La Land','la-la-land',2016,
'Amor entre artistas en Los Ángeles.',
'https://picsum.photos/seed/lalaland/400/600',
5),

('Mad Max: Fury Road','mad-max-fury-road',2015,
'Supervivencia en el desierto postapocalíptico.',
'https://picsum.photos/seed/madmax/400/600',
6),

('El Laberinto del Fauno','el-laberinto-del-fauno',2006,
'Mundo fantástico en la posguerra española.',
'https://picsum.photos/seed/fauno/400/600',
8),

('Parque Jurásico','parque-jurasico',1993,
'Dinosaurios clonados escapan.',
'https://picsum.photos/seed/jurassic/400/600',
9),

('El Diablo Viste de Prada','el-diablo-viste-de-prada',2006,
'Moda y poder editorial.',
'https://picsum.photos/seed/prada/400/600',
10),

('Ahora Me Ves','ahora-me-ves',2013,
'Magos realizan robos imposibles.',
'https://picsum.photos/seed/magic/400/600',
11),

-- =========================================
-- ANIMACIÓN PIXAR / DISNEY
-- =========================================

('Toy Story','toy-story',1995,
'Los juguetes cobran vida.',
'https://picsum.photos/seed/toystory/400/600',
12),

('Toy Story 3','toy-story-3',2010,
'El cierre emocional de los juguetes.',
'https://picsum.photos/seed/toystory3/400/600',
12),

('Buscando a Nemo','buscando-a-nemo',2003,
'Aventura submarina de un padre en busca de su hijo.',
'https://picsum.photos/seed/nemo/400/600',
14),

('Up','up',2009,
'Aventura aérea con una casa flotante.',
'https://picsum.photos/seed/up/400/600',
12),

('Wall-E','wall-e',2008,
'Robot limpiador en la Tierra abandonada.',
'https://picsum.photos/seed/walle/400/600',
13);

-- =========================================
-- RELACIONES ACTORES (simplificado coherente)
-- =========================================

INSERT INTO peliculas_actores VALUES

(1,1),(1,2),(1,3),
(2,1),(2,2),(2,3),
(3,4),
(4,8),(4,9),(4,10),
(5,13),(5,14),
(6,11),(6,12),
(10,17),(10,18);

-- =========================================
-- RELACIONES CATEGORIAS
-- =========================================

INSERT INTO peliculas_categorias VALUES

(1,1),(1,12),
(2,4),(2,5),
(3,1),
(4,4),(4,5),
(5,8),
(6,6),(6,7),
(9,5),(9,4),
(10,1),
(12,11),(12,4),
(13,11),(13,4),
(14,11),(14,4),
(15,11),(15,4);