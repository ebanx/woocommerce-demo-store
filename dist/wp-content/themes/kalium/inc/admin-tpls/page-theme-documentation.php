<?php
/**
 *	Theme Help Page
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

add_thickbox();
?>
<div class="wrap about-wrap">
	<?php include 'about-header.php'; ?>
	
	<?php if ( Kalium_Theme_License::isValid() ) : ?>
		<h2 class="text-left">Documentation and Support</h2>
		<p>You can view theme documentation or submit a ticket at our support system:</p>
	<?php else: ?>
		<h2 class="text-left">Documentation</h2>
		<p>You can view theme documentation by clicking the button below:</p>
	<?php endif; ?>


	<p>
		<a href="//documentation.laborator.co/item/kalium/?theme-inline=true" class="button button-primary" id="lab_read_docs">Read Documentation</a>
		
		<?php if ( Kalium_Theme_License::license() ) : ?>
		<a href="https://laborator.ticksy.com/" target="_blank" class="button">
			Theme Support
		</a>
		<?php endif; ?>
	</p>


	<script type="text/javascript">
	jQuery( document ).ready( function( $ ) {
		$( '#lab_read_docs' ).click( function( ev ) {
			ev.preventDefault();
			var href = $( this ).attr( 'href' );
			tb_show( 'Theme Documentation' , href + '?TB_iframe=1&width=1280&height=650' );
		} );
	} );
	</script>

	<style>
		.lab-faq-links {
		}

		.lab-faq-links li {
			margin-top: 18px;
			background: #FFF;
			border: 1px solid #E0E0E0;
			padding: 0;
		}
		
		.lab-faq-links li > strong {
			display: block;
			padding: 10px 15px;
			background: rgba(238,238,238,0.6);
		}
	
		.lab-faq-links li:target {
			-webkit-animation: blink 1s 3;
			-moz-animation: blink 1s 3;
			-o-animation: blink 1s 3;
			animation: blink 1s 3;
		}

		.lab-faq-links li pre {
			font-size: 13px;
			max-width: 100%;
			word-break: break-word;
			padding: 10px 15px;
			padding-top: 5px;
			white-space: pre-line;
		}

		.lab-faq-links .warn {
			display: block;
			font-family: Arial, Helvetica, sans-serif;
			border: 1px solid #999;
			padding: 10px;
			font-size: 12px;
			text-transform: uppercase;
		}		
		
		@-webkit-keyframes blink {
		    0% {
				box-shadow: 0px 0px 0px 10px rgba(255, 255, 0, 0);
		    }
		
		    50% {
				box-shadow: 0px 0px 0px 10px rgba(255, 255, 0, 1);
		    }
		    
		    100% {
				box-shadow: 0px 0px 0px 10px rgba(255, 255, 0, 0);
		    }
		}
		
		@keyframes blink {
		    0% {
				box-shadow: 0px 0px 0px 10px rgba(255, 255, 0, 0);
		    }
		
		    50% {
				box-shadow: 0px 0px 0px 10px rgba(255, 255, 0, 1);
		    }
		    
		    100% {
				box-shadow: 0px 0px 0px 10px rgba(255, 255, 0, 0);
		    }
		}
	</style>

	<br />
	<h3>Frequently Asked Questions</h3>
	<hr />

	<ul class="lab-faq-links">
		<li id="update-visual-composer">

			<strong>How to update premium plugins that are bundled with the theme?</strong>

			<pre>Each time new theme update is available, we will include latest versions of premium plugins that are bundled with the theme.

To have latest version of premium plugins you need also to have the latest version of Kalium theme as well.

When new update is available for any of theme bundled plugins you will receive a notification that tells you need to update a specific plugin/s. 
Click this link <a href="http://drops.laborator.co/12DUv" target="_blank">http://drops.laborator.co/12DUv</a> to see how this notification popup looks like.

Then click <strong>Update</strong> for each plugin separately or check them all and choose Update from the dropdown and click apply. 
This screenshot <a href="http://drops.laborator.co/9Qq4" target="_blank">http://drops.laborator.co/9Qq4</a> will describe how to update plugins.

It may happen sometimes that after you update any plugin, <strong>Activate</strong> link to appear below that plugin, just ignore it because it is already activated.

<strong class="warn">Important Note: You don't have to buy these plugins, they are bundled with the theme</strong></pre>
		</li>

		<li id="regenerate-thumbnails">

			<strong>Regenerate Thumbnails</strong>

			<pre>If your thumbnails are not correctly cropped, you can regenerate them by following these steps:

1. Go to Plugins > Add New

2. Search for "<strong>Regenerate Thumbnails</strong>"

3. Install and activate that plugin.

4. Go to Tools > Regen. Thumbnails

5. Click "Regenerate All Thumbnails" button and let the process to finish till it reaches 100 percent.</pre>
		</li>

		<li id="flush-rewrite-rules">

			<strong>Flush Rewrite Rules</strong>

			<pre>If it happens to get <strong>404 Page not found</strong> error on some pages/posts that already exist, then you need to flush rewrite rules in order to fix this issue (this works in most cases).

To do apply <strong>rewrite rules flush</strong> follow these steps:

1. Go to <a href="<?php echo admin_url( 'options-permalink.php' ); ?>" target="_blank">Settings &gt; Permalinks</a>

2. Click "Save Changes" button.

That's all, check those pages to see if its fixed.</pre>
		</li>
	</ul>
</div>