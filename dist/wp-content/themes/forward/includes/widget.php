<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DH_Widget extends WP_Widget {
	public $widget_cssclass;
	public $widget_description;
	public $widget_id;
	public $widget_name;
	public $settings;
	public $cached = true;
	/**
	 * Constructor
	 */
	public function __construct() {
	
		$widget_ops = array(
				'classname'   => $this->widget_cssclass,
				'description' => $this->widget_description
		);
	
		parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );
		if($this->cached){
			add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
			add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
			add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
		}
	}
	
	/**
	 * get_cached_widget function.
	 */
	function get_cached_widget( $args ) {
	
		$cache = wp_cache_get( apply_filters( 'dh_cached_widget_id', $this->widget_id ), 'widget' );
	
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}
	
		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return true;
		}
	
		return false;
	}
	
	/**
	 * Cache the widget
	 * @param string $content
	 */
	public function cache_widget( $args, $content ) {
		$cache[ $args['widget_id'] ] = $content;
	
		wp_cache_set( apply_filters( 'dh_cached_widget_id', $this->widget_id ), $cache, 'widget' );
	}
	
	/**
	 * Flush the cache
	 *
	 * @return void
	 */
	public function flush_widget_cache() {
		wp_cache_delete( apply_filters( 'dh_cached_widget_id', $this->widget_id ), 'widget' );
	}
	
	/**
	 * Output the html at the start of a widget
	 *
	 * @param  array $args
	 * @return string
	 */
	public function widget_start( $args, $instance ) {
		echo $args['before_widget'];
	
		if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
	}
	
	/**
	 * Output the html at the end of a widget
	 *
	 * @param  array $args
	 * @return string
	 */
	public function widget_end( $args ) {
		echo $args['after_widget'];
	}
	
	/**
	 * update function.
	 *
	 * @see WP_Widget->update
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;
	
		if ( ! $this->settings ) {
			return $instance;
		}
	
		foreach ( $this->settings as $key => $setting ) {
			
			if(isset($setting['multiple'])):
				$instance[ $key ] = implode ( ',', $new_instance [$key] );
			else:
				if ( isset( $new_instance[ $key ] ) ) {
					$instance[ $key ] = sanitize_text_field( $new_instance[ $key ] );
				} elseif ( 'checkbox' === $setting['type'] ) {
					$instance[ $key ] = 0;
				}
			endif;
		}
		if($this->cached){
			$this->flush_widget_cache();
		}
	
		return $instance;
	}
	
	/**
	 * form function.
	 *
	 * @see WP_Widget->form
	 * @param array $instance
	 */
	public function form( $instance ) {
	
		if ( ! $this->settings ) {
			return;
		}
		foreach ( $this->settings as $key => $setting ) {
			$value   = isset( $instance[ $key ] ) ? $instance[ $key ] : $setting['std'];
			switch ( $setting['type'] ) {
			case "text" :
			?>
				<p>
					<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting['label']; ?></label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
				</p>
				<?php
			break;

			case "number" :
				?>
				<p>
					<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting['label']; ?></label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="number" step="<?php echo esc_attr( $setting['step'] ); ?>" min="<?php echo esc_attr( $setting['min'] ); ?>" max="<?php echo esc_attr( $setting['max'] ); ?>" value="<?php echo esc_attr( $value ); ?>" />
				</p>
				<?php
			break;
			case "select" :
				if(isset($setting['multiple'])):
				$value = explode(',', $value);
				endif;
				?>
				<p>
					<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting['label']; ?></label>
					<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" <?php if(isset($setting['multiple'])):?> multiple="multiple"<?php endif;?> name="<?php echo $this->get_field_name( $key ); ?><?php if(isset($setting['multiple'])):?>[]<?php endif;?>">
						<?php foreach ( $setting['options'] as $option_key => $option_value ) : ?>
							<option value="<?php echo esc_attr( $option_key ); ?>" <?php if(isset($setting['multiple'])): selected( in_array ( $option_key, $value ) , true ); else: selected( $option_key, $value ); endif; ?>><?php echo esc_html( $option_value ); ?></option>
						<?php endforeach; ?>
					</select>
				</p>
				<?php
			break;

			case "checkbox" :
				?>
				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" type="checkbox" value="1" <?php checked( $value, 1 ); ?> />
					<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting['label']; ?></label>
				</p>
				<?php
			break;
			}
		}
	}
}

class DH_Social_Widget extends DH_Widget {
	public function __construct(){
		$this->widget_cssclass    = 'social-widget';
		$this->widget_description = __( "Display Social Icon.", 'forward' );
		$this->widget_id          = 'DH_Social_Widget';
		$this->widget_name        = __( 'Social', 'forward' );
		
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'	=>'',
				'label' => __( 'Title', 'forward' )
			),
			'social' => array(
					'type'  => 'select',
					'std'   => '',
					'multiple'=>true,
					'label'=>__('Social','forward'),
					'desc' => __( 'Select socials', 'forward' ),
					'options' => array(
						'facebook'=>'Facebook',
						'twitter'=>'Twitter',
						'google-plus'=>'Google Plus',
						'pinterest'=>'Pinterest',
						'linkedin'=>'Linkedin',
						'rss'=>'Rss',
						'instagram'=>'Instagram',
						'github'=>'Github',
						'behance'=>'Behance',
						'stack-exchange'=>'Stack Exchange',
						'tumblr'=>'Tumblr',
						'soundcloud'=>'SoundCloud',
						'dribbble'=>'Dribbble',
						'youtube'=>'Youtube'
					),
			),
			'style' => array(
				'type'  => 'select',
				'std'   => '',
				'label' => __( 'Style', 'forward' ),
				'options' => array(
					'none' =>  __('None', 'forward' ),
					'square' =>  __('Square', 'forward' ),
					'round' =>  __('Round', 'forward' ),
					'outlined' =>  __('Outlined', 'forward' ),
				)
			),
		);
		parent::__construct();
	}
	
	public function widget($args, $instance){
		ob_start();
		extract( $args );
		$title       = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$social = isset($instance['social']) ? explode(',',$instance['social']) : array();
		$style = isset($instance['style']) ? $instance['style'] : 'square';
		if(!empty($social)){
			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;
			echo '<div class="social-widget-wrap social-widget-'.$style.'">';
			$hover = false;
			$soild_bg = true;
			$outlined = false;
			if($style == 'none'){
				$soild_bg = false;
			}
			if($style == 'outlined'){
				$hover = true;
				$soild_bg = false;
				$outlined = true;
			}
			dh_social($social,$hover,$soild_bg,$outlined);
			echo '</div>';
			echo $after_widget;
			$content = ob_get_clean();
			echo $content;
		}
	}
	
}

class DH_Tweets extends WP_Widget {
	public function __construct() {
		parent::__construct (
			'dh_tweets', 		// Base ID
			'Recent Tweets', 		// Name
			array ('classname'=>'tweets-widget','description' => __ ( 'Display recent tweets', 'forward' ) )
		);
	}
	

