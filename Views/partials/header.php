<?php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? 'MyBlog' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="text-2xl font-bold hover:text-blue-200 transition">
                    Myblog
                </a>
                
                <div class="flex items-center space-x-6">
                    <a href="/" class="hover:text-blue-200 transition">Accueil</a>
                    <a href="/articles" class="hover:text-blue-200 transition">Articles</a>
                    <a href="/about" class="hover:text-blue-200 transition">About</a>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Role-based navigation -->
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <a href="/admin/dashboard" class="hover:text-blue-200 transition font-semibold">Dashboard Admin</a>
                        <?php elseif ($_SESSION['user_role'] === 'author'): ?>
                            <a href="/author/dashboard" class="hover:text-blue-200 transition font-semibold">Mon Dashboard</a>
                        <?php endif; ?>
                        
                        <a href="/profile" class="hover:text-blue-200 transition">Mon Profil</a>
                        <a href="/logout" class="block px-4 py-2 text-white-600 hover:bg-red-600  ">Déconnexion</a>

                        </div>
                    <?php else: ?>
                        <a href="/login" class="bg-green-500 px-4 py-2 rounded hover:bg-green-600 transition">
                            Connexion
                        </a>
                        <a href="/signup" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-700 transition">
                            Inscription
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <main class="container mx-auto px-4 py-8 flex-grow">