<?php
$db = new SQLite3('database.db');

// 1. ЛОГИКА УДАЛЕНИЯ
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare('DELETE FROM products WHERE id = :id');
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();
    header('Location: admin.php'); // Перезагружаем, чтобы обновить список
    exit;
}

// 2. ЛОГИКА ДОБАВЛЕНИЯ
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

// 3. ПОЛУЧАЕМ ВСЕ ТОВАРЫ ДЛЯ СПИСКА
$results = $db->query('SELECT * FROM products ORDER BY id DESC');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель управления | Nordic Leather</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-100 p-10 font-sans text-stone-900">
    <div class="max-w-4xl mx-auto space-y-10">
        
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-stone-200">
            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                <span class="text-[#c27854]">✚</span> Добавить изделие
            </h2>
            <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="title" placeholder="Название (например: Bifold Classic)" class="w-full border p-3 rounded-lg bg-stone-50" required>
                <input type="number" name="price" placeholder="Цена (только цифры)" class="w-full border p-3 rounded-lg bg-stone-50" required>
                <input type="text" name="leather" placeholder="Кожа (например: Buttero)" class="w-full border p-3 rounded-lg bg-stone-50">
                <input type="text" name="color" placeholder="Цвет" class="w-full border p-3 rounded-lg bg-stone-50">
                <input type="text" name="image" placeholder="Путь к фото (assets/img/wallet.jpg)" class="w-full border p-3 rounded-lg bg-stone-50 md:col-span-2" required>
                <textarea name="description" placeholder="Описание изделия..." class="w-full border p-3 rounded-lg bg-stone-50 h-32 md:col-span-2"></textarea>
                <button type="submit" name="add" class="w-full md:col-span-2 bg-[#c27854] text-white py-4 rounded-lg font-bold hover:bg-orange-700 transition">ОПУБЛИКОВАТЬ</button>
            </form>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-xl border border-stone-200">
            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                <span class="text-red-500">⚙</span> Управление товарами
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-stone-200 text-stone-500 text-sm">
                            <th class="py-3 px-2">Фото</th>
                            <th class="py-3 px-2">Название</th>
                            <th class="py-3 px-2">Цена</th>
                            <th class="py-3 px-2 text-right">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $results->fetchArray(SQLITE3_ASSOC)): ?>
                        <tr class="border-b border-stone-50 hover:bg-stone-50 transition">
                            <td class="py-3 px-2">
                                <img src="<?= htmlspecialchars($row['image']) ?>" class="w-12 h-12 object-cover rounded shadow-sm">
                            </td>
                            <td class="py-3 px-2 font-medium"><?= htmlspecialchars($row['title']) ?></td>
                            <td class="py-3 px-2 text-stone-600"><?= number_format($row['price'], 0, '', ' ') ?> ₽</td>
                            <td class="py-3 px-2 text-right">
                                <a href="admin.php?delete=<?= $row['id'] ?>" 
                                   onclick="return confirm('Точно удалить?')"
                                   class="text-red-500 hover:text-red-700 text-sm font-bold uppercase tracking-tight">
                                   Удалить
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center">
            <a href="index.php" class="text-stone-400 hover:text-[#c27854] transition text-sm uppercase tracking-widest font-bold">← На главную страницу</a>
        </div>
    </div>
</body>
</html>