	private function _getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		return $connection;
	}

	public function widget($args, $instance) {
		extract($args);
		if(!empty($instance['title'])){ $title = apply_filters( 'widget_title', $instance['title'] ); }
		echo $before_widget;
		if ( ! empty( $title ) ){ echo $before_title . $title . $after_title; }

		//check settings and die if not set
		if(empty($instance['consumerkey']) || empty($instance['consumersecret']) || empty($instance['accesstoken']) || empty($instance['accesstokensecret']) || empty($instance['cachetime']) || empty($instance['username'])){
			echo '<strong>'.__('Please fill all widget settings!' , 'forward').'</strong>' . $after_widget;
			return;
		}

		$dh_widget_recent_tweets_cache_time = get_option('dh_widget_recent_tweets_cache_time');
		$diff = time() - $dh_widget_recent_tweets_cache_time;

		$crt = (int) $instance['cachetime'] * 3600;

		if($diff >= $crt || empty($dh_widget_recent_tweets_cache_time)){
			
			if(!require_once(DHINC_DIR . '/lib/twitteroauth.php')){
				echo '<strong>'.__('Couldn\'t find twitteroauth.php!','forward').'</strong>' . $after_widget;
				return;
			}
				
				
			$connection = $this->_getConnectionWithAccessToken($instance['consumerkey'], $instance['consumersecret'], $instance['accesstoken'], $instance['accesstokensecret']);
			$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$instance['username']."&count=10&exclude_replies=".$instance['excludereplies']);

			if(!empty($tweets->errors)){
				if($tweets->errors[0]->message == 'Invalid or expired token'){
					echo '<strong>'.$tweets->errors[0]->message.'!</strong><br/>'.__('You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!', 'forward' ) . $after_widget;
				}else{
					echo '<strong>'.$tweets->errors[0]->message.'</strong>' . $after_widget;
				}
				return;
			}
				
			$tweets_array = array();
			for($i = 0;$i <= count($tweets); $i++){
				if(!empty($tweets[$i])){
					$tweets_array[$i]['created_at'] = $tweets[$i]->created_at;

					//clean tweet text
					$tweets_array[$i]['text'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $tweets[$i]->text);

					if(!empty($tweets[$i]->id_str)){
						$tweets_array[$i]['status_id'] = $tweets[$i]->id_str;
					}
				}
			}
			update_option('dh_widget_recent_tweets',serialize($tweets_array));
			update_option('dh_widget_recent_tweets_cache_time',time());
		}

		$dh_widget_recent_tweets = maybe_unserialize(get_option('dh_widget_recent_tweets'));
		if(!empty($dh_widget_recent_tweets)){
			echo '<div class="recent-tweets"><ul>';
			$i = '1';
			foreach($dh_widget_recent_tweets as $tweet){
				if(!empty($tweet['text'])){
					if(empty($tweet['status_id'])){ $tweet['status_id'] = ''; }
					if(empty($tweet['created_at'])){ $tweet['created_at'] = ''; }
						
					echo '<li><span>'.$this->_convert_links($tweet['text']).'</span><a class="twitter_time" target="_blank" href="http://twitter.com/'.$instance['username'].'/statuses/'.$tweet['status_id'].'">'.ucfirst($this->_relative_time($tweet['created_at'])).'</a></li>';
					if($i == $instance['tweetstoshow']){ break; }
					$i++;
				}
			}
				
			echo '</ul></div>';
		}

		echo $after_widget;
	}

	protected function _convert_links($status, $targetBlank = true, $linkMaxLen=50){
		// the target
		$target=$targetBlank ? " target=\"_blank\" " : "";

		// convert link to url
		$status = preg_replace("/((http:\/\/|https:\/\/)[^ )]+)/i", "<a href=\"$1\" title=\"$1\" $target >$1</a>", $status);

		// convert @ to follow
		$status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);

		// convert # to search
		$status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);

		// return the status
		return $status;
	}

	protected function _relative_time($a=''){
		//get current timestampt
		$b = strtotime("now");
		//get timestamp when tweet created
		$c = strtotime($a);
		//get difference
		$d = $b - $c;
		//calculate different time values
		$minute = 60;
		$hour = $minute * 60;
		$day = $hour * 24;
		$week = $day * 7;

		if(is_numeric($d) && $d > 0) {
			//if less then 3 seconds
			if($d < 3) return "right now";
			//if less then minute
			if($d < $minute) return sprintf(__("%s seconds ago",'forward'),floor($d));
			//if less then 2 minutes
			if($d < $minute * 2) return __("about 1 minute ago",'forward');
			//if less then hour
			if($d < $hour) return sprintf(__('%s minutes ago','forward'), floor($d / $minute));
			//if less then 2 hours
			if($d < $hour * 2) return __("about 1 hour ago",'forward');
			//if less then day
			if($d < $day) return sprintf(__("%s hours ago", 'forward'),floor($d / $hour));
			//if more then day, but less then 2 days
			if($d > $day && $d < $day * 2) return __("yesterday",'forward');
			//if less then year
			if($d < $day * 365) return sprintf(__('%s days ago','forward'),floor($d / $day));
			//else return more than a year
			return __("over a year ago",'forward');
		}
	}

	public function form($instance) {
		$defaults = array (
			'title' => '',
			'consumerkey' => '',
			'consumersecret' => '',
			'accesstoken' => '',
			'accesstokensecret' => '',
			'cachetime' => '',
			'username' => '',
			'tweetstoshow' => ''
		);
		$instance = wp_parse_args ( ( array ) $instance, $defaults );

		echo '
		<p>
			<label>' . __ ( 'Title' , 'forward' ) . ':</label>
			<input type="text" name="' . $this->get_field_name ( 'title' ) . '" id="' . $this->get_field_id ( 'title' ) . '" value="' . esc_attr ( $instance ['title'] ) . '" class="widefat" />
		</p>
		<p>
			<label>' . __ ( 'Consumer Key' , 'forward' ) . ':</label>
			<input type="text" name="' . $this->get_field_name ( 'consumerkey' ) . '" id="' . $this->get_field_id ( 'consumerkey' ) . '" value="' . esc_attr ( $instance ['consumerkey'] ) . '" class="widefat" />
		</p>
		<p>
			<label>' . __ ( 'Consumer Secret' , 'forward' ) . ':</label>
			<input type="text" name="' . $this->get_field_name ( 'consumersecret' ) . '" id="' . $this->get_field_id ( 'consumersecret' ) . '" value="' . esc_attr ( $instance ['consumersecret'] ) . '" class="widefat" />
		</p>
		<p>
			<label>' . __ ( 'Access Token' , 'forward' ) . ':</label>
			<input type="text" name="' . $this->get_field_name ( 'accesstoken' ) . '" id="' . $this->get_field_id ( 'accesstoken' ) . '" value="' . esc_attr ( $instance ['accesstoken'] ) . '" class="widefat" />
		</p>
		<p>
			<label>' . __ ( 'Access Token Secret' , 'forward' ) . ':</label>
			<input type="text" name="' . $this->get_field_name ( 'accesstokensecret' ) . '" id="' . $this->get_field_id ( 'accesstokensecret' ) . '" value="' . esc_attr ( $instance ['accesstokensecret'] ) . '" class="widefat" />
		</p>
		<p>
			<label>' . __ ( 'Cache Tweets in every' , 'forward' ) . ':</label>
			<input type="text" name="' . $this->get_field_name ( 'cachetime' ) . '" id="' . $this->get_field_id ( 'cachetime' ) . '" value="' . esc_attr ( $instance ['cachetime'] ) . '" class="small-text" />'.__('hours','forward').'
		</p>
		<p>
			<label>' . __ ( 'Twitter Username' , 'forward' ) . ':</label>
			<input type="text" name="' . $this->get_field_name ( 'username' ) . '" id="' . $this->get_field_id ( 'username' ) . '" value="' . esc_attr ( $instance ['username'] ) . '" class="widefat" />
		</p>
		<p>
			<label>' . __ ( 'Tweets to display' , 'forward' ) . ':</label>
			<select type="text" name="' . $this->get_field_name ( 'tweetstoshow' ) . '" id="' . $this->get_field_id ( 'tweetstoshow' ) . '">';
		$i = 1;
		for($i; $i <= 10; $i ++) {
			echo '<option value="' . $i . '"';
			if ($instance ['tweetstoshow'] == $i) {
				echo ' selected="selected"';
			}
			echo '>' . $i . '</option>';
		}
		echo '
			</select>
		</p>
		<p>
			<label>' . __ ( 'Exclude replies', 'forward' ) . ':</label>
			<input type="checkbox" name="' . $this->get_field_name ( 'excludereplies' ) . '" id="' . $this->get_field_id ( 'excludereplies' ) . '" value="true"';
		if (! empty ( $instance ['excludereplies'] ) && esc_attr ( $instance ['excludereplies'] ) == 'true') {
			echo ' checked="checked"';
		}
		echo '/></p>';
	}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['consumerkey'] = strip_tags( $new_instance['consumerkey'] );
		$instance['consumersecret'] = strip_tags( $new_instance['consumersecret'] );
		$instance['accesstoken'] = strip_tags( $new_instance['accesstoken'] );
		$instance['accesstokensecret'] = strip_tags( $new_instance['accesstokensecret'] );
		$instance['cachetime'] = strip_tags( $new_instance['cachetime'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['tweetstoshow'] = strip_tags( $new_instance['tweetstoshow'] );
		$instance['excludereplies'] = strip_tags( $new_instance['excludereplies'] );

		if($old_instance['username'] != $new_instance['username']){
			delete_option('dh_widget_recent_tweets_cache_time');
		}

		return $instance;
	}
}



