<!-- Header -->
<header class="header">
  <section class="wrap header__content">
    <button class="hamburger hamburger--3dx" type="button">
      <span class="hamburger-box">
        <span class="hamburger-inner"></span>
      </span>
    </button>

    <!-- Menu Mobile -->
    <?php
      wp_nav_menu(array(
        'menu' => 'Main',
        'menu_class' => 'mobile-menu__menu-list',
        'container' => 'nav',
        'container_class' => 'mobile-menu'
      ));
    ?>
    <!-- /end Menu Mobile -->


    <!-- Logo -->
    <h1 class="header__logo ebanx-logo"><a href="<?php bloginfo('url') ?>" title="EBANX Demo Store"><img src="<?php bloginfo('template_url') ?>/images/ebanx-logo.png" width="140" height="56" alt="EBANX Demo Store"></a></h1>

    <!-- Menu -->
    <?php
      wp_nav_menu(array(
        'menu' => 'Main',
        'menu_class' => 'header__menu-list',
        'container' => 'nav',
        'container_class' => 'header__menu'
      ));
    ?>

    <div class="header__actions">
      <?php if (is_user_logged_in()): ?>
        <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="header__icon header__my-account icon icon--my-account" title="My Account"></a>
      <?php endif ?>

      <a href="<?php echo WC()->cart->get_cart_url() ?>" class="header__icon header__cart icon icon--bag" title="Cart">
        <?php if (!WC()->cart->is_empty()): ?>
          <span><?php echo WC()->cart->get_cart_contents_count() ?></span>
        <?php endif ?>
      </a>

      <!-- Download Plugin -->
      <a href="https://goo.gl/q5Wkve" target="_blank" class="header__download btn btn--small btn--purple">Download the plugin</a>
    </div>
  </section>
</header>
<!-- /end Header -->
