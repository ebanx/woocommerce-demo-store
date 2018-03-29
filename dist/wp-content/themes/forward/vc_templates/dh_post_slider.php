<?php
$output = '';
extract(shortcode_atts(array(
	'columns'			=>'2',
	'posts_per_page'	=>'12',
	'orderby'			=>'latest',
	'hide_pagination'   =>'',
	'hide_nav'          =>'',
	'hide_date'			=>'',
	'hide_author'		=>'',
	'hide_comment'		=>'',
	'hide_category'		=>'',
	'hide_readmore'		=>'',
	'hide_excerpt'      =>'',
	'excerpt_length'    =>'15',
	'categories'		=>'',
	'visibility'		=>'',
	'el_class'			=>'',
), $atts));
wp_enqueue_script('carouFredSel');

$show_date = empty($hide_date) ? true : false;
$show_author = empty($hide_author)  ? true : false;
$show_category = empty($hide_category) ? true : false;
$show_comment = empty($hide_comment) ? true : false;
$show_pagination = empty($hide_pagination)  ? true : false;
$show_nav = empty($hide_nav)  ? true : false;
$show_excerpt = empty($hide_excerpt)  ? true : false;


$class          = !empty($el_class) ?  ' '.esc_attr( $el_class ) : '';
switch ($visibility) {
	case 'hidden-phone':
		$class .= ' hidden-xs';
		break;
	case 'hidden-tablet':
		$class .= ' hidden-sm hidden-md';
		break;
	case 'hidden-pc':
		$class .= ' hidden-lg';
		break;
	case 'visible-phone':
		$class .= ' visible-xs-inline';
		break;
	case 'visible-tablet':
		$class .= ' visible-sm-inline visible-md-inline';
		break;
	case 'visible-pc':
		$class .= ' visible-lg-inline';
		break;
}

$order = 'DESC';
switch ($orderby) {
	case 'latest':
		$orderby = 'date';
		break;

	case 'oldest':
		$orderby = 'date';
		$order = 'ASC';
		break;

	case 'alphabet':
		$orderby = 'title';
		$order = 'ASC';
		break;

	case 'ralphabet':
		$orderby = 'title';
		break;

	default:
		$orderby = 'date';
		break;
}

$args = array(
	'orderby'         => "{$orderby}",
	'order'           => "{$order}",
	'post_type'       => "post",
	'posts_per_page'  => "12"
);
if(!empty($posts_per_page))
	$args['posts_per_page'] = $posts_per_page;

if(!empty($categories)){
	$args['category_name'] = $categories;
}
$r = new WP_Query($args);
$post_col = '';
$post_col = 'col-sm-'.(12/$columns).' ';
if($r->have_posts()):
	ob_start();
	?>
	<div class="post-slider">
		<div class="caroufredsel post-slider-wrap caroufredsel-item-no-padding row" data-scroll-fx="scroll" data-height="variable" data-speed="500" data-scroll-item="1" data-visible-min="1" data-visible-max="<?php echo esc_attr($columns) ?>" data-responsive="1" data-infinite="1" data-autoplay="0">
			<div class="caroufredsel-wrap">
				<ul class="caroufredsel-items">
					<?php while ($r->have_posts()): $r->the_post(); global $post;?>
						<li class="<?php echo esc_attr($post_col) ?>">
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
								<?php if(get_post_format() == 'link'):?>
								<?php $link = dh_get_post_meta('link'); ?>
								<div class="hentry-wrap hentry-wrap-link">
									<div class="entry-content">
										<div class="link-content">
											<a target="_blank" href="<?php echo esc_url($link) ?>">
												<span><?php the_title()?></span>
												<cite><?php echo esc_url($link) ?></cite>
											</a>
										</div>
									</div>
								</div>
								<?php elseif (get_post_format() == 'quote'):?>
								<div class="hentry-wrap hentry-wrap-link">
									<div class="entry-content">
										<div class="quote-content">
											<a href="<?php the_permalink()?>">
												<span>
													<?php echo dh_get_post_meta('quote'); ?>
												</span>
												<cite><i class="fa fa-quote-left"></i> <?php the_title(); ?></cite>
											</a>
										</div>
									</div>
								</div>
								<?php else:?>
								<div class="hentry-wrap">
									
									<?php 
										$entry_featured_class = '';
										dh_post_featured('','',true,false,$entry_featured_class,'', false);
									?>
									
									<div class="entry-info">
										<div class="info-inner">
											<div class="entry-header">
												<h2 class="entry-title" itemprop="name">
													<a href="<?php the_permalink()?>" title="<?php echo esc_attr(get_the_title())?>">
														<?php the_title()?>
													</a>
												</h2>
											</div>
											<div class="entry-content">
												<?php 
												if($show_excerpt == 'true'){
													$excerpt = $post->post_excerpt;
													if(empty($excerpt))
														$excerpt = $post->post_content;
													
													$excerpt = strip_shortcodes($excerpt);
													$excerpt = wp_trim_words($excerpt,$excerpt_length,'...');
													echo '<p>' . $excerpt . '</p>';
												}
												?>
								
											</div>
											<div class="clearfix">
												<div class="entry-meta icon-meta">
													<?php 
													dh_post_meta($show_date,$show_comment,$show_category,$show_author,true,false,'M d, Y',true); 
													?>
												</div>

												<?php if(empty($hide_readmore)):?>
													<div class="readmore-link">
														<a href="<?php the_permalink()?>"><?php esc_html_e("Read More", 'forward');?></a>
													</div>
												<?php endif;?>
											</div>
										</div><!--inner-->
									</div>
								</div>
								<?php endif;?>
							</article>
						</li>
					<?php endwhile;?>
				</ul>
				<?php if($show_nav == 'true') :?>
					<a href="#" class="caroufredsel-prev"></a>
					<a href="#" class="caroufredsel-next"></a>
				<?php endif;?>
			</div>
			
			<?php if($show_pagination == 'true') :?>
				<div class="caroufredsel-pagination">
				</div>
			<?php endif;?>
		</div>
	</div>
	<?php
	$html = ob_get_clean();
	echo $html;
endif;
wp_reset_postdata();