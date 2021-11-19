<?php
    /*
    $sorgu = $db->prepare('INSERT INTO dersler2 SET 
    baslik = ?,
    icerik = ?,
    onay = ?');

    $ekle = $sorgu->execute([
        'deneme baslik', 'icerik', 1
    ]);

    if($ekle){
        echo 'verileriniz eklendi'; 
    }
    else{
        $hata = $sorgu->errorInfo();
        echo 'MySQL hatasi: ' . $hata[2];
    }
    */
    // form gonderildi
    $kategoriler = $db->query('SELECT * FROM kategoriler ORDER BY ad ASC')->fetchAll(PDO::FETCH_ASSOC);
    // print_r($kategoriler);

    if(isset($_POST['submit'])){
        $baslik = isset($_POST['baslik']) ? $_POST['baslik'] : null;
        $icerik = isset($_POST['icerik']) ? $_POST['icerik'] : null;
        $onay = isset($_POST['onay']) ? $_POST['onay'] : 0;
        $kategori_id = isset($_POST['kategori_id']) ? $_POST['kategori_id'] : null;
        if(!$baslik){
            echo 'baslik ekleyin';
        }
        elseif(!$icerik){
            echo 'icerik ekleyin';
        }
        elseif(!$kategori_id){
            echo 'kategori secin';
        }
        else{
            $sorgu = $db->prepare('INSERT INTO dersler SET 
            baslik = ?,
            icerik = ?,
            onay = ?,
            kategori_id = ?');
            $ekle = $sorgu->execute([
                $baslik, $icerik, $onay, $kategori_id
            ]);
            if($ekle){
                header('Location:index.php');
            }
            else{
                $hata = $sorgu->errorInfo();
                echo "MySQL hatasi: " . $hata[2];
            }
        }
    }
?>

<form action="" method="post">
    Baslik: <br>
    <input type="text" name="baslik"><br><br>
    Icerik: <br>
    <textarea name="icerik" cols="30" rows="10"></textarea><br><br>
    Kategori: <br>
    <select name="kategori_id">
        <option value="">--- kategori secin ---</option>
        <?php foreach($kategoriler as $kategori): ?>
            <option value="<?php echo $kategori['id'] ?>"><?php echo $kategori['ad'] ?></option>
        <?php endforeach;?>
    </select> <br><br>
    Onay: <br>
    <select name="onay">
        <option value="1">Onayli</option>
        <option value="0">Onayli Degil</option>
    </select><br>
    <input type="hidden" value="1" name="submit">
    <button type="submit">Gonder</button>
</form>