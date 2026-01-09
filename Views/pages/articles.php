<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="mb-8">
    <h1 class="text-3xl font-bold mb-4">Tous les Articles</h1>
    <p class="text-gray-600">Découvrez les derniers articles de notre communauté</p>
</div>

<!-- Filter by Category -->
<?php if (!empty($data['categories'])): ?>
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <h3 class="font-bold mb-3">Filtrer par catégorie:</h3>
        <div class="flex flex-wrap gap-2">
            <a href="/articles" 
               class="px-4 py-2 rounded-full <?= empty($_GET['category']) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>">
                Toutes
            </a>
            <?php foreach ($data['categories'] as $category): ?>
                <a href="/articles?category=<?= $category['id'] ?>" 
                   class="px-4 py-2 rounded-full <?= ($_GET['category'] ?? '') == $category['id'] ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>">
                    <?= htmlspecialchars($category['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Articles Grid -->
<?php if (empty($data['articles'])): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <p class="text-gray-500 text-lg">Aucun article disponible pour le moment</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($data['articles'] as $article): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-6xl">
                    <?= strtoupper(substr($article['title'], 0, 1)) ?>
                </div>
                <div class="p-6">
                    <div class="mb-3">
                        <?php if (!empty($article['categories'])): ?>
                            <?php foreach ($article['categories'] as $cat): ?>
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">
                                    <?= htmlspecialchars($cat) ?>
                                </span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <h3 class="text-xl font-bold mb-2 line-clamp-2">
                        <?= htmlspecialchars($article['title']) ?>
                    </h3>
                    
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        <?= htmlspecialchars(substr($article['content'], 0, 150)) ?>...
                    </p>
                    
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <span>Par <?= htmlspecialchars($article['author_name']) ?></span>
                        <span><?= date('d/m/Y', strtotime($article['created_at'])) ?></span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex gap-4 text-sm">
                            <span class="flex items-center text-green-600">
                                ❤️ <?= $article['likes_count'] ?>
                            </span>
                            <span class="flex items-center text-purple-600">
                                💬 <?= $article['comments_count'] ?>
                            </span>
                        </div>
                        <a href="/article/<?= $article['id'] ?>" 
                           class="text-blue-600 hover:text-blue-800 font-semibold">
                            Lire →
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>