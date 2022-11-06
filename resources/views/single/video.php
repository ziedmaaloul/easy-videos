<?php 
get_header();
$post = $posts[0];
$postMeta = get_post_meta( $post->ID, 'details', true );

?>



<main class="is-layout-flow wp-block-group" style="margin-top:var(--wp--preset--spacing--50)">
	
	<div class="has-global-padding is-layout-constrained wp-block-group">
		
		<h1 style="margin-bottom:var(--wp--preset--spacing--40);" class="wp-block-post-title"><?php echo $post->post_title; ?></h1>
	
	

	<div class="has-global-padding is-layout-constrained entry-content wp-block-post-content"> <?php echo $post->post_content; ?></div>
	


    <div style="text-align: center">
    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $postMeta['video_id']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

    </div>

    </div>
    <div class="wp-block-template-part">
<div style="height:0" aria-hidden="true" class="wp-block-spacer"></div>



<div class="has-global-padding is-layout-constrained wp-block-group" style="margin-top:var(--wp--preset--spacing--70)">
	
	<hr class="wp-block-separator alignwide has-css-opacity is-style-wide"/>
	

	
	<div class="is-layout-flex wp-container-12 wp-block-columns alignwide has-small-font-size" style="margin-top:var(--wp--preset--spacing--30)">
		
		<div class="is-layout-flow wp-container-9 wp-block-column">
			
			<div class="is-layout-flex wp-container-7 wp-block-group">
				
				<p>
					Publié				</p>
				

				<div class="wp-block-post-date"><time datetime="2022-11-06T02:22:46+01:00">6 novembre 2022</time></div>

				

				
			</div>
			

			
			
		</div>
		

		
		
		
	</div>
	
</div>


</div>
	<section class="wp-block-template-part">
<div class="has-global-padding is-layout-constrained wp-block-group" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
	
</div>


</section>
</main>



<?php get_footer(); ?>