<h3>Dersl Listesi</h3>

<form action="" action="get">
    <input type="text" value="<?php echo isset($_GET['arama'])? $_GET['arama'] : '' ?>" name="arama" placeholder="Derslerde ara...">
    <button type="submit">Arama</button>
</form>

<?php
    // $dersler = $db->query('SELECT * FROM dersler WHERE id = 3')->fetchAll(PDO::FETCH_ASSOC);
    $sql = 'SELECT dersler.id, dersler.baslik, kategoriler.ad as kategori_adi, dersler.onay  FROM dersler INNER JOIN kategoriler ON kategoriler.id = dersler.kategori_id';
    if(isset($_GET['arama'])){
        $sql .= ' WHERE dersler.baslik LIKE "%' . $_GET['arama'] . '%" || dersler.icerik LIKE "%' . $_GET['arama'] . '%"';
    }
    $sql .= ' ORDER BY dersler.id DESC';
    $sorgu = $db->prepare($sql);
    $sorgu->execute();
    $dersler = $sorgu->fetchAll(PDO::FETCH_ASSOC);   

?>
<?php if($dersler): ?>
<ul>
    <?php foreach ($dersler as $ders): ?>
        <li>
            <?php echo $ders['baslik'] ?> - 
            (<?php echo $ders['kategori_adi'] ?>)
            <div>
                <?php if($ders['onay']): ?>
                    <a href="index.php?sayfa=oku&id=<?php echo $ders['id']; ?>">[OKU]</a>
                <?php endif; ?>
                <a href="index.php?sayfa=guncelle&id=<?php echo $ders['id'] ?>">[DUZENLE]</a>
                <a href="index.php?sayfa=sil&id=<?php echo $ders['id'] ?>">[SIL]</a>
            </div>
        </li>
    <?php endforeach; ?>
</ul>

<?php else: ?>
    <div>
        <?php if(isset($_GET['arama'])): ?>
            Aradiginiz kriterlere ders bulunamadi!
        <?php else: ?>
            Henuz eklenmis ders bulunmuyor!
        <?php endif; ?>
    </div>
<?php endif; ?>