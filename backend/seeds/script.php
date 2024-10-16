<?php

try {       
    $db = new PDO("mysql:host=db;port=3306;dbname=project_php_palmo", 'root', 'sql_course');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

//API ключ от TMDb
$apiKey = 'на сайте';


function fetchMoviesFromApi($page, $apiKey) {
    $url = "https://api.themoviedb.org/3/movie/popular?api_key=$apiKey&language=en-US&page=$page";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Функция для сохранения фильма в таблицу movies
function saveMovieToDatabase($db, $movie) {
    $stmt = $db->prepare("
        INSERT INTO movies (id, title, overview, poster_path, release_date) 
        VALUES (:id, :title, :overview, :poster_path, :release_date)
        ON DUPLICATE KEY UPDATE title = VALUES(title), overview = VALUES(overview), poster_path = VALUES(poster_path), release_date = VALUES(release_date)
    ");

    if (!$stmt->execute([
        ':id' => $movie['id'],
        ':title' => $movie['title'],
        ':overview' => $movie['overview'] ?: null,
        ':poster_path' => $movie['poster_path'] ?: null,
        ':release_date' => $movie['release_date'] ?: null
    ])) {
        // Выводим ошибки, если вставка не удалась
        print_r($stmt->errorInfo());
        return 0; // Возвращаем 0, если фильм не сохранен
    }

    return $db->lastInsertId();
}

// Функция для сохранения жанра в таблицу categories
function saveCategoryToDatabase($db, $categoryId) {
    $stmt = $db->prepare("
        INSERT INTO categories (id, name) 
        VALUES (:id, :name)
        ON DUPLICATE KEY UPDATE name = VALUES(name)
    ");

    $genres = [
        28 => "Action",
        12 => "Adventure",
        16 => "Animation",
        35 => "Comedy",
        80 => "Crime",
        99 => "Documentary",
        18 => "Drama",
        10751 => "Family",
        14 => "Fantasy",
        36 => "History",
        27 => "Horror",
        10402 => "Music",
        9648 => "Mystery",
        10749 => "Romance",
        878 => "Science Fiction",
        10770 => "TV Movie",
        53 => "Thriller",
        10752 => "War",
        37 => "Western"
    ];

    if (isset($genres[$categoryId])) {
        $stmt->execute([
            ':id' => $categoryId,
            ':name' => $genres[$categoryId]
        ]);
    }
}

// Функция для сохранения связи фильма с жанрами
function saveMovieCategoryRelation($db, $movieId, $categoryId) {

    if ($movieId <= 0) {
        echo "Ошибка: movieId равен 0. Не удается сохранить связь с жанром. \n";
        return;
    }

    $stmt = $db->prepare("
        INSERT INTO movie_category (movie_id, category_id)
        VALUES (:movie_id, :category_id)
        ON DUPLICATE KEY UPDATE movie_id = VALUES(movie_id), category_id = VALUES(category_id)
    ");


    $stmt->execute([
        ':movie_id' => $movieId,
        ':category_id' => $categoryId
    ]);
}

// Основной цикл для получения и сохранения 1000 фильмов
$totalMoviesToSave = 1000;
$moviesPerPage = 20; // Количество фильмов на одной странице
$totalPages = ceil($totalMoviesToSave / $moviesPerPage);
$savedMovies = 0;

for ($page = 1; $page <= $totalPages; $page++) {
    $data = fetchMoviesFromApi($page, $apiKey);
    
    if (isset($data['results'])) {
        foreach ($data['results'] as $movie) {
            // Сохраняем фильм в таблицу movies
            $movieId = saveMovieToDatabase($db, $movie);

            if ($movieId > 0) {
                // Сохраняем жанры и создаем связи в таблице movie_category
                foreach ($movie['genre_ids'] as $genreId) {
                    saveCategoryToDatabase($db, $genreId);
                    saveMovieCategoryRelation($db, $movieId, $genreId);
                }

                $savedMovies++;
            } else {
                echo "Не удалось сохранить фильм: " . $movie['title'] . "\n";
            }
            
            if ($savedMovies >= $totalMoviesToSave) {
                break 2; // Останавливаем цикл, если сохранили 1000 фильмов
            }
        }
    } else {
        die("Ошибка при получении данных с API.");
    }
}

echo "Сохранено $savedMovies фильмов в базу данных.";
?>