
              <?php
                /*
                 * This is the default post format.
                 *
                 * So basically this is a regular post. if you don't want to use post formats,
                 * you can just copy ths stuff in here and replace the post format thing in
                 * single.php.
                 *
                 * The other formats are SUPER basic so you can style them as you like.
                 *
                 * Again, If you want to remove post formats, just delete the post-formats
                 * folder and replace the function below with the contents of the "format.php" file.
                */
              ?>
							<style type="text/css">

							.logo{
								text-align: center;
							}
							.fullPod {
								border: 1px solid <?php the_field('fragrance_main_color'); ?>;
								padding: 40px;
								margin-bottom: 20px;
							}
							.fullPod .left p{
								color: <?php the_field('fragrance_body_copy_color'); ?>;
							}
							li.halfPod{
								border: 1px solid <?php the_field('fragrance_main_color'); ?>;
								padding: 0;
							}
							li.halfPod a{
								text-decoration: none;
								text-align: center;
							}
							li.halfPod .podImg{
								height: 200px;
							}
							li.halfPod .podTxt p{
								text-transform: uppercase;
								text-decoration: none;
								color: <?php the_field('fragrance_cta_text_color'); ?>;
								background-color: <?php the_field('fragrance_secondary_color'); ?>;
								font-weight: bold;
								margin: 0;
								padding: 5px 0;
								font-size: 28px;
							}
							</style>
							
              <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

                <header class="article-header">

                  <h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
									
									<a class="right-subnav" href="javascript:history.back();">‹‹ BACK TO FRAGRANCES</a>
									
									<div class="clearfix"></div>
                </header> <?php // end article header ?>

                <section class="entry-content cf" style="background-color: <?php the_field('fragrance_background_color'); ?>;" itemprop="articleBody">
									
									
                  <div class="logo"><img src="<?php the_field('fragrance_logo'); ?>" /></div>
									
									<div class="m-all t-all d-all fullPod">
										<div class="left m-all t-1of2 d-1of2">
											<?php the_field('fragrance_description'); ?>
										</div>
										<div class="right m-all t-1of2 d-1of2 last-col">
											<img src="<?php the_field('fragrance_photo'); ?>" />
										</div>
										<div class="clearfix"></div>
									</div>
								
										
									<?php if( have_rows('half_pod') ): ?>
 
									    <ul>
 
									    <?php while( have_rows('half_pod') ): the_row(); ?>
									        <li class="halfPod m-all t-1of2 d-1of2">
														<a href="<?php the_sub_field('button_url'); ?>">
															<div class="podImg" style="background-size: 100%; background: url(<?php the_sub_field('button_image'); ?>) no-repeat;">
																
															</div>
															<div class="podTxt"><p><?php the_sub_field('button_text'); ?></p></div>
														</a><?php the_sub_field('video_embed_code'); ?></li>
        
									    <?php endwhile; ?>
 
									    </ul>
 
									<?php endif; ?>
									<!--
									<div class="pHalfCont">
									</div>
									-->
									
                </section> <?php // end article section ?>


              </article> <?php // end article ?>