class DH_Post_Thumbnail_Widget extends DH_Widget {

	public function __construct() {
		$this->widget_cssclass    = 'widget-post-thumbnail';
		$this->widget_description = __( "Widget post with thumbnail.", 'forward' );
		$this->widget_id          = 'dh_widget_post_thumbnail';
		$this->widget_name        = __( 'Post Thumbnail', 'forward' );
		$this->cached = false;
		$categories = get_categories( array(
				'orderby' => 'NAME',
				'order' => 'ASC'
		));
		$categories_options = array();
		foreach ((array)$categories as $category) {
			$categories_options[$category->term_id] = $category->name;
		}
		$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'std'	=>'',
					'label' => __( 'Title', 'forward' )
				),
				'posts_per_page' => array(
					'type'  => 'number',
					'step'  => 1,
					'min'   => 1,
					'max'   => '',
					'std'   => 5,
					'label' => __( 'Number of posts to show', 'forward' )
				),
				'orderby' => array(
					'type'  => 'select',
					'std'   => 'date',
					'label' => __( 'Order by', 'forward' ),
					'options' => array(
							'latest'   => __( 'Latest', 'forward' ),
							'comment'  => __( 'Most Commented', 'forward' ),
					)
				),
				'categories' => array(
						'type'  => 'select',
						'std'   => '',
						'multiple'=>true,
						'label'=>__('Categories','forward'),
						'desc' => __( 'Select a category or leave blank for all', 'forward' ),
						'options' => $categories_options,
				),
				'hide_date' => array(
						'type'  => 'checkbox',
						'std'   => 0,
						'label' => __( 'Hide date in post meta info', 'forward' )
				),
				'hide_comment' => array(
						'type'  => 'checkbox',
						'std'   => 0,
						'label' => __( 'Hide comment in post meta info', 'forward' )
				),
		);
		parent::__construct();
	}
	
	public function widget($args, $instance){
		ob_start();
		extract( $args );
		$title       = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$posts_per_page      = absint( $instance['posts_per_page'] );
		$orderby     = sanitize_title( $instance['orderby'] );
		$hide_date = isset($instance['hide_date']) && $instance['hide_date'] === '1' ? true : false;
		$hide_comment = isset($instance['hide_comment']) && $instance['hide_comment'] === '1' ? true : false;
		$categories  = $instance['categories'];
		$query_args  = array(
				'posts_per_page' => $posts_per_page,
				'post_status' 	 => 'publish',
				'ignore_sticky_posts' => 1,
				'orderby' => 'date',
				"meta_key" => "_thumbnail_id",
				'order' => 'DESC',
		);
		if($orderby == 'comment'){
			$query_args['orderby'] = 'comment_count';
		}
		if(!empty($categories)){
			$query_args['cat'] = $categories;
		}
		$r = new WP_Query($query_args);
		if($r->have_posts()):
			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;
				echo '<ul class="posts-thumbnail-list">';
				while ($r->have_posts()): $r->the_post();global $post;
					echo '<li>';
					echo '<div class="posts-thumbnail-image">';
					echo '<a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(null,'dh-thumbnail-square', array('title' => strip_tags(get_the_title()))).'</a>';
					echo '</div>';
					echo '<div class="posts-thumbnail-content">';
						echo '<h4><a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr(get_the_title()).'">'.get_the_title().'</a></h4>';
						echo '<div class="posts-thumbnail-meta">';
						if(!$hide_date)
							echo '<time datetime="'.get_the_date('c').'">'.get_the_date().'</time>';
						
						if(!$hide_date && !$hide_comment)
							echo ', ';
						
						if(!$hide_comment){
							$output = '';
							$number = get_comments_number($post->ID);
							if ( $number > 1 ) {
								$output = str_replace( '%', number_format_i18n( $number ), ( false === false ) ? __( '% Comments','forward' ) : false );
							} elseif ( $number == 0 ) {
								$output = ( false === false ) ? __( '0 Comments','forward' ) : false;
							} else { // must be one
								$output = ( false === false ) ? __( '1 Comment' ,'forward') : false;
							}
							echo '<span class="comment-count"><a href="'.esc_url(get_comments_link()).'">'.$output.'</a></span>';	
						}
						echo '</div>';
					echo '</div>';
					echo '</li>';
				endwhile;
				echo  '</ul>';
			echo $after_widget;
		endif;
		$content = ob_get_clean();
		wp_reset_postdata();
		echo $content;
	}
	
}

class DH_Mailchimp_Widget extends DH_Widget {
	public function __construct(){
		$this->widget_cssclass    = 'widget-mailchimp';
		$this->widget_description = __( "Widget Mailchimp Subscribe.", 'forward' );
		$this->widget_id          = 'dh_widget_mailchimp';
		$this->widget_name        = __( 'Mailchimp Subscribe', 'forward' );
		$this->cached = false;
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'	=>'',
				'label' => __( 'Title', 'forward' )
			),
		);
		parent::__construct();
	}
	
	public function widget($args, $instance){
		extract( $args );
		$title       = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		ob_start();
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		dh_mailchimp_form();
		echo $after_widget;
		$content = ob_get_clean();
		echo $content;
	}
}

