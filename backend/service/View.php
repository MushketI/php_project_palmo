<?php 

namespace Palmo\service;

class View {

    public function page($path) {

        require_once(ROOT.$path);

    }

    public function component($path) {

        require_once(ROOT.$path);

    }
}