<?php

include_once 'dbconnect.php';    #Database bilgileri burdan alınıyor.
include_once 'analyticstracking.php';

############################### SAYFAYA ERİŞİM İÇİN YETKİ KONTROLU ############################

# Konfigurasyon
$sayfaSifreleme ='1'; # 1 acik , 0 kapali
$kullaniciAdi = 'admin';
$sifre = '12345';

# yetki kontrol fonksiyonu
function yetkiKontrol($kullaniciAdi,$sifre) {
  if(empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW']) || $_SERVER['PHP_AUTH_USER'] != "$kullaniciAdi" || $_SERVER['PHP_AUTH_PW'] != "$sifre") {
  header('WWW-Authenticate: Basic realm="Yetki Kontrol"');
  die(header('HTTP/1.0 401 Unauthorized'));
  }
}

# Sayfa Sifreleme aciksa
if($sayfaSifreleme =='1') {
# Veri ve sifre kontrolu
yetkiKontrol($kullaniciAdi,$sifre);
}

############################### YETKİ KONTROLU ############################


$con = mysqli_connect("mysql Sunucusu buraya gelecek", "Mysql kullanıcısı buraya gelecek", "Database şifresi", "DB ismi");

if($con === false){
    die("HATA: Veritabanı bağlantısı kurulamadı. " . mysqli_connect_error());
}

#Sorgu yapılıyor..
$sql = "SELECT * FROM users ORDER BY ID";

if($result = mysqli_query($con, $sql)){
    if(mysqli_num_rows($result) > 0){ #Dönen sorgu boş değilse , uygun formatta ekrana basılıyor..
        echo "<!DOCTYPE html>
                <html>
                <head>
                <title>Mimar Sinan  Öğrenci Yurdu</title>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
                    <meta content='width=device-width, initial-scale=1.0' name='viewport' >
                    <link rel='stylesheet' href='./css/bootstrap.css' />
                    <link rel='stylesheet' href='./css/genel.css' />
                </head>
                <body>";

        echo "<div class='container'>   <br>
                    <div class='alert alert-success'>
                          <b><h4 style='text-align:center;'> Mimar Sinan  Öğrenci Yurdu Internet Kullanıcıları</span></b>
                    </div> ";
        echo "<table class='table table-bordered  table-inverse'>";
            echo "<thead><tr  class='bg-success' >";
                echo "<th>ID</th>";
                echo "<th>AD SOYAD</th>";
                echo "<th>KULLANICI ADI</th>";
                echo "<th>SIFRE</th>";
            echo "</tr></thead><tbody>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['AD_SOYAD'] . "</td>";
                echo "<td>" . $row['KULLANICI_ADI'] . "</td>";
                echo "<td>" . $row['SIFRE'] . "</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
         echo "     <div class='alert alert-success'>
                          <b><h5 style='text-align:center;'> Mimar Sinan  Öğrenci Yurdu  ⓒ 2016-2017</span></b>
                    </div>

                        ";
        echo "</div></body></html>";

        mysqli_free_result($result);
    } else{
        echo "Aranan kayıtlar bulunamadı :( .";
    }
} else{
    echo "Hata: SQL'e giderken ayağım takıldı.. $sql. " . mysqli_error($con);
}

mysqli_close($con);
?>
