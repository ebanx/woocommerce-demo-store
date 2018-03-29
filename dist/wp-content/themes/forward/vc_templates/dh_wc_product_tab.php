<?php
$output ='';
extract(shortcode_atts(array(
	'title'=>'',
	'title_badge'=>'',
	'tab_color'=>'',
	'tab_banner'=>'',
	'href'=>'',
	'target'=>'',
	'category'=>'',
	'per_page'=>'5',
	'columns'=>'4',
	'show'=>'',
	'orderby'=>'date',
	'order'=>'asc',
	'hide_free'=>'',
	'show_hidden'=>'',
	'el_class' => ''
),$atts));

$tab_color = dh_format_color($tab_color);
$title_badge = wp_get_attachment_url(absint($title_badge));
$tab_banner = wp_get_attachment_url(absint($tab_banner));
if ( $target == 'same' || $target == '_self' ) {
	$target = '';
}
$target = ( $target != '' ) ? ' target="' . $target . '"' : '';

global $woocommerce_loop;
$woocommerce_loop['columns'] = $columns;


$category_arr = explode(',', $category);
//$category_arr = array_filter($category_arr);
$category_arr = array_map( 'trim', $category_arr );
/**
 * script
 * {{
 */
wp_enqueue_script( 'wc-add-to-cart-variation' );
wp_enqueue_script('carouFredSel');

$query_args = array(
	'posts_per_page' => $per_page,
	'post_status'    => 'publish',
	'post_type'      => 'product',
	'order'          => $order,
	'meta_query'     => array(),
);
if ( !empty( $show_hidden ) ) {
	$query_args['meta_query'][] = WC()->query->visibility_meta_query();
	$query_args['post_parent']  = 0;
}

if ( !empty( $hide_free ) ) {
	$query_args['meta_query'][] = array(
		'key'     => '_price',
		'value'   => 0,
		'compare' => '>',
		'type'    => 'DECIMAL',
	);
}

$query_args['meta_query'][] = WC()->query->stock_status_meta_query();
$query_args['meta_query']   = array_filter( $query_args['meta_query'] );

switch ( $show ) {
	case 'featured' :
		$query_args['meta_query'][] = array(
		'key'   => '_featured',
		'value' => 'yes'
			);
			break;
	case 'onsale' :
		$product_ids_on_sale    = wc_get_product_ids_on_sale();
		$product_ids_on_sale[]  = 0;
		$query_args['post__in'] = $product_ids_on_sale;
		break;
}
switch ( $orderby ) {
	case 'price' :
		$query_args['meta_key'] = '_price';
		$query_args['orderby']  = 'meta_value_num';
		break;
	case 'rand' :
		$query_args['orderby']  = 'rand';
		break;
	case 'sales' :
		$query_args['meta_key'] = 'total_sales';
		$query_args['orderby']  = 'meta_value_num';
		break;
	default :
		$query_args['orderby']  = 'date';
}


$itemSelector = '';
ob_start();
if(is_array($category_arr) && count($category_arr) > 0):
	?>
	<div class="woocommerce products-tab clearfix <?php echo esc_attr($el_class)?>">
		<div class="products-tab-control col-sm-3">
			<?php if(!empty($title)){?>
			<h3 class="el-heading"<?php if(!empty($tab_color)){?> style="background-color:<?php echo esc_attr($tab_color)?>"<?php }?>>
				<?php if(!empty($title_badge)):?>
				<img src="<?php echo esc_attr($title_badge)?>" alt="">
				<?php endif;?>
				<?php echo esc_html($title)?>
			</h3>
			<?php }?>
			<ul class="nav nav-tabs" role="tablist">
				<?php $i = 0;?>
				<?php foreach ($category_arr as $cat):?>
					<?php if($cat):?>
						<?php $category = get_term_by('slug',$cat, 'product_cat'); ?>
						<?php if($category): ?>
						<li<?php if($i == 0) echo ' class="active"'?> role="presentation">
							<a class="product-tab-control" data-columns="<?php echo esc_attr($columns)?>" data-query="<?php echo esc_attr(json_encode($query_args))?>" data-cat_slug="<?php echo esc_attr($category->slug)?>" <?php if(!empty($tab_color)){?> data-color="<?php echo esc_attr($tab_color)?>" onmouseout="this.style.color=''" onmouseover="this.style.color='<?php echo esc_attr($tab_color)?>'" <?php }?> href="<?php echo '#'.$category->slug ?>" aria-controls="home" role="tab" data-toggle="tab"><?php echo esc_html($category->name); ?></a>
						</li>
						<?php $i++;?>
						<?php endif;?>
					<?php endif;?>
				<?php endforeach;?>
			</ul>
			<?php if(!empty($tab_banner)):?>
			<div class="tab-banner">
				<a <?php echo !empty($href) ? 'href="'.esc_attr($href).'"':''?> <?php echo esc_attr($target)?>>
					<img src="<?php echo esc_attr($tab_banner)?>" alt="">
				</a>
			</div>
			<?php endif;?>
		</div>
		<div class="tab-content col-sm-9">
			<?php
			$j = 0;
			foreach ($category_arr as $cat):
			?>
			<div role="tabpanel" class="tab-pane<?php if($j  == 0) echo ' active'?>" id="<?php echo esc_attr($cat)?>">
				<div class="filter-ajax-loading">
					<div class="fade-loading"><i></i><i></i><i></i><i></i></div>
				</div>
			</div>
			<?php
			$j++;
			endforeach;
			?>
		</div>
	</div>
	<?php
endif;
$output = ob_get_clean();
wp_reset_postdata();
echo $output;