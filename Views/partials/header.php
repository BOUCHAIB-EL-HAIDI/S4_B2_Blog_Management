<?php ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBlog</title>
    
   
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">


    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                
              
                <a href="/" class="text-2xl font-bold">
                     Myblog
                </a>
                
                
                <div class="flex items-center space-x-6">
                    
                   
                    <a href="/" class="hover:text-blue-200 transition">Accueil</a>
                    <a href="/about" class="hover:text-blue-200 transition">À propos</a>
                    <a href="/contact" class="hover:text-blue-200 transition">Contact</a>
                    

                       
                        <a href="/login" class="bg-green-500 px-4 py-2 rounded hover:bg-green-600 transition">
                            Login
                        </a>
                        <a href="/signup" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-700 transition">
                            Sign Up
                        </a>
                    
                    
                </div>
            </div>
        </div>
    </nav>

    
    <main class="container mx-auto px-4 py-8">
