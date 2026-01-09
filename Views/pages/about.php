<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">À Propos de MyBlog</h1>
    
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-bold mb-4">Notre Mission</h2>
        <p class="text-gray-700 mb-4">
            MyBlog est une plateforme dédiée au partage de connaissances et d'idées. Nous croyons que chaque voix mérite d'être entendue et que les meilleures histoires viennent de personnes passionnées.
        </p>
        <p class="text-gray-700">
            Que vous soyez un écrivain expérimenté ou que vous débutiez, MyBlog vous offre les outils pour partager vos réflexions avec le monde.
        </p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-bold mb-4">Ce que nous offrons</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-start">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-2">Écriture Simple</h3>
                    <p class="text-gray-600">Interface intuitive pour créer et publier vos articles facilement.</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="bg-green-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-2">Communauté Active</h3>
                    <p class="text-gray-600">Connectez-vous avec d'autres auteurs et lecteurs passionnés.</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="bg-purple-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-2">Engagement</h3>
                    <p class="text-gray-600">Commentaires, likes et partages pour interagir avec votre audience.</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="bg-yellow-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-2">Statistiques</h3>
                    <p class="text-gray-600">Suivez les performances de vos articles en temps réel.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-50 rounded-lg p-8 text-center">
        <h2 class="text-2xl font-bold mb-4">Prêt à commencer?</h2>
        <p class="text-gray-700 mb-6">Rejoignez des milliers d'auteurs et partagez votre voix avec le monde.</p>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="/signup" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition inline-block">
                S'inscrire gratuitement
            </a>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>