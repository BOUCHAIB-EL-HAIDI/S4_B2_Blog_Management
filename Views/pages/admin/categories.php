<?php require_once __DIR__ . '/../../partials/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Catégories</h1>
        <a href="/admin/dashboard" class="text-gray-600 hover:text-blue-600 transition">
            &larr; Retour au Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                <h2 class="text-xl font-bold mb-4">
                    <?= isset($data['edit_category']) ? 'Modifier la catégorie' : 'Nouvelle catégorie' ?>
                </h2>
                
                <form action="<?= isset($data['edit_category']) ? '/admin/categories/edit' : '/admin/categories/create' ?>" method="POST">
                    <?php if (isset($data['edit_category'])): ?>
                        <input type="hidden" name="id" value="<?= $data['edit_category']['id'] ?>">
                    <?php endif; ?>
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Nom de la catégorie</label>
                        <input type="text" name="name" id="name" 
                               value="<?= isset($data['edit_category']) ? htmlspecialchars($data['edit_category']['name']) : '' ?>" 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               required>
                    </div>
                    
                    <div class="flex space-x-2">
                        <button type="submit" class="flex-1 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            <?= isset($data['edit_category']) ? 'Mettre à jour' : 'Ajouter' ?>
                        </button>
                        
                        <?php if (isset($data['edit_category'])): ?>
                            <a href="/admin/categories" class="flex-1 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition text-center">
                                Annuler
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- List Section -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($data['categories'] as $category): ?>
                            <tr class="<?= isset($data['edit_category']) && $data['edit_category']['id'] == $category['id'] ? 'bg-blue-50' : 'hover:bg-gray-50' ?>">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    #<?= $category['id'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?= htmlspecialchars($category['name']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/admin/categories/edit?id=<?= $category['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-4">Modifier</a>
                                    <a href="/admin/categories/delete?id=<?= $category['id'] ?>" 
                                       class="text-red-600 hover:text-red-900"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                        Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (empty($data['categories'])): ?>
                    <div class="p-6 text-center text-gray-500">
                        Aucune catégorie trouvée.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>
