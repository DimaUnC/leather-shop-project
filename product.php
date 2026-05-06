<?php
$db = new SQLite3('database.db');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $db->prepare('SELECT * FROM products WHERE id = :id');
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$res = $stmt->execute();
$p = $res->fetchArray(SQLITE3_ASSOC);

if (!$p) die("Товар не найден. <a href='index.php'>Назад</a>");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($p['title']) ?> | Nordic Leather</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto+Mono&display=swap');
        body { background-color: #0f0f0f; color: #e7e5e4; font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="p-6 md:p-20">
    <div class="max-w-5xl mx-auto">
        <a href="index.php" class="text-stone-500 hover:text-[#c27854] font-mono text-sm block mb-10">← ВЕРНУТЬСЯ В КАТАЛОГ</a>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
            <img src="<?= htmlspecialchars($p['image']) ?>" class="w-full rounded-2xl border border-stone-800">
            <div>
                <h1 class="text-5xl mb-4"><?= htmlspecialchars($p['title']) ?></h1>
                <p class="text-[#c27854] text-3xl font-mono mb-8"><?= number_format($p['price'], 0, '', ' ') ?> ₽</p>
                
                <div class="space-y-4 text-stone-400">
                    <p><b class="text-stone-200">Кожа:</b> <?= htmlspecialchars($p['leather']) ?></p>
                    <p><b class="text-stone-200">Цвет:</b> <?= htmlspecialchars($p['color']) ?></p>
                    <div class="h-px bg-stone-800 my-6"></div>
                    <p class="leading-relaxed italic"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
                </div>

                <button class="w-full mt-10 bg-[#c27854] py-4 rounded-xl text-white font-bold tracking-widest hover:bg-orange-700 transition">ЗАКАЗАТЬ В ТЕЛЕГРАМ</button>
            </div>
        </div>
    </div>
</body>
</html>