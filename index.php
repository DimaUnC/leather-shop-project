<?php
$db = new SQLite3('database.db');
$db->query('CREATE TABLE IF NOT EXISTS products (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, price INTEGER, description TEXT, leather TEXT, color TEXT, image TEXT)');
$results = $db->query('SELECT * FROM products ORDER BY id DESC');
$products = [];
while ($row = $results->fetchArray(SQLITE3_ASSOC)) { $products[] = $row; }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Lemoyne Leather | Мастерская</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto+Mono&display=swap');
        body { background-color: #0f0f0f; color: #e7e5e4; font-family: 'Playfair Display', serif; }
        .font-mono { font-family: 'Roboto Mono', monospace; }
    </style>
</head>
<body>
    <nav class="sticky top-0 z-50 bg-black/95 border-b border-stone-800 p-6 flex justify-between items-center backdrop-blur-sm">
        <h1 class="text-2xl font-bold tracking-[0.3em] uppercase text-[#c27854]">Lemoyne Leather</h1>
        <div class="flex items-center gap-6">
            <a href="https://t.me/lemoyne_official" target="_blank" class="text-xs text-[#24A1DE] border border-[#24A1DE]/30 px-3 py-1 rounded-full hover:bg-[#24A1DE] hover:text-white transition">Telegram</a>
            <a href="admin.php" class="text-xs text-stone-600 hover:text-white uppercase tracking-widest">Админка</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-20 px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <?php foreach ($products as $p): ?>
                <a href="product.php?id=<?= $p['id'] ?>" class="group border border-stone-800 p-4 rounded-2xl hover:border-[#c27854]/50 transition duration-500 block">
                    <div class="overflow-hidden rounded-xl mb-6">
                        <img src="<?= htmlspecialchars($p['image']) ?>" class="w-full h-80 object-cover group-hover:scale-110 transition duration-700">
                    </div>
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl"><?= htmlspecialchars($p['title']) ?></h3>
                        <span class="font-mono text-[#c27854]"><?= number_format($p['price'], 0, '', ' ') ?> ₽</span>
                    </div>
                    <p class="text-stone-500 text-sm mt-2 font-mono uppercase tracking-tighter">Смотреть детали →</p>
                </a>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>