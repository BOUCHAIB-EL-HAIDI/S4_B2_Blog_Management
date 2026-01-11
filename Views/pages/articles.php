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
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4">
                        <?= htmlspecialchars($article['title']) ?>
                    </h3>
                    
                    <div class="prose max-w-none mb-6 text-gray-800">
                        <?= nl2br(htmlspecialchars($article['content'])) ?>
                    </div>
                    
                    <div class="border-t pt-4 flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <?php 
                                // Check if user liked this article (assuming ArticleController adds 'user_has_liked' or we check manually)
                                // Since ArticleController::getAllArticles might not inject 'user_has_liked', we might need to rely on JS or update controller.
                                // For now, standard form.
                                // Update: Logic for 'user_has_liked' is needed in the loop in ArticleController.
                            ?>
                            <!-- Like Button -->
                            <form action="/article/like" method="POST" class="m-0 p-0">
                                <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                                <button type="submit" class="flex items-center space-x-2 cursor-pointer <?= !empty($article['user_has_liked']) ? 'text-red-600' : 'text-gray-500 hover:text-red-600' ?> transition focus:outline-none">
                                    <span class="font-bold text-xl">♥</span>
                                    <span class="font-medium"><?= $article['likes_count'] ?> J'aime</span>
                                </button>
                            </form>
                            
                            <!-- Comment Count Display (Non-clickable now, just indicator) -->
                            <div class="flex items-center space-x-2 text-gray-500">
                                <span class="font-bold text-xl">💬</span>
                                <span><?= count($article['comments'] ?? []) ?> Commentaires</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Inline Comments Section -->
                    <div class="mt-6 border-t pt-6 bg-gray-50 -mx-6 -mb-6 px-6 py-4">
                        <!-- Existing Comments -->
                        <?php if (!empty($article['comments'])): ?>
                            <div class="space-y-4 mb-6">
                                <?php foreach ($article['comments'] as $comment): ?>
                                    <div class="border-b border-gray-200 pb-3 last:border-0">
                                        <div class="flex justify-between items-start">
                                            <div class="flex items-center mb-1">
                                                <div class="font-bold text-sm text-gray-900 mr-2"><?= htmlspecialchars($comment['user_name']) ?></div>
                                                <div class="text-xs text-gray-500"><?= date('d/m/Y', strtotime($comment['created_at'])) ?></div>
                                            </div>
                                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']): ?>
                                                <a href="/comment/delete?id=<?= $comment['id'] ?>" class="text-xs text-red-500 hover:text-red-700 font-medium" onclick="return confirm('Supprimer ce commentaire ?')">Supprimer</a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-sm text-gray-700"><?= nl2br(htmlspecialchars($comment['content'])) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 italic mb-4">Aucun commentaire. Soyez le premier !</p>
                        <?php endif; ?>
                        
                        <!-- Add Comment Form -->
                        <form action="/article/comment" method="POST" class="mt-4">
                            <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                            <div class="flex gap-2">
                                <input type="text" name="content" class="flex-grow px-3 py-2 border rounded-full text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Écrire un commentaire..." required>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-blue-700 transition cursor-pointer">
                                    Envoyer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>