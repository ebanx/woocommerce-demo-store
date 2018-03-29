<?php

$products = new WP_Query(array(
  'post_type' => 'product',
  'posts_per_page' => 9
));

?>

<!-- Products -->
<section class="products">
  <div class="wrap">
    <h3>EBANX Demo Store</h3>
    <p>Try our plugin on our WooCommerce DemoStore. Here you will have the experience as a customer, creating payments and exploring all the features. That way, you can see how it works and feel comfortable to install the plugin in your store.</p>
    <!-- Products List -->
    <div class="products__container">
      <div class="row">
        <?php while ($products->have_posts()): $products->the_post(); ?>
          <div class="col-xs-12 col-sm-6 col-md-4">
            <?php get_template_part('products', 'item') ?>
          </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
    <!-- /end Products List -->
  </div>
</section>
<!-- /end Products -->
