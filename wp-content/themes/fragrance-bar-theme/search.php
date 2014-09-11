<?php
/*
  Template Name: Template Fragrancesz
 */
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">
						
						<header class="article-header">
							<h1>Fragrances</h1>
							<div class="clearfix"></div>
						</header>
						
						<?php get_sidebar(); ?>
						
						<div id="main" class="m-all t-2of3 d-5of7 cf last-col" role="main">
							
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								
								<?php
									
								$ids[] = $post->ID;
									
								?>
								
							<?php endwhile; ?>
							
							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">
								

								<section class="entry-content cf">
									          <div class="post"> 
									               <div class="entry">    
																		 
																		 <!--
																		 <?php
																		   $category = get_category(get_query_var('cat'));

																		   $child_categories= get_categories('parent=74');
																			 
																			 
																		   foreach($child_categories as $child_cat){
																		     //$posts= get_posts("cat=".$child_cat->cat_ID);
																				 
																				 $menargs = array(
																					 //'category__and' => array(70,101),
																					 'posts_per_page' => -1,
																					 'post__in' => $ids,
																				 );
																				 
																				 $posts= get_posts($menargs);
																				 
																				 																				 
																		     if ($posts) {
																					 echo '<hr/>';
																		       echo '<img class="header-img" src="' . z_taxonomy_image_url(70) . '"/>';
																					 echo "<h4 class='tag'>Men's</h4>";
																					 echo '<ol class="fragrances">';
																		       foreach($posts as $post) {
																		         setup_postdata($post);
																		         ?>
																		         <li><a href="<?php the_permalink(); ?>"><img src="<?php the_field('fragrance_bottle_image'); ?>"/><span><?php the_title(); ?></span></a></li>
																		         <?php
																		       }
																					 echo '</ol>';
																					 echo '<div class="clearfix"></div>';
																		     }
																				 
																				 wp_reset_postdata();
																				 
																				 $womenargs = array(
																					 //'category__and' => array(70,102),
																					 'posts_per_page' => -1,
																						 'post__in' => $ids,
																				 );
																				 
																				 $posts2= get_posts($womenargs);
																				 
																				 																				 
																		     if ($posts2) {
																					 if(!(has_category('mens'))){
																					 	echo '<img class="header-img" src="' . z_taxonomy_image_url(70) . '"/>';
																					 }																					 
																					 echo "<h4 class='tag'>Women's</h4>";
																					 echo '<ol class="fragrances">';
																		       foreach($posts2 as $post2) {
																		         setup_postdata($post2);
																		         ?>
																		         <li><a href="<?php the_permalink(); ?>"><img src="<?php the_field('fragrance_bottle_image'); ?>"/><span><?php the_title(); ?></span></a></li>
																		         <?php
																		       }
																					 echo '</ol>';
																					 echo '<div class="clearfix"></div>';
																		     }
																				 wp_reset_postdata();
																		   }
																			 
																			 
																		   ?>-->
																			 <?php
																			 
																				 $menargs = array(
																					 'category__in' => array(70,101),
																					 'posts_per_page' => -1,
																					 'post__in' => $ids,
																				 );
																				 
																				 // The Query
																				 $query1 = new WP_Query( $menargs );

																				 // The Loop
																				 while ( $query1->have_posts() ) {
																				 	$query1->the_post();
																					 echo '<hr/>';
																		       echo '<img class="header-img" src="' . z_taxonomy_image_url(70) . '"/>';
																					 echo "<h4 class='tag'>Men's</h4>";
																					 echo '<ol class="fragrances">';
																		       foreach($posts as $post) {
																		         setup_postdata($post);
																		         ?>
																		         <li><a href="<?php the_permalink(); ?>"><img src="<?php the_field('fragrance_bottle_image'); ?>"/><span><?php the_title(); ?></span></a></li>
																		         <?php
																		       }
																					 echo '</ol>';
																					 echo '<div class="clearfix"></div>';
																				 }

																				 /* Restore original Post Data 
																				  * NB: Because we are using new WP_Query we aren't stomping on the 
																				  * original $wp_query and it does not need to be reset with 
																				  * wp_reset_query(). We just need to set the post data back up with
																				  * wp_reset_postdata().
																				  */
																				 wp_reset_postdata();
																				 
																				 $womenargs = array(
																					 'category__in' => array(70,102),
																					 'posts_per_page' => -1,
																					 'post__in' => $ids,
																				 );

																				 /* The 2nd Query (without global var) */
																				 $query2 = new WP_Query( $args2 );

																				 // The 2nd Loop
																				 while ( $query2->have_posts() ) {
																				 	$query2->the_post();
																					 if(!(has_category('mens'))){
																					 	echo '<img class="header-img" src="' . z_taxonomy_image_url(70) . '"/>';
																					 }																					 
																					 echo "<h4 class='tag'>Women's</h4>";
																					 echo '<ol class="fragrances">';
																		       foreach($posts2 as $post2) {
																		         setup_postdata($post2);
																		         ?>
																		         <li><a href="<?php the_permalink(); ?>"><img src="<?php the_field('fragrance_bottle_image'); ?>"/><span><?php the_title(); ?></span></a></li>
																		         <?php
																		       }
																					 echo '</ol>';
																					 echo '<div class="clearfix"></div>';
																				 }

																				 // Restore original Post Data
																				 wp_reset_postdata();

																			 ?>
									              </div>
									          </div>
								</section> <!-- end article section -->
								<footer class="article-footer">

								</footer>

							</article>
<!--
							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
											<p><?php _e( 'This is the error message in the single-custom_type.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>
-->
						</div>

						

				</div>

			</div>
			<script type='text/javascript'>
				jQuery('#terms-post_tag').prepend('<h4>Gender</h4>');
			</script>
<?php get_footer(); ?>
