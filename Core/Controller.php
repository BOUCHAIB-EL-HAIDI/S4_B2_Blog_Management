<?php

namespace Core;

class Controller
{
    protected function view(string $view, array $data = [])
    {
        extract($data);

        $viewFile = __DIR__ . '/../Views/pages/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new \Exception("View $view not found");
        }

        require $viewFile;
    }
}