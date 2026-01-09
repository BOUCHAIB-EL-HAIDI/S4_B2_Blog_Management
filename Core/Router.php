<?php
namespace Core;

class Router
{
    private array $routes = [];
    
    public function get(string $uri, string $action)
    {
        $this->routes['GET'][$uri] = $action;
    }
    
    public function post(string $uri, string $action)
    {
        $this->routes['POST'][$uri] = $action;
    }
    
    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        
        // First, try exact match (for static routes)
        if (isset($this->routes[$requestMethod][$uri])) {
            $this->executeRoute($this->routes[$requestMethod][$uri], []);
            return;
        }
        
        // Then try dynamic routes with parameters
        foreach ($this->routes[$requestMethod] ?? [] as $route => $action) {
            // Convert route pattern like /article/{id} to regex
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match
                $this->executeRoute($action, $matches);
                return;
            }
        }
        
        // No route found - show 404
        $this->notFound();
    }
    
    private function executeRoute(string $action, array $params = [])
    {
        [$controllerName, $methodName] = explode('@', $action);
        $controllerClass = "App\\Controllers\\$controllerName";
        
        if (!class_exists($controllerClass)) {
            $this->notFound();
            return;
        }
        
        $controller = new $controllerClass();
        
        if (!method_exists($controller, $methodName)) {
            $this->notFound();
            return;
        }
        
        // Call controller method with parameters
        call_user_func_array([$controller, $methodName], $params);
    }
    
    private function notFound()
    {
        http_response_code(404);
        
        // If you have a NotFoundController, use it
        if (class_exists("App\\Controllers\\NotFoundController")) {
            $controller = new \App\Controllers\NotFoundController();
            $controller->index();
        } else {
            // Simple 404 page
            echo '<!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>404 - Page non trouvée</title>
                <script src="https://cdn.tailwindcss.com"></script>
            </head>
            <body class="bg-gray-50">
                <div class="min-h-screen flex items-center justify-center">
                    <div class="text-center">
                        <h1 class="text-9xl font-bold text-blue-600">404</h1>
                        <p class="text-2xl text-gray-600 mb-4">Page non trouvée</p>
                        <a href="/" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                            Retour à l\'accueil
                        </a>
                    </div>
                </div>
            </body>
            </html>';
        }
    }
}