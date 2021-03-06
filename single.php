<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ACStarter
 */

get_header(); 
$img 		= get_field('story_image');
$video 		= get_field('video_single_post');
$sponsors 	= get_field('sponsors');	
$caption 	= ( $img ) ? $img['caption'] : '';
$postType = get_post_type();
$terms = ($postType=='post') ? get_the_terms(get_the_ID(),'category') : '';
$is_sponsored_post = array();
if($terms) {
	foreach($terms as $term) {
		$catname = $term->slug;
		if($catname=='sponsored-post') {
			$is_sponsored_post[] = $term;
		}
	}
}
$content_class = ($is_sponsored_post) ? 'is-sponsored-post':'normal-post';
?>
<div id="primary" class="content-area-full single-post-newlayout <?php echo $content_class ?>">
	<main id="main" class="site-main" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
		<div class="single-page">

			<div class="content-single-page">

				<div  class="content-inner-wrap">
					<?php if ($is_sponsored_post) { ?>
						<div class="sponsor-top">
							<div class="category ">
								<?php get_template_part('template-parts/primary-category'); ?>
								<?php 
								$info = get_field("spcontentInfo","option");
				        if($info) {
				            $i_title = $info['title'];
				            $i_text = $info['text'];
				            $i_display = ($info['display'] && $info['display']=='on') ?  true : false;
				        } else {
				            $i_title = '';
				            $i_text = '';
				            $i_display = '';
				        } ?>	
			  				<?php if ($i_display && $i_title && $i_text) { ?>
			            <span class="whatisThis" style="padding-left:4px"> - <a href="#" id="sponsorToolTip"><?php echo $i_title ?></a></span>
			            <div class="whatIsThisTxt"><?php echo $i_text ?></div>
			        	<?php } ?>
							</div>
							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							<div class="single-page-excerpt">
								<?php echo get_the_excerpt(); ?>
							</div>				
						</div>
					<?php } else { ?>

						<div class="category "><?php get_template_part('template-parts/primary-category'); ?></div>
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						<div class="single-page-excerpt"><?php echo get_the_excerpt(); ?></div>

					<?php } ?>
				</div>


				<?php if( $img ) { ?>
					<div class="story-image s2">
						<img src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>">
					</div>
				<?php } ?>

				<?php if( $caption ): ?>
					<div class="entry-meta">
						<div class="post-caption"><?php echo $caption; ?></div>
					</div>
				<?php endif; ?>

			</div>

			<?php get_template_part( 'template-parts/content', get_post_format() );	?>

		</div>
		<?php endwhile; ?>
		
	</main>
</div>

<?php 
get_footer();
