<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Mon Profil</h1>
    
    <!-- Profile Card -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-6">
        <div class="flex items-center mb-6">
            <div class="bg-blue-500 rounded-full w-20 h-20 flex items-center justify-center text-white text-3xl font-bold">
                <?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?>
            </div>
            <div class="ml-6">
                <h2 class="text-2xl font-bold"><?= htmlspecialchars($_SESSION['user_name']) ?></h2>
                <p class="text-gray-600"><?= htmlspecialchars($_SESSION['user_email']) ?></p>
                <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full mt-2">
                    <?= ucfirst($_SESSION['user_role']) ?>
                </span>
            </div>
        </div>
        
        <div class="border-t pt-6">
            <h3 class="text-xl font-bold mb-4">Informations du Profil</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nom</label>
                    <p class="text-lg"><?= htmlspecialchars($_SESSION['user_name']) ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                    <p class="text-lg"><?= htmlspecialchars($_SESSION['user_email']) ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Rôle</label>
                    <p class="text-lg"><?= ucfirst($_SESSION['user_role']) ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Membre depuis</label>
                    <p class="text-lg"><?= date('d/m/Y') ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold mb-4">Actions Rapides</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php if ($_SESSION['user_role'] === 'author'): ?>
                <a href="/author/dashboard" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition text-center">
                    📊 Mon Dashboard
                </a>
                <a href="/author/articles/create" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition text-center">
                    ✍️ Créer un Article
                </a>
            <?php elseif ($_SESSION['user_role'] === 'admin'): ?>
                <a href="/admin/dashboard" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition text-center">
                    🔧 Dashboard Admin
                </a>
                <a href="/admin/categories" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition text-center">
                    📁 Gérer Catégories
                </a>
            <?php endif; ?>
            <a href="/articles" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition text-center">
                📚 Explorer Articles
            </a>
            <a href="/settings" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition text-center">
                ⚙️ Paramètres
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>