class DH_Woocommerce_Swatches_Widget extends DH_Widget{
	public function __construct(){
		$this->widget_cssclass    = 'woocommerce widget_swatches';
		$this->widget_description = __( 'Shows a custom attribute in a widget when viewing product categories width Swatches and Photo .', 'forward' );
		$this->widget_id          = 'dh_widget_swatches';
		$this->widget_name        = __( 'DH Woocommerce Swatches Layered Nav', 'forward' );
		parent::__construct();
	}
	
	public function update( $new_instance, $old_instance ) {
		$this->init_settings();
	
		return parent::update( $new_instance, $old_instance );
	}
	
	public function form( $instance ) {
		$this->init_settings();
	
		parent::form( $instance );
	}
	
	public function init_settings() {
		$attribute_array      = array();
		$attribute_taxonomies = wc_get_attribute_taxonomies();
	
		if ( $attribute_taxonomies ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
					$attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
				}
			}
		}
	
		$this->settings = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Filter by', 'forward' ),
				'label' => __( 'Title', 'forward' )
			),
			'attribute' => array(
				'type'    => 'select',
				'std'     => '',
				'label'   => __( 'Attribute', 'forward' ),
				'options' => $attribute_array
			),
			'query_type' => array(
				'type'    => 'select',
				'std'     => 'and',
				'label'   => __( 'Query type', 'forward' ),
				'options' => array(
					'and' => __( 'AND', 'forward' ),
					'or'  => __( 'OR', 'forward' )
				)
			),
		);
	}
	
	protected function _get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
		global $wpdb;

		$tax_query  = WC_Query::get_main_tax_query();
		$meta_query = WC_Query::get_main_meta_query();

		if ( 'or' === $query_type ) {
			foreach ( $tax_query as $key => $query ) {
				if ( $taxonomy === $query['taxonomy'] ) {
					unset( $tax_query[ $key ] );
				}
			}
		}

		$meta_query      = new WP_Meta_Query( $meta_query );
		$tax_query       = new WP_Tax_Query( $tax_query );
		$meta_query_sql  = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql   = $tax_query->get_sql( $wpdb->posts, 'ID' );

		// Generate query
		$query           = array();
		$query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
		$query['from']   = "FROM {$wpdb->posts}";
		$query['join']   = "
			INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
			INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
			INNER JOIN {$wpdb->terms} AS terms USING( term_id )
			" . $tax_query_sql['join'] . $meta_query_sql['join'];
		$query['where']   = "
			WHERE {$wpdb->posts}.post_type IN ( 'product' )
			AND {$wpdb->posts}.post_status = 'publish'
			" . $tax_query_sql['where'] . $meta_query_sql['where'] . "
			AND terms.term_id IN (" . implode( ',', array_map( 'absint', $term_ids ) ) . ")
		";
		$query['group_by'] = "GROUP BY terms.term_id";
		$query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
		$query             = implode( ' ', $query );
		$results           = $wpdb->get_results( $query );

		return wp_list_pluck( $results, 'term_count', 'term_count_id' );
	}
	
	protected function _get_current_term_id() {
		return absint( is_tax() ? get_queried_object()->term_id : 0 );
	}
	
	public function widget($args, $instance){
		global $_chosen_attributes,$woocommerce;
		$_chosen_attributes2 = $_chosen_attributes;
		if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
			return;
		}
		if(empty($_chosen_attributes2)){
			$_chosen_attributes2 = WC_Query::get_layered_nav_chosen_attributes();
		}
		$current_term = is_tax() ? get_queried_object()->term_id : '';
		$current_tax  = is_tax() ? get_queried_object()->taxonomy : '';
		$taxonomy     = isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name( $instance['attribute'] ) : $this->settings['attribute']['std'];
		$query_type   = isset( $instance['query_type'] ) ? $instance['query_type'] : $this->settings['query_type']['std'];
		$display_type = isset( $instance['display_type'] ) ? $instance['display_type'] : $this->settings['display_type']['std'];
		
		if ( ! taxonomy_exists( $taxonomy ) ) {
			return;
		}
		
		$get_terms_args = array( 'hide_empty' => '1' );
		
		$orderby = wc_attribute_orderby( $taxonomy );
		
		switch ( $orderby ) {
			case 'name' :
				$get_terms_args['orderby']    = 'name';
				$get_terms_args['menu_order'] = false;
				break;
			case 'id' :
				$get_terms_args['orderby']    = 'id';
				$get_terms_args['order']      = 'ASC';
				$get_terms_args['menu_order'] = false;
				break;
			case 'menu_order' :
				$get_terms_args['menu_order'] = 'ASC';
				break;
		}
		
		$terms = get_terms( $taxonomy, $get_terms_args );
		
		$wc_query_has_filtered_product_ids = true;
		if(isset($woocommerce->query->filtered_product_ids)){
			$filtered_product_ids = $woocommerce->query->filtered_product_ids;
			$unfiltered_product_ids = $woocommerce->query->unfiltered_product_ids;
		}else{
			$wc_query_has_filtered_product_ids = false;
			$filtered_product_ids = $this->_get_filtered_term_product_counts(wp_list_pluck( $terms, 'term_id' ), $taxonomy,$query_type);
		}
		
		
		$width = 32;
		$height = 32;
		$swatch_type_options = array('color','photo');
		//$swatch_type_options = maybe_unserialize( get_post_meta( $product_id, '_swatch_type_options', true ) );
		
