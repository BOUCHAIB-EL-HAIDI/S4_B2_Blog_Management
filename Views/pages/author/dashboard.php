<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="mb-8">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Auteur</h1>
        <a href="/author/articles/create" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            ➕ Créer un Article
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Articles Publiés</p>
                <p class="text-3xl font-bold text-blue-600"><?= $data['stats']['total_articles'] ?? 0 ?></p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Likes</p>
                <p class="text-3xl font-bold text-green-600"><?= $data['stats']['total_likes'] ?? 0 ?></p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Commentaires</p>
                <p class="text-3xl font-bold text-purple-600"><?= $data['stats']['total_comments'] ?? 0 ?></p>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Vues Totales</p>
                <p class="text-3xl font-bold text-yellow-600"><?= $data['stats']['total_views'] ?? 0 ?></p>
            </div>
            <div class="bg-yellow-100 rounded-full p-3">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- My Articles Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-bold">Mes Articles</h2>
    </div>
    
    <?php if (empty($data['articles'])): ?>
        <div class="p-8 text-center text-gray-500">
            <p class="text-lg mb-4">Vous n'avez pas encore publié d'articles</p>
            <a href="/author/articles/create" class="text-blue-600 hover:text-blue-800 font-semibold">
                Créer votre premier article →
            </a>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégories</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Likes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commentaires</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($data['articles'] as $article): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <a href="/article/<?= $article['id'] ?>" class="text-blue-600 hover:text-blue-800 font-medium">
                                    <?= htmlspecialchars($article['title']) ?>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <?php if (!empty($article['categories'])): ?>
                                    <?php foreach ($article['categories'] as $category): ?>
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">
                                            <?= htmlspecialchars($category) ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-green-600 font-semibold"><?= $article['likes_count'] ?? 0 ?></span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-purple-600 font-semibold"><?= $article['comments_count'] ?? 0 ?></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?= date('d/m/Y', strtotime($article['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="/author/articles/edit/<?= $article['id'] ?>" 
                                       class="text-blue-600 hover:text-blue-800" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <button onclick="confirmDelete(<?= $article['id'] ?>)" 
                                            class="text-red-600 hover:text-red-800" title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
function confirmDelete(articleId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet article? Cette action est irréversible.')) {
        window.location.href = '/author/articles/delete/' + articleId;
    }
}
</script>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>