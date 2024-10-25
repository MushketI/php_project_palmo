<?php 

return array(
    // 'news/([0-9]+)' => 'news/view/$1',
    // 'news' => 'news/index',
    
    //user:
    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',

    //profile:
    'profile' => 'profile/index',

    //movies:
    'movies/([0-9]+)' => 'movies/view/$1',
    'movies/page=([0-9]+)' => 'movies/index/$1',
    'movies' => 'movies/index',
    // '' => 'movies/index',
);