// 		if ( !$swatch_type_options ) {
// 			$swatch_type_options = array();
// 		}
		if ( 0 < count( $terms ) ) {
			ob_start();
		
			$found = false;
			echo $args['before_widget'];
			
			if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			
			// Force found when option is selected - do not force found on taxonomy attributes
			if ( ! is_tax() && is_array( $_chosen_attributes2 ) && array_key_exists( $taxonomy, $_chosen_attributes2 ) ) {
				$found = true;
			}
			
			// List display
			echo '<ul class="swatches-options clearfix">';
			
			foreach ( $terms as $term ) {
				$type = get_woocommerce_term_meta($term->term_id, $term->taxonomy . '_swatches_id_type',true);
				if(!in_array($type, $swatch_type_options))
					continue;
				// Get count based on current view - uses transients
				$transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_taxonomy_id ) );
			
				if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {
			
					$_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );
			
					set_transient( $transient_name, $_products_in_term );
				}
			
				$option_is_set = ( isset( $_chosen_attributes2[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes2[ $taxonomy ]['terms'] ) );
			
				// skip the term for the current archive
				if ( $current_term == $term->term_id ) {
					continue;
				}
			
				// If this is an AND query, only show options with count > 0
				if ( 'and' == $query_type ) {
			
					$count = $wc_query_has_filtered_product_ids ? sizeof( array_intersect( $_products_in_term, $filtered_product_ids ) ) : (isset( $filtered_product_ids[ $term->term_id ] ) ? $filtered_product_ids[ $term->term_id ] : 0);
			
					if ( 0 < $count && $current_term !== $term->term_id ) {
						$found = true;
					}
			
					if ( 0 == $count && ! $option_is_set ) {
						continue;
					}
			
					// If this is an OR query, show all options so search can be expanded
				} else {
			
					$count = $wc_query_has_filtered_product_ids ? sizeof( array_intersect( $_products_in_term, $unfiltered_product_ids ) ) : (isset( $filtered_product_ids[ $term->term_id ] ) ? $filtered_product_ids[ $term->term_id ] : 0);
			
					if ( 0 < $count ) {
						$found = true;
					}
				}
			
				$arg = 'filter_' . sanitize_title( $instance['attribute'] );
			
				$current_filter = ( isset( $_GET[ $arg ] ) ) ? explode( ',', $_GET[ $arg ] ) : array();
			
				if ( ! is_array( $current_filter ) ) {
					$current_filter = array();
				}
			
				$current_filter = array_map( 'esc_attr', $current_filter );
			
				if(apply_filters('dh_woocommerce_swatches_widget_link_id', false)){
					if ( ! in_array( $term->term_id, $current_filter ) ) {
						$current_filter[] = $term->term_id;
					}
				}else{
					if ( ! in_array( $term->slug, $current_filter ) ) {
						$current_filter[] = $term->slug;
					}
				}
			
				// Base Link decided by current page
				if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
					$link = home_url();
				} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
					$link = get_post_type_archive_link( 'product' );
				} else {
					$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
				}
			
				// All current filters
				if ( $_chosen_attributes2 ) {
					foreach ( $_chosen_attributes2 as $name => $data ) {
						if ( $name !== $taxonomy ) {
			
							// Exclude query arg for current term archive term
							while ( in_array( $current_term, $data['terms'] ) ) {
								$key = array_search( $current_term, $data );
								unset( $data['terms'][$key] );
							}
			
							// Remove pa_ and sanitize
							$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
			
							if ( ! empty( $data['terms'] ) ) {
								$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
							}
			
							if ( 'or' == $data['query_type'] ) {
								$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
							}
						}
					}
				}
			
				// Min/Max
				if ( isset( $_GET['min_price'] ) ) {
					$link = add_query_arg( 'min_price', $_GET['min_price'], $link );
				}
			
				if ( isset( $_GET['max_price'] ) ) {
					$link = add_query_arg( 'max_price', $_GET['max_price'], $link );
				}
			
				// Orderby
				if ( isset( $_GET['orderby'] ) ) {
					$link = add_query_arg( 'orderby', $_GET['orderby'], $link );
				}
				$filter_title = '';
				// Current Filter = this widget
				if ( isset( $_chosen_attributes2[ $taxonomy ] ) && is_array( $_chosen_attributes2[ $taxonomy ]['terms'] ) && (in_array( $term->slug, $_chosen_attributes2[ $taxonomy ]['terms'] ) || in_array( $term->term_id, $_chosen_attributes2[ $taxonomy ]['terms'] ) ) ) {
			
					$class = 'class="chosen"';
					$filter_title = __('Remove Filter','forward');
					// Remove this term is $current_filter has more than 1 term filtered
					if ( sizeof( $current_filter ) > 1 ) {
						if(apply_filters('dh_woocommerce_swatches_widget_link_id', false)){
							$current_filter_without_this = array_diff( $current_filter, array( $term->term_id ) );
						}else{
							$current_filter_without_this = array_diff( $current_filter, array( $term->slug ) );
						}
						$link = add_query_arg( $arg, implode( ',', $current_filter_without_this ), $link );
					}
			
				} else {
					$filter_title = $term->name.' ('.$count.')';
					$class = '';
					$link = add_query_arg( $arg, implode( ',', $current_filter ), $link );
			
				}
			
				// Search Arg
				if ( get_search_query() ) {
					$link = add_query_arg( 's', get_search_query(), $link );
				}
			
				// Post Type Arg
				if ( isset( $_GET['post_type'] ) ) {
					$link = add_query_arg( 'post_type', $_GET['post_type'], $link );
				}
			
				// Query type Arg
				if ( $query_type == 'or' && ! ( sizeof( $current_filter ) == 1 && isset( $_chosen_attributes2[ $taxonomy ]['terms'] ) && is_array( $_chosen_attributes2[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes2[ $taxonomy ]['terms'] ) ) ) {
					$link = add_query_arg( 'query_type_' . sanitize_title( $instance['attribute'] ), 'or', $link );
				}
				
				//$swatch_term = new WC_Product_Swatch_Term( $this->swatch_type_options[$lookup_name], $term->term_id, $taxonomy_lookup_name, $selected_value == $term->slug, $size );
				
				echo '<li ' . $class . '>';
				echo ( $count > 0 || $option_is_set ) ? '<a title="' . $filter_title . '" href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) . '">' : '<span>';
				if($type=='color'){
					$term_color = get_woocommerce_term_meta($term->term_id, $term->taxonomy . '_swatches_id_color',true);
					if(empty($term_color))
						$term_color = '#ffffff';
					
					echo '<i style="width:32px;height:32px;background-color:' . $term_color. ';"></i>';
				}elseif ($type == 'photo'){
					$thumbnail_id = get_woocommerce_term_meta($term->term_id, $term->taxonomy . '_swatches_id_photo',true);
					$thumbnail_src = $woocommerce->plugin_url() . '/assets/images/placeholder.png';
					if ($thumbnail_id) {
		                $imgsrc = wp_get_attachment_image_src($thumbnail_id);
		                if ($imgsrc && is_array($imgsrc)) {
		                    $thumbnail_src = current($imgsrc);
		                } else {
		                    $thumbnail_src = $woocommerce->plugin_url() . '/assets/images/placeholder.png';
		                }
		            } else {
		                $thumbnail_src = $woocommerce->plugin_url() . '/assets/images/placeholder.png';
		            }
		           	echo '<img src="' . $thumbnail_src . '" alt="' . esc_attr($term->name) . '"  width="32" height="32"/>';
				}
				echo ( $count > 0 || $option_is_set ) ? '</a>' : '</span>';
				echo '</li>';
			
			}
			
			echo '</ul>';
			
			echo $args['after_widget'];
			//var_dump($_chosen_attributes2);die;
			if ( ! $found ) {
				ob_end_clean();
			} else {
				echo ob_get_clean();
			}
		}
	}
}

class DH_Woocommerce_Product_Sorting extends DH_Widget{
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_layered_nav widget_product_sorting dh_woocommerce_product_sorting';
		$this->widget_description = __( 'Display WooCommerce Product sorting list.', 'forward' );
		$this->widget_id          = 'dh_woocommerce_product_sorting';
		$this->widget_name        = __( 'DH WooCommerce Product Sorting', 'forward' );

