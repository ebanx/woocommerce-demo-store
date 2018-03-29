<?php $product = new WC_Product(get_the_ID()); ?>

<?php get_header() ?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

  <?php do_action( 'woocommerce_before_single_product' ); ?>

  <section class="product-single">
    <div class="product-single__gallery">
      <?php the_post_thumbnail('product-gallery') ?>
    </div>
    <div class="product-single__meta">
      <h1 class="product-single__title"><?php the_title() ?></h1>

      <?php if ( false === strpos( get_class( $product ), 'Subscription' ) ) : ?>
        <p class="product-single__price"><?php echo wc_price($product->get_price_including_tax(1, $product->get_sale_price())); ?></p>

        <form action="<?php the_permalink() ?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->id); ?>">

          <div class="product-single__qty">
            <button type="button" class="product-single__qty-minus">-</button>
            <input type="number" name="quantity" class="product-single__qty-input" value="1" step="1" max="99" min="1" required>
            <button type="button" class="product-single__qty-plus">+</button>
          </div>

          <button type="submit" class="btn btn--purple btn--medium">Add to cart</button>
        </form>
      <?php else: ?>
        <?php do_action( 'woocommerce_single_product_summary' ); ?>
      <?php endif; ?>
    </div>
  </section>

  <section class="product-section product-desc">
    <div class="wrap wrap-center">
      <h3>Description</h3>

      <?php the_content() ?>
    </div>
  </section>

  <section class="product-section product-reviews">
    <div class="wrap wrap-center">
      <h3>Reviews</h3>

      <!-- Disqus -->
      <div id="disqus_thread"></div>
      <script>

      /**
      *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
      *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
      /*
      var disqus_config = function () {
      this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
      this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
      };
      */
      (function() { // DON'T EDIT BELOW THIS LINE
      var d = document, s = d.createElement('script');
      s.src = '//ebanx-demo-store.disqus.com/embed.js';
      s.setAttribute('data-timestamp', +new Date());
      (d.head || d.body).appendChild(s);
      })();
      </script>
      <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

    </div>
  </section>

  <?php get_template_part('template', 'one-click') ?>

</div>

<?php get_footer() ?>
