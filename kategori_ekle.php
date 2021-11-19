<?php
    if(isset($_POST['ad'])){
        if(empty($_POST['ad'])){
            echo 'Lutfen kategori adini belirtiniz';
        }else{
            // kategori ekle
            $sorgu = $db->prepare('INSERT INTO kategoriler SET ad = ?');
            $ekle = $sorgu->execute([
                $_POST['ad']
            ]);
            if($ekle){
                header('Location:index.php?sayfa=kategoriler');
            }
            else{
                echo 'Kategori eklenemedi';
            }
        }
    }
?>

<form action="" method="post">
    Kategori Adi: <br>
    <input type="text" name="ad">
    <button type="submit">Gonder</button>
</form>