<?php
  $image_dir = '/images/AJ pictures';
  $full_dir = getcwd() . $image_dir;
  $images = scandir($full_dir);
  $images = array_diff($images, array('.', '..', '.DS_Store'));
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ami and Jay Wedding</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="crossorigin"/>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500&amp;display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500&amp;display=swap" media="print" onload="this.media='all'"/>
    <noscript>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500&amp;display=swap"/>
    </noscript>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="crossorigin"/>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Great+Vibes&amp;display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Great+Vibes&amp;display=swap" media="print" onload="this.media='all'"/>
    <noscript>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Great+Vibes&amp;display=swap"/>
    </noscript>

    <link href='https://fonts.googleapis.com/css?family=Sacramento' rel='stylesheet'>
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link href="css/bootstrap.min.css?ver=1.1.0" rel="stylesheet">
    <link href="css/font-awesome/css/all.min.css?ver=1.1.0" rel="stylesheet">
    <link href="css/aos.css?ver=1.1.0" rel="stylesheet">
    <link href="css/ekko-lightbox.css?ver=1.1.0" rel="stylesheet">
    <link href="css/main.css?ver=1.1.0" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
    <noscript>
      <style type="text/css">
        [data-aos] {
            opacity: 1 !important;
            transform: translate(0) scale(1) !important;
        }
      </style>
    </noscript>
  </head>
  <body id="top">
<?php
  include("header.html");
?>
    <header></header>
    <div class="page-content fh5co-heading">
      <div class="div">
  <div class="row">
    <div class="col-md-12">
      <h2 class="h1 text-center pb-3 ww-title fh5co-heading" style="margin-top: 40px">Photos</h2>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" style="display: flex; justify-content: center; margin-top: 5px">
      <div class="photo-gallery">
        <div class="container">
            <div class="row photos">
              <?php
                foreach($images as $image) {
              ?>
                <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="<?= $image_dir ?>/<?= $image ?>" data-lightbox="photos"><img class="img-fluid" src="<?= $image_dir ?>/<?= $image ?>"></a></div>
              <?php
                }
              ?>
            </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <script src="scripts/jquery.min.js?ver=1.1.0"></script>
  <script src="scripts/bootstrap.bundle.min.js?ver=1.1.0"></script>
  <script src="scripts/aos.js?ver=1.1.0"></script>
  <script src="scripts/ekko-lightbox.min.js?ver=1.1.0"></script>
  <script src="scripts/main.js?ver=1.1.0"></script>
  <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
<style>
  .nav-link {
    color: #f26147 !important;
  }

.photo-gallery {
  color:#313437;
  background-color:#fff;
}

@media only screen and (min-width: 768px) {
  .img-fluid {
    width: 300px;
    height: 300px;
    object-fit: cover;
  }
}

.photo-gallery p {
  color:#7d8285;
}

.photo-gallery h2 {
  font-weight:bold;
  margin-bottom:40px;
  padding-top:40px;
  color:inherit;
}

@media (max-width:767px) {
  .photo-gallery h2 {
    margin-bottom:25px;
    padding-top:25px;
    font-size:24px;
  }
}

.photo-gallery .intro {
  font-size:16px;
  max-width:500px;
  margin:0 auto 40px;
}

.photo-gallery .intro p {
  margin-bottom:0;
}

.photo-gallery .photos {
  padding-bottom:20px;
}

.photo-gallery .item {
  padding-bottom:30px;
}
</style>

</body>

</html>