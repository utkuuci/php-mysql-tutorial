<?php
    if(!isset($_GET['id']) || empty($_GET['id'])){
        header("Location:index.php");
        exit;
    }

    $sorgu = $db->prepare('SELECT * FROM dersler 
    WHERE id = ?');
    $sorgu->execute([
        $_GET['id']
    ]);

    $ders = $sorgu->fetch(PDO::FETCH_ASSOC);
    print_r($ders);
    if(!$ders){
        header('Location:index.php');
        exit;
    }
    $kategoriler = $db->query('SELECT * FROM kategoriler ORDER BY ad ASC')->fetchAll(PDO::FETCH_ASSOC);
    if(isset($_POST['submit'])){
        $baslik = isset($_POST['baslik']) ? $_POST['baslik'] : $ders['baslik'];
        $icerik = isset($_POST['icerik']) ? $_POST['icerik'] : $ders['icerik'];
        $onay = isset($_POST['onay']) ? $_POST['onay'] : 0;
        $kategori_id = isset($_POST['kategori_id']) ? $_POST['kategori_id'] : null;
        if(!$baslik){
            echo 'baslik ekleyin';
        }
        elseif(!$icerik){
            echo 'icerik ekleyin';
        }
        elseif(!$kategori_id){
            echo 'kategori seciniz';
        }
        else{
            $sorgu = $db->prepare('UPDATE dersler SET 
            baslik = ?,
            icerik = ?,
            onay = ?,
            kategori_id = ? WHERE id = ?');
            $guncelle = $sorgu->execute([
                $baslik, $icerik, $onay, $kategori_id, $ders['id']
            ]);
            if($guncelle){
                header('Location:index.php?sayfa=oku&id=' . $ders['id']);
            }
            else{
                echo 'Guncelleme islemi basarisiz.';
            }
        }
    }
    // $sorgu = $db->prepare('UPDATE dersler SET 
    // baslik = ?,
    // icerik = ?,
    // onay = ? WHERE id = ?');
    // $guncelle = $sorgu->execute([

    // ]);
?>

<form action="" method="post">
    Baslik: <br>
    <input type="text" name="baslik" value="<?php echo isset($_POST['baslik']) ? $_POST['baslik'] : $ders['baslik'] ?>"><br><br>
    Icerik: <br>
    <textarea name="icerik" cols="30" rows="10"><?php echo isset($_POST['icerik']) ? $_POST['icerik'] : $ders['icerik'] ?></textarea><br><br>
    Kategori: <br>
    <select name="kategori_id">
        <option value="">--- kategori secin ---</option>
        <?php foreach($kategoriler as $kategori): ?>
            <option <?php echo $kategori['id'] == $ders['kategori_id'] ? 'selected' : null ?> value="<?php echo $kategori['id'] ?>"><?php echo $kategori['ad'] ?></option>
        <?php endforeach;?>
    </select> <br><br>
    Onay: <br>
    <select name="onay">
        <option <?php echo $ders['onay'] == 1 ? 'selected' : '' ?> value="1">Onayli</option>
        <option <?php echo $ders['onay'] == 0 ? 'selected' : '' ?> value="0">Onayli Degil</option>
    </select><br>
    <input type="hidden" value="1" name="submit">
    <button type="submit">Guncelle</button>
</form>