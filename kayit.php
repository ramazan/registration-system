<?php
session_start();

include_once 'dbconnect.php';    #Database bilgileri burdan alınıyor.
include_once 'analyticstracking.php';  #Google analiz izleme için eklendi.

$error = false;

if (isset($_POST['kaydet'])) {

    #formdan alınan veriler..
    $name = mysqli_real_escape_string($con, $_POST['AD_SOYAD']);
    $kullanici_adi = mysqli_real_escape_string($con, $_POST['KULLANICI_ADI']);
    $password = mysqli_real_escape_string($con, $_POST['SIFRE']);
    $cpassword = mysqli_real_escape_string($con, $_POST['SIFRE_TEKRAR']);

    #gelen verilerin kontrolu sağlanıyor..
    if (strlen($name) < 4) {
        $error = true;
        $name_error = "Ad Soyad 4 karakterden kısa olamaz !";
    }
    if (!(strpos($kullanici_adi,"."))) {
        $error = true;
        $email_error = "T.C. Kimlik Numarasından sonra nokta koymalısın !";
    }

    if (strlen($kullanici_adi) < 14) {
        $error = true;
        $email_error = "Kullanıcı Adı en az 14 karakter olmalı ve T.C Kimlik Numarasından sonra nokta içermeli  !";
    }
    if (strlen($kullanici_adi) >15 ) {
        $error = true;
        $email_error = "Kullanıcı Adı en fazla 15 karakter olabilir  !";
    }
    if(strlen($password) < 4) {
        $error = true;
        $password_error = "Şifre uzunluğu en az 4 karakter olmalıdır  .!";
    }
    if($password != $cpassword) {
        $error = true;
        $cpassword_error = "Şifreler eşleşmiyor  .!";
    }
    if (!$error) {
        if(mysqli_query($con, "INSERT INTO users (AD_SOYAD,KULLANICI_ADI, SIFRE) VALUES('" . $name . "', '" . $kullanici_adi . "', '" . $password . "')")) {
            $successmsg = " <div class='alert alert-success'><strong> Kaydınız Başarıyla Gerçekleşti  .<br> Kullanıcı Adınız : ".$kullanici_adi."</strong></div>";
          ?>
           <style type="text/css">#warn_alert{display:none;}</style>
          <?php
        } else {
            $errormsg = "<div class='alert alert-danger'><strong> Bi' Şeyler Ters Gitti  .. Lütfen Tekrar Deneyiniz. </strong></div>";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Mimar Sinan Öğrenci Yurdu</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <link rel="stylesheet" href="./css/genel.css" />
    <script src="./js/jquery-3.1.0.min.js"></script>
    <script src="./js/analytics.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 20px">
            <div class="col-md-5 col-md-offset-4 well">
                        <div class='alert alert-info'>
                              <b><h4 style='text-align:center;'> Mimar Sinan  Öğrenci Yurdu Internet Kayıt Formu</h4></b>
                        </div>

                        <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
                            <fieldset>
                                <div class="alert alert-warning" id="warn_alert">
                                      <b><span> Kullanıcı Adını belirtilen formatta girmeniz önemle rica olunur.</span></b>
                                </div>

                                       <span><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
                                       <span><?php if (isset($errormsg)) { echo $errormsg; } ?></span>

                                <div class="form-group">
                                    <label for="name">Ad Soyad :</label>
                                    <input type="text" name="AD_SOYAD" placeholder=" Örn : Ali Fuat Başgil" required value="<?php if($error) echo $name; ?>" class="form-control" />
                                    <span class="text-danger"><strong><?php if (isset($name_error)) echo $name_error; ?></strong></span>
                                </div>

                                <div class="form-group">
                                    <label for="name">Kullanıcı Adı :</label>
                                    <input type="text" name="KULLANICI_ADI" placeholder=" Örn : 12345678910.afb ( TCKimlik + (NOKTA) + Baş Harfler)" required value="<?php if($error) echo $kullanici_adi; ?>" class="form-control" />
                                    <span class="text-danger"><strong><?php if (isset($email_error)) echo $email_error; ?></strong></span>
                                </div>

                                <div class="form-group">
                                    <label for="name">Şifre :</label>
                                    <input type="password" name="SIFRE" placeholder="Şifreyi Girin ( En az 4 karakter )"required class="form-control" />
                                    <span class="text-danger"><strong><?php if (isset($password_error)) echo $password_error; ?></strong></span>
                                </div>

                                <div class="form-group">
                                    <label for="name">Şifre Tekrar :</label>
                                    <input type="password" name="SIFRE_TEKRAR" placeholder="Şifreyi Tekrar Giriniz" required class="form-control" />
                                    <span class="text-danger"><strong><?php if (isset($cpassword_error)) echo $cpassword_error; ?></strong></span>
                                </div>

                                <div class="form-group" style="text-align: center;">
                                    <input type="submit" name="kaydet" value="KAYDET" class="btn btn-success" />
                                </div>
                            </fieldset>
                        </form>

                         <div class="alert alert-success" style="text-align: center; border-top: 1px solid #999;">
                              <b><span> Mimar Sinan  Öğrenci Yurdu  ⓒ 2016-2017</span></b>
                        </div>
            </div>
        </div>
    </div>

</body>
</html>
