<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="text-center mb-12">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenue sur MyBlog</h1>
    <p class="text-xl text-gray-600">Découvrez, partagez et explorez des articles passionnants</p>
</div>

<?php if (isset($_SESSION['user_id'])): ?>
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold mb-4">Bonjour, <?= htmlspecialchars($_SESSION['user_name']) ?>! 👋</h2>
        <p class="text-gray-600 mb-4">Vous êtes connecté en tant que <span class="font-semibold text-blue-600"><?= ucfirst($_SESSION['user_role']) ?></span></p>
        
        <div class="flex gap-4">
            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <a href="/admin/dashboard" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Accéder au Dashboard Admin
                </a>
            <?php elseif ($_SESSION['user_role'] === 'author'): ?>
                <a href="/author/dashboard" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Accéder à Mon Dashboard
                </a>
            <?php endif; ?>
            <a href="/articles" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                Explorer les Articles
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="bg-blue-50 rounded-lg shadow-md p-8 mb-8 text-center">
        <h2 class="text-2xl font-bold mb-4">Rejoignez notre communauté!</h2>
        <p class="text-gray-600 mb-6">Inscrivez-vous pour créer et partager vos propres articles</p>
        <div class="flex justify-center gap-4">
            <a href="/signup" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition">
                S'inscrire
            </a>
            <a href="/login" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition">
                Se connecter
            </a>
        </div>
    </div>
<?php endif; ?>



<?php require_once __DIR__ . '/../partials/footer.php'; ?>