		parent::__construct();
	}

	public function update( $new_instance, $old_instance ) {
		$this->init_settings();

		return parent::update( $new_instance, $old_instance );
	}

	public function form( $instance ) {
		$this->init_settings();

		parent::form( $instance );
	}

	public function init_settings() {
		$this->settings = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Filter by', 'forward' ),
				'label' => __( 'Title', 'forward' )
			),
		);
	}

	public function widget( $args, $instance ) {
		global $_chosen_attributes,$wp_query,$wp;

		if ( 1 == $wp_query->found_posts || ! woocommerce_products_will_display() ) {
			return;
		}


		$this->widget_start( $args, $instance );

		if ( 1 != $wp_query->found_posts || woocommerce_products_will_display() ) {
			echo '<ul>';
			$orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
			$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
			$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
				'menu_order' => __( 'Default sorting', 'forward' ),
				'popularity' => __( 'Sort by popularity', 'forward' ),
				'rating'     => __( 'Sort by average rating', 'forward' ),
				'date'       => __( 'Sort by newness', 'forward' ),
				'price'      => __( 'Sort by price: low to high', 'forward' ),
				'price-desc' => __( 'Sort by price: high to low', 'forward' )
			) );
				
			if ( !$show_default_orderby ) {
				unset( $catalog_orderby_options['menu_order'] );
			}
				
			if(!apply_filters('dh_woocommerce_product_sorting_show_default', false)){
				unset( $catalog_orderby_options['menu_order'] );
			}
				
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
				unset( $catalog_orderby_options['rating'] );
			}
				
				
			foreach ( $catalog_orderby_options as $id => $name ) {
				if ( $orderby == $id ) {
					$link = remove_query_arg( 'orderby' );
					echo '<li class="chosen"><a href="' . esc_url( $link ) . '">' . esc_attr( $name ) . '</a></li>';
				} else {
					$link = add_query_arg( 'orderby', $id );
					echo '<li><a href="' . esc_url( $link ) . '">' . esc_attr( $name ) . '</a></li>';
				}
			}
				
			echo '</ul>';
		}

		$this->widget_end( $args );

	}
}
class DH_Woocommerce_Price_Filter extends DH_Widget{
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_layered_nav widget_price_filter dh_woocommerce_price_filter';
		$this->widget_description = __( 'Shows a price filter list in a widget which lets you narrow down the list of shown products when viewing product categories.', 'forward' );
		$this->widget_id          = 'dh_woocommerce_price_filter';
		$this->widget_name        = __( 'DH WooCommerce Price Filter', 'forward' );

