<?php
	$nameTextColor = $attributes['nameTextColor'];
	$nameFontSize = $attributes['nameFontSize'];
?>
<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<ul class='wp-block-blocks-team__container'>
		<?php
			$posts = get_posts([
				'posts_per_page'	=> -1,
				'post_type'		=> 'team',
				'meta_key'		=> 'team_role'
			]);

			if( $posts ) {
				foreach( $posts as $post ) {
					$role = esc_html( get_field('team_role', $post->ID, true) );
					$photo = esc_url( get_the_post_thumbnail_url($post->ID, [255, 325]) );
					$bio = wpautop( $post->post_content );
					$socials =get_field( 'team_social_links', $post->ID, true );
					?>

				<li class='wp-block-blocks-team__card'>
					<?php if( ! empty( $photo ) ) { ?>
						<div class="wp-block-blocks-team__image">
							<img src="<?php echo $photo; ?>" alt="<?php echo $post->post_title; ?>" />
							<div class='wp-block-blocks-team__image__social-links'>
								<ul>
									<?php  foreach ($socials as $key => $value) {

										if(  $value !== '' )  {
											$var = explode( "_", $key);
											$icon = $var[1];
										?>
										<li>
											<a href="<?php echo $value; ?>"><i class="fa-brands fa-<?php echo $icon; ?>"></i></a>
										</li>
										<?php }
									} ?>
								</ul>
							</div>
						</div>
					<?php } ?>
						<div className='wp-block-blocks-team__info'>
							<?php if( ! empty( $post->post_title ) ) { ?>
								<h3
									style="color:<?php echo $nameTextColor; ?>; font-size:<?php echo $nameFontSize; ?>;" class='wp-block-blocks-team__name'>
									<?php echo esc_html( $post->post_title ); ?>
							</h3>
							<?php } ?>
							<?php if( $attributes['showRole'] && ! empty( $role ) ) { ?>
								<h4 class='wp-block-blocks-team__role'>
									<?php echo $role; ?>
							</h4>
							<?php } ?>
							<?php if( $attributes['showBio'] && ! empty( $bio ) ) { ?>
								<p class='wp-block-blocks-team__bio'>
									<?php echo $bio; ?>
								</p>
					<?php } ?>
						</div>
				</li>
			<?php }
		 }
		?>
	</ul>
</div>
</div>







