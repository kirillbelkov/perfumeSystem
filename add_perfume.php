<?php include 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить парфюм</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 600px; }
        label { display: block; margin: 10px 0; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background: #45a049; }
    </style>
</head>
<body>
    <h1>Добавить новый парфюм</h1>
    <form action="save_perfume.php" method="post">
        <label>Название*: <input type="text" name="name" required></label>
        <label>Бренд: <input type="text" name="brand"></label>
        <label>Год выпуска: <input type="number" name="release_year" min="1900" max="<?= date('Y') ?>"></label>
        <label>Объем (мл): <input type="number" name="volume_ml" min="1"></label>
        <label>Состояние флакона:
            <select name="bottle_condition">
                <option value="Новый">Новый</option>
                <option value="Отличное">Отличное</option>
                <option value="Хорошее">Хорошее</option>
                <option value="Удовлетворительное">Удовлетворительное</option>
            </select>
        </label>
        <label>Цена*: <input type="number" step="0.01" name="price" required></label>
        <button type="submit">Добавить парфюм</button>
    </form>
    <p><a href="list_perfumes.php">← Вернуться к списку</a></p>
</body>
</html>