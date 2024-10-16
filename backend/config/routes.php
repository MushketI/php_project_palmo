<?php 

return array(
    // 'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2',
    // 'news/([0-9]+)' => 'news/view',
    'news/([0-9]+)' => 'news/view/$1',
    'news' => 'news/index',

    
    //movies:
    'movies/([0-9]+)' => 'movies/view/$1',
    'movies' => 'movies/index',
);