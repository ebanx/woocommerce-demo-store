<!DOCTYPE html>
<html lang="<?php bloginfo('language') ?>">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="UTF-8">
  <title><?php wp_title() ?></title>

  <!-- Scripts and Styles -->
  <?php wp_head() ?>

  <!-- Hotjar Tracking Code for https://www.ebanxdemo.com/ -->
  <script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:668641,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
  </script>

   <!-- Global site tag (gtag.js) - Google Analytics -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-75789253-8"></script>
   <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
 
        gtag('config', 'UA-75789253-8');
   </script>
</head>

<body <?php body_class() ?>>

  <?php get_template_part('header', 'main') ?>
