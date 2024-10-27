<?php 

return array(
    //user:
    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',

    //profile:
    'profile' => 'profile/index',

    //favorit: 
    'favorit/add' => 'favorit/add',
    'favorit/remove' => 'favorit/remove',

    //movies:
    'movies/([0-9]+)' => 'movies/view/$1',
    'movies/page=([0-9]+)' => 'movies/index/$1',
    'movies' => 'movies/index',

    //error:
    '' => '',
);