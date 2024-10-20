<?php

namespace Palmo\service;

class Pagination {
    
    private $max = 10; // Максимальное количество отображаемых ссылок на страницы
    private $current_page; // Текущая страница
    private $total; // Общее количество элементов
    private $limit; // Элементов на страницу
    private $amount; // Общее количество страниц

    public function __construct($total, $currentPage, $limit)
    {
        $this->total = $total;
        $this->limit = $limit;
        $this->amount = $this->amount(); // Расчёт общего количества страниц
        $this->setCurrentPage($currentPage); // Установка текущей страницы
    }

    public function get() {

        $links = null;

        $limits = $this->limits(); // Диапазон страниц для отображения

        $html = '<ul class="mx-auto flex gap-3 text-xl">'; 

        // Генерация ссылок на страницы
        for($page = $limits[0]; $page <= $limits[1]; $page ++) {
            if ($page == $this->current_page) {
                $links .= '<li class="bg-slate-300 w-7 text-center"> <a href="#">' . $page . '</a></li>';
            } else {
                $links .= $this->generateHtml($page);
            }
        }

        if(!is_null($links)) {
            // Если текущая страница не первая, добавить ссылку на первую страницу
            if ($this->current_page > 1) {
                $links = $this->generateHtml(1, '&lt;') . $links;
            }
            // Если текущая страница не последняя, добавить ссылку на последнюю страницу
            if ($this->current_page < $this->amount) {
                $links .= $this->generateHtml($this->amount, '&gt;');
            }
        }

        $html .= $links . '</ul>';

        return $html;
    }

    private function generateHtml($page, $text = null) {
        if (!$text) {
            $text = $page;
        }
    
        // Получение текущего URI
        $currentURI = $_SERVER['REQUEST_URI'];
        
        // Удаляем параметр page из строки запроса, если он есть
        $currentURI = preg_replace('~/page=[0-9]+~', '', $currentURI);
        
        // Разбиваем строку на путь и строку запроса
        $parts = parse_url($currentURI);
    
        // Проверяем, есть ли в URI строка запроса
        $query = isset($parts['query']) ? '?' . $parts['query'] : '';
    
        // Если текущий URI не заканчивается на слэш, добавляем его
        $path = rtrim($parts['path'], '/') . '/';
    
        // Формируем новый URI: путь всегда заканчивается на /page=X, а строка запроса добавляется после
        return '<li class="bg-slate-200 w-6 text-center"><a href="' . $path . 'page=' . $page . $query . '">' . $text . '</a></li>';
    }

    private function limits() {

        $left = $this->current_page - round($this->max / 2);
        $start = max($left, 1); // Определение начальной страницы
        $end = min($start + $this->max - 1, $this->amount); // Определение последней страницы

        return [$start, $end];
    }

    private function setCurrentPage($currentPage) {
        // Установка текущей страницы, если она вне допустимого диапазона, корректируем
        $this->current_page = $currentPage;

        if ($this->current_page > $this->amount) {
            $this->current_page = $this->amount;
        }

        if ($this->current_page < 1) {
            $this->current_page = 1;
        }
    }

    private function amount() {
        // Подсчет общего количества страниц
        return ceil($this->total / $this->limit);
    }
}