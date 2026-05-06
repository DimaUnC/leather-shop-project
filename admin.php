<?php
$admin_password = 'admin123'; 

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_PW'] != $admin_password) {
    header('WWW-Authenticate: Basic realm="Nordic Leather Admin"');
    header('HTTP/1.0 401 Unauthorized');
    die('Доступ закрыт. Нужно ввести пароль.');
}

$db = new SQLite3('database.db');

// Добавление товара
if (isset($_POST['add'])) {
    $stmt = $db->prepare('INSERT INTO products (title, price, description, leather, color, image) VALUES (:t, :p, :d, :l, :c, :i)');
    $stmt->bindValue(':t', $_POST['title']);
    $stmt->bindValue(':p', $_POST['price']);
    $stmt->bindValue(':d', $_POST['description']);
    $stmt->bindValue(':l', $_POST['leather']);
    $stmt->bindValue(':c', $_POST['color']);
    $stmt->bindValue(':i', $_POST['image']);
    $stmt->execute();
    header('Location: admin.php');
}

// Удаление товара
if (isset($_GET['delete'])) {
    $db->query('DELETE FROM products WHERE id = ' . (int)$_GET['delete']);
    header('Location: admin.php');
}

$products = $db->query('SELECT * FROM products ORDER BY id DESC');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админка | Nordic Leather</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #1a1a1a; color: #eee; padding: 40px; }
        .container { max-width: 900px; margin: 0 auto; }
        form { background: #2a2a2a; padding: 25px; border-radius: 8px; border: 1px solid #d4a373; }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; background: #333; border: 1px solid #444; color: #fff; box-sizing: border-box; }
        button { background: #d4a373; color: #000; border: none; padding: 15px 30px; font-weight: bold; cursor: pointer; width: 100%; }
        table { width: 100%; margin-top: 40px; border-collapse: collapse; }
        th, td { padding: 15px; border-bottom: 1px solid #444; text-align: left; }
        .del-btn { color: #ff5f5f; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Панель управления</h1>
        <form method="post">
            <h3>Добавить новый товар</h3>
            <input type="text" name="title" placeholder="Название (например: Кошелек Bifold)" required>
            <input type="number" name="price" placeholder="Цена (только цифры, напр: 5800)" required>
            <textarea name="description" placeholder="Описание товара"></textarea>
            <input type="text" name="leather" placeholder="Тип кожи (напр: КРС)" required>
            <input type="text" name="color" placeholder="Цвет (напр: Коньяк)" required>
            <input type="text" name="image" placeholder="Путь к фото (напр: assets/img/bifold.jpg)" required>
            <button type="submit" name="add">ВЫЛОЖИТЬ В МАГАЗИН</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Кожа/Цвет</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php while($p = $products->fetchArray()): ?>
                <tr>
                    <td><?= $p['title'] ?></td>
                    <td><?= $p['price'] ?> ₽</td>
                    <td><?= $p['leather'] ?> / <?= $p['color'] ?></td>
                    <td><a href="?delete=<?= $p['id'] ?>" class="del-btn" onclick="return confirm('Точно удалить?')">Удалить</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>