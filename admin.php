<?php
// 1. АВТОРИЗАЦИЯ (Твой Basic Auth)
$user = 'admin'; 
$pass = 'admin123'; 

if (!isset($_SERVER['PHP_AUTH_USER']) || 
    $_SERVER['PHP_AUTH_USER'] !== $user || 
    $_SERVER['PHP_AUTH_PW']   !== $pass) {
    
    header('WWW-Authenticate: Basic realm="Lemoyne Admin"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Доступ только для мастера.';
    exit;
}

// 2. ПОДКЛЮЧЕНИЕ К БАЗЕ
$db = new SQLite3('database.db');

$db->exec("CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT,
    price INTEGER,
    description TEXT,
    leather TEXT,
    color TEXT,
    image TEXT
)");

// 3. ЛОГИКА УДАЛЕНИЯ
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare('DELETE FROM products WHERE id = :id');
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();
    header('Location: admin.php');
    exit;
}

// 4. ЛОГИКА ДОБАВЛЕНИЯ
if (isset($_POST['add'])) {
    $stmt = $db->prepare('INSERT INTO products (title, price, description, leather, color, image) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bindValue(1, $_POST['title']);
    $stmt->bindValue(2, $_POST['price']);
    $stmt->bindValue(3, $_POST['description']);
    $stmt->bindValue(4, $_POST['leather']);
    $stmt->bindValue(5, $_POST['color']);
    $stmt->bindValue(6, $_POST['image']);
    $stmt->execute();
    header('Location: admin.php');
    exit;
}

// 5. ПОЛУЧАЕМ ВСЕ ТОВАРЫ
$results = $db->query('SELECT * FROM products ORDER BY id DESC');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления | Lemoyne Leather</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#121212] p-6 md:p-10 text-stone-200">
    <div class="max-w-4xl mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-[#d4a373]">Панель управления</h1>
                <p class="text-stone-500 text-sm">Управление витриной Lemoyne Leather</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="https://t.me/lemoyne_official" target="_blank" class="px-5 py-2 bg-[#24A1DE]/10 text-[#24A1DE] rounded-full hover:bg-[#24A1DE] hover:text-white transition duration-300 text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0C5.352 0 0 5.352 0 12s5.352 12 12 12 12-5.352 12-12S18.592 0 11.944 0zm5.64 8.244l-1.92 9.048c-.144.648-.528.804-1.08.492l-2.928-2.16-1.416 1.368c-.156.156-.288.288-.588.288l.216-3.048 5.544-5.016c.24-.216-.048-.336-.372-.12l-6.852 4.308-2.952-.924c-.636-.204-.648-.636.132-.948l11.532-4.44c.528-.192.996.12.792.948z"/></svg>
                    Telegram Канал
                </a>

                <a href="index.php" class="px-6 py-2 border border-[#d4a373] text-[#d4a373] rounded-full hover:bg-[#d4a373] hover:text-[#121212] transition duration-300 text-sm font-semibold uppercase tracking-widest">
                    ← В каталог
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-10">
            
            <div class="bg-[#1c1c1c] p-8 rounded-2xl shadow-2xl border border-stone-800">
                <h2 class="text-xl font-semibold mb-6 flex items-center gap-2 text-stone-100">
                    <span class="text-[#d4a373]">✚</span> Добавить новое изделие
                </h2>
                <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="text-xs uppercase text-stone-500 font-bold ml-1">Название</label>
                        <input type="text" name="title" placeholder="Bifold Classic" class="w-full bg-[#262626] border-none p-3 rounded-xl focus:ring-2 focus:ring-[#d4a373] outline-none text-white" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs uppercase text-stone-500 font-bold ml-1">Цена (₽)</label>
                        <input type="number" name="price" placeholder="5500" class="w-full bg-[#262626] border-none p-3 rounded-xl focus:ring-2 focus:ring-[#d4a373] outline-none text-white" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs uppercase text-stone-500 font-bold ml-1">Вид кожи</label>
                        <input type="text" name="leather" placeholder="Badalassi Carlo" class="w-full bg-[#262626] border-none p-3 rounded-xl focus:ring-2 focus:ring-[#d4a373] outline-none text-white">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs uppercase text-stone-500 font-bold ml-1">Цвет</label>
                        <input type="text" name="color" placeholder="Cognac / Tobacco" class="w-full bg-[#262626] border-none p-3 rounded-xl focus:ring-2 focus:ring-[#d4a373] outline-none text-white">
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs uppercase text-stone-500 font-bold ml-1">Путь к фотографии</label>
                        <input type="text" name="image" placeholder="assets/img/catalog/wallet_1.jpg" class="w-full bg-[#262626] border-none p-3 rounded-xl focus:ring-2 focus:ring-[#d4a373] outline-none text-white" required>
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs uppercase text-stone-500 font-bold ml-1">Описание</label>
                        <textarea name="description" placeholder="Опиши детали: ручной шов, количество слотов..." class="w-full bg-[#262626] border-none p-3 rounded-xl focus:ring-2 focus:ring-[#d4a373] outline-none text-white h-32"></textarea>
                    </div>
                    <button type="submit" name="add" class="md:col-span-2 bg-[#d4a373] text-[#121212] py-4 rounded-xl font-bold hover:bg-[#b88a5d] transition duration-300 uppercase tracking-widest shadow-lg shadow-orange-900/10">
                        Опубликовать в магазине
                    </button>
                </form>
            </div>

            <div class="bg-[#1c1c1c] p-8 rounded-2xl shadow-2xl border border-stone-800">
                <h2 class="text-xl font-semibold mb-6 flex items-center gap-2 text-stone-100">
                    <span class="text-red-500">⚙</span> Список активных товаров
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-stone-800 text-stone-500 text-xs uppercase tracking-widest">
                                <th class="py-4 px-2">Фото</th>
                                <th class="py-4 px-2">Изделие</th>
                                <th class="py-4 px-2">Цена</th>
                                <th class="py-4 px-2 text-right">Действие</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-800">
                            <?php while ($row = $results->fetchArray(SQLITE3_ASSOC)): ?>
                            <tr class="hover:bg-[#262626]/50 transition group">
                                <td class="py-4 px-2">
                                    <img src="<?= htmlspecialchars($row['image']) ?>" class="w-14 h-14 object-cover rounded-lg shadow-md border border-stone-700">
                                </td>
                                <td class="py-4 px-2">
                                    <div class="font-semibold text-stone-100"><?= htmlspecialchars($row['title']) ?></div>
                                    <div class="text-xs text-stone-500"><?= htmlspecialchars($row['leather']) ?></div>
                                </td>
                                <td class="py-4 px-2 font-mono text-[#d4a373]"><?= number_format($row['price'], 0, '', ' ') ?> ₽</td>
                                <td class="py-4 px-2 text-right">
                                    <a href="admin.php?delete=<?= $row['id'] ?>" 
                                       onclick="return confirm('Точно удалить это изделие из базы?')"
                                       class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-lg text-xs font-bold uppercase transition duration-300">
                                       Удалить
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>