		parent::__construct();
	}

	public function update( $new_instance, $old_instance ) {
		$this->init_settings();

		return parent::update( $new_instance, $old_instance );
	}

	public function form( $instance ) {
		$this->init_settings();

		parent::form( $instance );
	}

	public function init_settings() {
		$this->settings = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Filter by', 'forward' ),
				'label' => __( 'Title', 'forward' )
			),'price_range_size' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 50,
				'label' => __( 'Price range size', 'forward' )
			),
			'max_price_ranges' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 10,
				'label' => __( 'Max price ranges', 'forward' )
			),
			'hide_empty_ranges' => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Hide empty price ranges', 'forward' )
			)
		);
	}

	public function widget( $args, $instance ) {

		global $_chosen_attributes, $wpdb, $wp;
		if(empty($_chosen_attributes) && method_exists('WC_Query', 'get_layered_nav_chosen_attributes')){
			$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		}
		if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
			return;
		}

		// 		if ( sizeof( WC()->query->unfiltered_product_ids ) == 0 ) {
		// 			return; // None shown - return
		// 		}

		$range_size = absint( $instance['price_range_size'] );
		$max_ranges = ( absint( $instance['max_price_ranges'] ) - 1 );

		$min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
		$max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';

		// 		if ( get_option( 'permalink_structure' ) == '' ) {
		// 			$link = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
		// 		} else {
		// 			$link = preg_replace( '%\/page/[0-9]+%', '', home_url( $wp->request ) );
		// 		}

		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url('/');
		} elseif ( is_post_type_archive( 'product' ) || is_page( woocommerce_get_page_id('shop') ) ) {
			$link = get_post_type_archive_link( 'product' );
		} else {
			$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
		}

		if ( get_search_query() ) {
			$link = add_query_arg( 's', get_search_query(), $link );
		}

		if ( ! empty( $_GET['post_type'] ) ) {
			//$fields .= '<input type="hidden" name="post_type" value="' . esc_attr( $_GET['post_type'] ) . '" />';
			$link = add_query_arg( 'post_type', esc_attr( $_GET['post_type'] ), $link );
		}

		if ( ! empty ( $_GET['product_cat'] ) ) {
			//$fields .= '<input type="hidden" name="product_cat" value="' . esc_attr( $_GET['product_cat'] ) . '" />';
			$link = add_query_arg( 'product_cat', esc_attr( $_GET['product_cat'] ), $link );
		}

		if ( ! empty ( $_GET['filter_product_brand'] ) ) {
			//$fields .= '<input type="hidden" name="filter_product_brand" value="' . esc_attr( $_GET['filter_product_brand'] ) . '" />';
			$link = add_query_arg( 'filter_product_brand', esc_attr( $_GET['filter_product_brand'] ), $link );
		}

		if ( ! empty( $_GET['product_tag'] ) ) {
			//$fields .= '<input type="hidden" name="product_tag" value="' . esc_attr( $_GET['product_tag'] ) . '" />';
			$link = add_query_arg( 'product_tag', esc_attr( $_GET['product_tag'] ), $link );
		}

		if ( ! empty( $_GET['orderby'] ) ) {
			//$fields .= '<input type="hidden" name="orderby" value="' . esc_attr( $_GET['orderby'] ) . '" />';
			$link = add_query_arg( 'orderby', esc_attr( $_GET['orderby'] ), $link );
		}

		if ( $_chosen_attributes ) {
			foreach ( $_chosen_attributes as $attribute => $data ) {
				if ( $attribute !== 'product_brand' ) {
					$taxonomy_filter = 'filter_' . str_replace( 'pa_', '', $attribute );

					//$fields .= '<input type="hidden" name="' . esc_attr( $taxonomy_filter ) . '" value="' . esc_attr( implode( ',', $data['terms'] ) ) . '" />';
					$link = add_query_arg( esc_attr( $taxonomy_filter ), esc_attr( implode( ',', $data['terms'] ) ), $link );

					if ( 'or' == $data['query_type'] ) {
						//$fields .= '<input type="hidden" name="' . esc_attr( str_replace( 'pa_', 'query_type_', $attribute ) ) . '" value="or" />';
						$link = add_query_arg( esc_attr( str_replace( 'pa_', 'query_type_', $attribute ) ), 'or', $link );
					}
				}
			}
		}
		if(isset(WC()->query->layered_nav_product_ids)){
			if ( 0 === sizeof( WC()->query->layered_nav_product_ids ) ) {
				$min = floor( $wpdb->get_var( "
					SELECT min(meta_value + 0)
					FROM {$wpdb->posts} as posts
					LEFT JOIN {$wpdb->postmeta} as postmeta ON posts.ID = postmeta.post_id
					WHERE meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price', '_min_variation_price' ) ) ) ) . "')
					AND meta_value != ''
				" ) );
				$max = ceil( $wpdb->get_var( "
					SELECT max(meta_value + 0)
					FROM {$wpdb->posts} as posts
					LEFT JOIN {$wpdb->postmeta} as postmeta ON posts.ID = postmeta.post_id
					WHERE meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
				" ) );
			} else {
				$min = floor( $wpdb->get_var( "
					SELECT min(meta_value + 0)
					FROM {$wpdb->posts} as posts
					LEFT JOIN {$wpdb->postmeta} as postmeta ON posts.ID = postmeta.post_id
					WHERE meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price', '_min_variation_price' ) ) ) ) . "')
					AND meta_value != ''
					AND (
						posts.ID IN (" . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ")
						OR (
							posts.post_parent IN (" . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ")
							AND posts.post_parent != 0
						)
					)
				" ) );
				$max = ceil( $wpdb->get_var( "
					SELECT max(meta_value + 0)
					FROM {$wpdb->posts} as posts
					LEFT JOIN {$wpdb->postmeta} as postmeta ON posts.ID = postmeta.post_id
					WHERE meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
					AND (
						posts.ID IN (" . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ")
						OR (
							posts.post_parent IN (" . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ")
							AND posts.post_parent != 0
						)
					)
				" ) );
			}
		}else{
			$prices = $this->_get_filtered_price();
			$min    = floor( $prices->min_price );
			$max    = ceil( $prices->max_price );
		}

		if ( $min == $max ) {
			return;
		}

		$this->widget_start( $args, $instance );
		echo '<ul>';
		if(apply_filters('dh_woocommerce_price_filter_show_all', false)){
			if ( strlen( $min_price ) > 0 ) {
				echo '<li><a href="' . esc_url( $link ) . '">' . esc_html__( 'All', 'forward' ) . '</a></li>';
			} else {
				$url = remove_query_arg( array( 'min_price','max_price'), $link );
				echo '<li class="chosen"><a href="' . esc_url( $link ) . '">' . esc_html__( 'All', 'forward' ) . '</a></li>';
			}
		}
		$count = 0;
		for ( $range_min = 0; $range_min < ( $max + $range_size ); $range_min += $range_size ) {
			$range_max = $range_min + $range_size;

			if ( intval( $instance['hide_empty_ranges'] ) ) {
				if ( $range_min < $min ||  $min > $range_max || ( $max + $range_size ) < $range_max ) {
					continue;
				}
			}

			$count++;

			$min_price_output = wc_price( $range_min );

			if ( $count == $max_ranges ) {
				$price_output = $min_price_output . '+';

				if ( $range_min != $min_price ) {
					$url = add_query_arg( array( 'min_price' => $range_min, 'max_price' => $max ), $link );
					echo '<li><a href="' . esc_url( $url ) . '">' . $price_output . '</a></li>';
				} else {
					$url = remove_query_arg( array( 'min_price','max_price'), $link );
					echo '<li class="chosen"><a href="' . esc_url( $url ) . '">' . $price_output . '</a></li>';
				}

				break;
			} else {
				$price_output = $min_price_output . ' - ' . wc_price( $range_min + $range_size );

				if ( $range_min != $min_price || $range_max != $max_price ) {
					$url = add_query_arg( array( 'min_price' => $range_min, 'max_price' => $range_max ), $link );
					echo '<li><a href="' . esc_url( $url ) . '">' . $price_output . '</a></li>';
				} else {
					$url = remove_query_arg( array( 'min_price','max_price'), $link );
					echo '<li class="chosen"><a href="' . esc_url( $url ) . '">' . $price_output . '</a></li>';
				}
			}
		}
		echo '</ul>';
		$this->widget_end( $args );

	}

	protected function _get_filtered_price() {
		global $wpdb, $wp_the_query;

		$args       = $wp_the_query->query_vars;
		$tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
		$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

		if ( ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
			$tax_query[] = array(
				'taxonomy' => $args['taxonomy'],
				'terms'    => array( $args['term'] ),
				'field'    => 'slug',
			);
		}

		foreach ( $meta_query as $key => $query ) {
			if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
				unset( $meta_query[ $key ] );
			}
		}

		$meta_query = new WP_Meta_Query( $meta_query );
		$tax_query  = new WP_Tax_Query( $tax_query );

		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		$sql  = "SELECT min( CAST( price_meta.meta_value AS UNSIGNED ) ) as min_price, max( CAST( price_meta.meta_value AS UNSIGNED ) ) as max_price FROM {$wpdb->posts} ";
		$sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
		$sql .= " 	WHERE {$wpdb->posts}.post_type = 'product'
		AND {$wpdb->posts}.post_status = 'publish'
		AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
					AND price_meta.meta_value > '' ";
		$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

		return $wpdb->get_row( $sql );
	}
}


class DH_Woocommerce_Category_Filter extends DH_Widget{
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_layered_nav widget_category_filter dh_woocommerce_category_filter';
		$this->widget_description = __( 'Shows product categories in a widget which lets you narrow down the list of products when viewing product categories', 'forward' );
		$this->widget_id          = 'dh_woocommerce_category_filter';
		$this->widget_name        = __( 'DH WooCommerce Category Filter', 'forward' );
	
		parent::__construct();
	}
	
	public function update( $new_instance, $old_instance ) {
		$this->init_settings();
	
		return parent::update( $new_instance, $old_instance );
	}
	
	public function form( $instance ) {
		$this->init_settings();
		parent::form( $instance );
	}
	
	public function init_settings() {
		$this->settings = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Filter by', 'forward' ),
				'label' => __( 'Title', 'forward' )
			),
		);
	}
	
	protected function _get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
		global $wpdb;

		$tax_query  = WC_Query::get_main_tax_query();
		$meta_query = WC_Query::get_main_meta_query();

		if ( 'or' === $query_type ) {
			foreach ( $tax_query as $key => $query ) {
				if ( $taxonomy === $query['taxonomy'] ) {
					unset( $tax_query[ $key ] );
				}
			}
		}

		$meta_query      = new WP_Meta_Query( $meta_query );
		$tax_query       = new WP_Tax_Query( $tax_query );
		$meta_query_sql  = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql   = $tax_query->get_sql( $wpdb->posts, 'ID' );

		// Generate query
		$query           = array();
		$query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
		$query['from']   = "FROM {$wpdb->posts}";
		$query['join']   = "
			INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
			INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
			INNER JOIN {$wpdb->terms} AS terms USING( term_id )
			" . $tax_query_sql['join'] . $meta_query_sql['join'];
		$query['where']   = "
			WHERE {$wpdb->posts}.post_type IN ( 'product' )
			AND {$wpdb->posts}.post_status = 'publish'
			" . $tax_query_sql['where'] . $meta_query_sql['where'] . "
			AND terms.term_id IN (" . implode( ',', array_map( 'absint', $term_ids ) ) . ")
		";
		$query['group_by'] = "GROUP BY terms.term_id";
		$query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
		$query             = implode( ' ', $query );
		$results           = $wpdb->get_results( $query );

		return wp_list_pluck( $results, 'term_count', 'term_count_id' );
	}
	
	public function widget( $args, $instance ) {
		global $_chosen_attributes, $woocommerce, $_attributes_array;
		if(empty($_chosen_attributes) && method_exists('WC_Query', 'get_layered_nav_chosen_attributes')){
			$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		}
		extract( $args );
		$_attributes_array = is_array( $_attributes_array ) ? $_attributes_array : array();
		
		if ( ! is_post_type_archive( 'product' ) && ! is_tax( array_merge($_attributes_array,array('product_tag', 'product_cat'))))
			return;
		
		$current_term 	= $_attributes_array && is_tax( $_attributes_array ) ? get_queried_object()->term_id : '';
		$current_tax 	= $_attributes_array && is_tax( $_attributes_array ) ? get_queried_object()->taxonomy : '';
		
		$title 			= apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
		$taxonomy 		= 'product_cat';
		$display_type 	= isset( $instance['display_type'] ) ? $instance['display_type'] : 'list';
		
		if ( ! taxonomy_exists( $taxonomy ) )
			return;
		
		$terms = get_terms( $taxonomy, array( 'hide_empty' => '1' ) );
		$wc_query_has_filtered_product_ids = true;
		if(isset($woocommerce->query->filtered_product_ids)){
			$filtered_product_ids = $woocommerce->query->filtered_product_ids;
		}else{
			$wc_query_has_filtered_product_ids = false;
			$filtered_product_ids = $this->_get_filtered_term_product_counts(wp_list_pluck( $terms, 'term_id' ), $taxonomy,'and');
		}
		if ( count( $terms ) > 0 ) {
		
			ob_start();
		
			$found = false;
		
			$this->widget_start( $args, $instance );
		
			// Force found when option is selected - do not force found on taxonomy attributes
			if ( ! $_attributes_array || ! is_tax( $_attributes_array ) )
				if ( is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) )
					$found = true;
		
				if ( $display_type == 'dropdown' ) {
		
					// skip when viewing the taxonomy
					if ( $current_tax && $taxonomy == $current_tax ) {
		
						$found = false;
		
					} else {
		
						$taxonomy_filter = $taxonomy;
		
						$found = true;
		
						echo '<select id="dropdown_layered_nav_' . $taxonomy_filter . '">';
		
						echo '<option value="">' . __( 'Any category', 'forward' ) .'</option>';
		
						foreach ( $terms as $term ) {
		
							// If on a term page, skip that term in widget list
							if ( $term->term_id == $current_term )
								continue;
		
							// Get count based on current view - uses transients
							$transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_id ) );
		
							if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {
		
								$_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );
		
								set_transient( $transient_name, $_products_in_term );
							}
		
							$option_is_set = ( isset( $_chosen_attributes[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) );
		
							$count = $wc_query_has_filtered_product_ids ? sizeof( array_intersect( $_products_in_term, $filtered_product_ids ) ) : (isset( $filtered_product_ids[ $term->term_id ] ) ? $filtered_product_ids[ $term->term_id ] : 0);
		
							if ( $count > 0 )
								$found = true;
		
							echo '<option value="' . $term->term_id . '" '.selected( isset( $_GET[ 'filter_product_cat' ] ) ? $_GET[ 'filter_product_cat' ] : '' , $term->term_id, false ) . '>' . $term->name . '</option>';
						}
		
						echo '</select>';
		
						wc_enqueue_js("
							jQuery('#dropdown_layered_nav_$taxonomy_filter').change(function(){
							location.href = '" . esc_url_raw( preg_replace( '%\/page/[0-9]+%', '', esc_url(add_query_arg('filtering', '1', esc_url(remove_query_arg( array( 'page', 'filter_product_cat' )) ) )) ) ) . "&filter_product_cat=' + jQuery('#dropdown_layered_nav_$taxonomy_filter').val();		
							});
						");
					}
		
				} else {
		
					// List display
					echo "<ul>";
		
					foreach ( $terms as $term ) {
		
						$transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_id ) );
		
						if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {
		
							$_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );
		
							set_transient( $transient_name, $_products_in_term );
						}
		
						$option_is_set = ( isset( $_chosen_attributes[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) );
		
						// If this is an AND query, only show options with count > 0
						$count = $wc_query_has_filtered_product_ids ? sizeof( array_intersect( $_products_in_term, $filtered_product_ids ) ) : (isset( $filtered_product_ids[ $term->term_id ] ) ? $filtered_product_ids[ $term->term_id ] : 0);
		
						if ( $current_term == $term->term_id )
							continue;
		
						if ( $count > 0 && $current_term !== $term->term_id )
							$found = true;
		
						if ( $count == 0 && ! $option_is_set )
							continue;
							
						$current_filter = ( isset( $_GET[ 'filter_product_cat' ] ) ) ? explode( ',', $_GET[ 'filter_product_cat' ] ) : array();
						if ( ! is_array( $current_filter ) )
							$current_filter = array();
		
						if ( ! in_array( $term->term_id, $current_filter ) )
							$current_filter[] = $term->term_id;
		
						if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
							$link = home_url();
						} elseif ( is_post_type_archive( 'product' ) || is_page( woocommerce_get_page_id('shop') ) ) {
							$link = get_post_type_archive_link( 'product' );
						} else {
							$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
						}
						if ( $_chosen_attributes ) {
							foreach ( $_chosen_attributes as $name => $data ) {
								if ( $name !== 'product_cat' ) {
									while ( in_array( $current_term, $data['terms'] ) ) {
										$key = array_search( $current_term, $data );
										unset( $data['terms'][$key] );
									}
		
									$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
		
									if ( ! empty( $data['terms'] ) )
										$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link);
		
								}
							}
						}
		
						// Min/Max
						if ( isset( $_GET['min_price'] ) )
							$link = add_query_arg( 'min_price', $_GET['min_price'], $link);
		
						if ( isset( $_GET['max_price'] ) )
							$link = add_query_arg( 'max_price', $_GET['max_price'], $link);
		
						// Current Filter = this widget
						if ( isset( $_chosen_attributes['product_cat'] ) && is_array( $_chosen_attributes['product_cat']['terms'] ) && in_array( $term->term_id, $_chosen_attributes['product_cat']['terms'] ) ) {
		
							$class = 'class="chosen"';
		
							// Remove this term is $current_filter has more than 1 term filtered
							if ( sizeof( $current_filter ) > 1 ) {
								$current_filter_without_this = array_diff( $current_filter, array( $term->term_id ) );
								$link = add_query_arg( 'filter_product_cat', implode( ',', $current_filter_without_this ), $link );
							}
		
						} else {
							$class = '';
							$link = add_query_arg( 'filter_product_cat', implode( ',', $current_filter ), $link);
						}
		
						// Search Arg
						if ( get_search_query() )
							$link = add_query_arg( 's', get_search_query(), $link);
		
						// Post Type Arg
						if ( isset( $_GET['post_type'] ) )
							$link = add_query_arg( 'post_type', $_GET['post_type'], $link);
		
						echo '<li ' . $class . '>';
		
						echo ( $count > 0 || $option_is_set ) ? '<a href="' . esc_url( apply_filters( 'dh_woocommerce_category_layered_nav_link', $link ) ) . '">' : '<span>';
		
						echo $term->name;
		
						echo ( $count > 0 || $option_is_set ) ? '</a>' : '</span>';
		
						echo ' <small class="count">' . $count . '</small></li>';
					}
		
					echo "</ul>";
		
				}
		
				$this->widget_end( $args );
		
				if ( ! $found )
					ob_clean();
				else
					echo ob_get_clean();
		}
	}
}


add_action( 'widgets_init', 'dh_register_widget');
function dh_register_widget(){
	register_widget('DH_Post_Thumbnail_Widget');
	register_widget('DH_Social_Widget');
	register_widget( 'DH_Tweets' );
	register_widget( 'DH_Mailchimp_Widget' );
	if(defined('WOOCOMMERCE_VERSION')){
		register_widget('DH_Woocommerce_Product_Sorting');
		register_widget('DH_Woocommerce_Price_Filter');
		register_widget('DH_Woocommerce_Category_Filter');
	}
	if (defined('WOOCOMMERCE_VERSION') && defined('WC_SWATCHES_VERSION')){
		register_widget('DH_Woocommerce_Swatches_Widget');
	}
}