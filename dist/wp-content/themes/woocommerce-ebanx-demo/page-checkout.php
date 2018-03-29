<?php get_header() ?>

  <section class="check-out">
    <div class="wrap">
      <?php if (!is_order_received_page()): ?>
        <h3>Checkout</h3>
      <?php endif ?>

      <div class="check-out__content">
        <?php the_content() ?>
      </div>
    </div>
  </section>

<?php get_footer() ?>
