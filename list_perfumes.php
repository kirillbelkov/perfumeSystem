<?php include 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог парфюмерии</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; cursor: pointer; }
        th:hover { background-color: #e0e0e0; }
        .add-btn { display: inline-block; margin: 20px 0; padding: 10px 15px; background: #4CAF50; color: white; text-decoration: none; }
        .add-btn:hover { background: #45a049; }
        .search-filters { margin: 20px 0; padding: 15px; background: #f5f5f5; border-radius: 5px; }
        .search-filters .filter-group { margin-bottom: 10px; display: inline-block; margin-right: 15px; }
        .search-filters label { display: block; margin-bottom: 5px; font-weight: bold; }
        .search-filters input, .search-filters select { padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .search-filters button { padding: 8px 15px; background: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .search-filters button:hover { background: #0b7dda; }
        .reset-btn { padding: 8px 15px; background: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px; }
        .reset-btn:hover { background: #d32f2f; }
        .pagination { margin-top: 20px; }
        .pagination a { padding: 8px 12px; margin-right: 5px; background: #e0e0e0; color: #333; text-decoration: none; border-radius: 4px; }
        .pagination a.active { background: #4CAF50; color: white; }
        .pagination a:hover:not(.active) { background: #ccc; }
        .no-results { padding: 20px; background: #fff8e1; border: 1px solid #ffe0b2; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Каталог парфюмерии</h1>
    
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green; padding: 10px; background: #e8f5e9; border-radius: 4px;">Парфюм успешно добавлен!</p>
    <?php endif; ?>
    
    <div class="search-filters">
        <form method="get">
            <div class="filter-group">
                <label for="search">Поиск</label>
                <input type="text" id="search" name="search" placeholder="Название или бренд" 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            
            <div class="filter-group">
                <label for="condition">Состояние</label>
                <select id="condition" name="condition">
                    <option value="">Все</option>
                    <option value="Новый" <?= ($_GET['condition'] ?? '') === 'Новый' ? 'selected' : '' ?>>Новый</option>
                    <option value="Отличное" <?= ($_GET['condition'] ?? '') === 'Отличное' ? 'selected' : '' ?>>Отличное</option>
                    <option value="Хорошее" <?= ($_GET['condition'] ?? '') === 'Хорошее' ? 'selected' : '' ?>>Хорошее</option>
                    <option value="Удовлетворительное" <?= ($_GET['condition'] ?? '') === 'Удовлетворительное' ? 'selected' : '' ?>>Удовлетворительное</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="min_price">Цена от</label>
                <input type="number" id="min_price" name="min_price" placeholder="Мин. цена" step="0.01"
                       value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>">
            </div>
            
            <div class="filter-group">
                <label for="max_price">Цена до</label>
                <input type="number" id="max_price" name="max_price" placeholder="Макс. цена" step="0.01"
                       value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
            </div>
            
            <div class="filter-group">
                <label for="sort">Сортировка</label>
                <select id="sort" name="sort">
                    <option value="newest" <?= ($_GET['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>Сначала новые</option>
                    <option value="price_asc" <?= ($_GET['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>Цена по возрастанию</option>
                    <option value="price_desc" <?= ($_GET['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Цена по убыванию</option>
                    <option value="year_asc" <?= ($_GET['sort'] ?? '') === 'year_asc' ? 'selected' : '' ?>>Год выпуска (старые)</option>
                    <option value="year_desc" <?= ($_GET['sort'] ?? '') === 'year_desc' ? 'selected' : '' ?>>Год выпуска (новые)</option>
                </select>
            </div>
            
            <div class="filter-group">
                <button type="submit">Применить</button>
                <?php if (isset($_GET['search']) || isset($_GET['condition']) || isset($_GET['min_price']) || isset($_GET['max_price'])): ?>
                    <a href="list_perfumes.php" class="reset-btn">Сбросить</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <a href="add_perfume.php" class="add-btn">Добавить новый парфюм</a>
    
    <?php
    $perPage = 10;
    $page = max(1, intval($_GET['page'] ?? 1));
    $offset = ($page - 1) * $perPage;
    
    $sql = "SELECT * FROM perfumes WHERE 1=1";
    $params = [];
    $countSql = "SELECT COUNT(*) FROM perfumes WHERE 1=1";
    $countParams = [];

    if (!empty($_GET['search'])) {
        $searchTerm = "%{$_GET['search']}%";
        $sql .= " AND (name LIKE :search OR brand LIKE :search OR release_year LIKE :search)";
        $countSql .= " AND (name LIKE :search OR brand LIKE :search OR release_year LIKE :search)";
        $params[':search'] = $searchTerm;
        $countParams[':search'] = $searchTerm;
    }
    
    if (!empty($_GET['condition'])) {
        $sql .= " AND bottle_condition = :condition";
        $countSql .= " AND bottle_condition = :condition";
        $params[':condition'] = $_GET['condition'];
        $countParams[':condition'] = $_GET['condition'];
    }
    
    if (!empty($_GET['min_price'])) {
        $sql .= " AND price >= :min_price";
        $countSql .= " AND price >= :min_price";
        $params[':min_price'] = floatval($_GET['min_price']);
        $countParams[':min_price'] = floatval($_GET['min_price']);
    }
    
    if (!empty($_GET['max_price'])) {
        $sql .= " AND price <= :max_price";
        $countSql .= " AND price <= :max_price";
        $params[':max_price'] = floatval($_GET['max_price']);
        $countParams[':max_price'] = floatval($_GET['max_price']);
    }
    $orderBy = match($_GET['sort'] ?? 'newest') {
        'price_asc' => 'price ASC',
        'price_desc' => 'price DESC',
        'year_asc' => 'release_year ASC',
        'year_desc' => 'release_year DESC',
        default => 'created_at DESC'
    };
    $sql .= " ORDER BY $orderBy LIMIT :limit OFFSET :offset";
    $stmt = $db->prepare($countSql);
    foreach ($countParams as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $totalItems = $stmt->fetchColumn();
    $totalPages = ceil($totalItems / $perPage);
    $stmt = $db->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $perfumes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($perfumes)): ?>
        <div class="no-results">
            Ничего не найдено. Попробуйте изменить параметры поиска.
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th onclick="sortTable('name')">Название</th>
                    <th onclick="sortTable('brand')">Бренд</th>
                    <th onclick="sortTable('release_year')">Год</th>
                    <th onclick="sortTable('volume_ml')">Объем</th>
                    <th onclick="sortTable('bottle_condition')">Состояние</th>
                    <th onclick="sortTable('price')">Цена</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($perfumes as $perfume): ?>
                <tr>
                    <td><?= htmlspecialchars($perfume['name']) ?></td>
                    <td><?= htmlspecialchars($perfume['brand']) ?></td>
                    <td><?= $perfume['release_year'] ?: '-' ?></td>
                    <td><?= $perfume['volume_ml'] ? $perfume['volume_ml'] . ' мл' : '-' ?></td>
                    <td><?= htmlspecialchars($perfume['bottle_condition']) ?></td>
                    <td><?= number_format($perfume['price'], 2) ?> ₽</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" 
                       <?= $i == $page ? 'class="active"' : '' ?>>
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    
    <script>
        function sortTable(column) {
            const url = new URL(window.location.href);
            const currentSort = url.searchParams.get('sort');
            
            // Определяем направление сортировки
            let newSort;
            if (currentSort === column + '_asc') {
                newSort = column + '_desc';
            } else if (currentSort === column + '_desc') {
                newSort = column + '_asc';
            } else {
                newSort = column + '_asc';
            }
            
            url.searchParams.set('sort', newSort);
            window.location.href = url.toString();
        }
    </script>
</body>
</html>