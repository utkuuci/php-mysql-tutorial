<a href="index.php?sayfa=kategori_ekle">[Kategori Ekle]</a>

<?php
    $kategoriler = $db->query('SELECT kategoriler.*, COUNT(dersler.id) as toplamDers FROM kategoriler
    LEFT JOIN dersler ON dersler.kategori_id = kategoriler.id 
    GROUP BY kategoriler.id')->fetchAll(PDO::FETCH_ASSOC);
    // print_r($sorgu)
?>

<ul>
    <?php foreach($kategoriler as $kategori): ?>
        <li>
            <a href="index.php?sayfa=kategori&id=<?php echo $kategori['id'] ?>">
                <?php echo $kategori['ad'] ?> - 
                (<?php echo $kategori['toplamDers'] ?>)
            </a>
        </li>

    <?php endforeach; ?>
</ul>