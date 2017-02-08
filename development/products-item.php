<?php

$product = new WC_Product(get_the_ID());

?>

<!-- Product -->
<div class="product">
  <div class="product__meta">
    <a href="<?php the_permalink() ?>" class="product__link">
      <?php the_post_thumbnail('product-thumb', array('class' => 'product__thumb')) ?>
    </a>

    <ul class="product__actions">
      <li class="product__action"></li>
      <li class="product__action"></li>
      <li class="product__action"></li>
    </ul>
    <!-- /end product__actions -->
  </div>
  <!-- /end product__meta -->

  <h3 class="product__title"><?php the_title() ?></h3>
  <p class="product__price"><?php echo wc_price($product->get_price_including_tax(1, $product->get_sale_price())); ?></p>
</div>
<!-- /end Product -->
