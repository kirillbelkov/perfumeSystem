<?php
require 'includes/config.php';

try {
    $stmt = $db->prepare("INSERT INTO perfumes (name, brand, release_year, volume_ml, bottle_condition, price) 
                         VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['brand'],
        $_POST['release_year'] ?: null,
        $_POST['volume_ml'] ?: null,
        $_POST['bottle_condition'],
        $_POST['price']
    ]);
    
    header('Location: list_perfumes.php?success=1');
    exit();
} catch(PDOException $e) {
    die("Ошибка при сохранении: " . $e->getMessage());
}
?>