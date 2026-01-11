<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="/author/dashboard" class="text-blue-600 hover:text-blue-800">
            ← Retour au Dashboard
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold mb-6">Modifier l'Article</h1>
        
        <?php if (!empty($data['errors'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    <?php foreach ($data['errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="/author/articles/edit" method="POST" class="space-y-6">
            <input type="hidden" name="id" value="<?= $data['article']['id'] ?>">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Titre de l'article *
                </label>
                <input type="text" id="title" name="title" required
                       value="<?= htmlspecialchars($data['article']['title']) ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Contenu *
                </label>
                <textarea id="content" name="content" required rows="15"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= htmlspecialchars($data['article']['content']) ?></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Catégories
                </label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <?php foreach ($data['all_categories'] as $category): ?>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="categories[]" value="<?= $category['id'] ?>"
                                   <?= in_array($category['id'], $data['article_categories']) ? 'checked' : '' ?>
                                   class="rounded text-blue-600 focus:ring-blue-500">
                            <span class="text-sm"><?= htmlspecialchars($category['name']) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" 
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    Mettre à Jour
                </button>
                <a href="/author/dashboard" 
                   class="bg-gray-300 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>