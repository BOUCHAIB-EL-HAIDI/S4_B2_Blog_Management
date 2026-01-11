<?php
namespace App\Controllers;

use Core\Controller;

class NotFoundController extends Controller
{
    public function index()
    {
        
        http_response_code(404);
        
        $this->view('404', [
            'title' => 'Page non trouvée - MyBlog'
        ]);
    }
}
