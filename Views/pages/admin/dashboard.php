<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <div class="space-x-4">
            <a href="/admin/categories" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Gérer les Catégories
            </a>
            <!-- Placeholder for other admin actions if needed -->
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stats Cards -->
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
            <h3 class="text-gray-500 font-medium">Articles</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">--</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <h3 class="text-gray-500 font-medium">Utilisateurs</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">--</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
            <h3 class="text-gray-500 font-medium">Commentaires</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">--</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Bienvenue, Administrateur</h2>
        <p class="text-gray-600">
            Utilisez le menu pour gérer le contenu du blog. Vous pouvez gérer les catégories via le bouton ci-dessus.
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
