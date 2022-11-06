<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<?php
get_header();

function custom_echo($string, $length = 50)
{
  if(strlen($string)<=$length)
  {
    echo $string;
  }
  else
  {
    $y=substr($string,0,$length) . '...';
    echo $y;
  }
}
?>



<main class="is-layout-flow wp-block-group" style="margin-top:var(--wp--preset--spacing--50)">
	
	<div class="has-global-padding is-layout-constrained wp-block-group">
		
		<h1 style="margin-bottom:var(--wp--preset--spacing--40);" class="wp-block-post-title">My Imported Videos</h1>
	</div>
	

	<div class="has-global-padding is-layout-constrained entry-content wp-block-post-content">
	
	<div class="container text-center">
			<div class="row">


			<?php 
			
			if($posts){

				foreach($posts as $post){
					$postMeta = get_post_meta( $post->ID, 'details', true );
					$link = get_site_url().'/video/'.$post->post_name;
					?>
	
					<div class="col-md-4">
	
	
	
					<div class="card">
						<a href="<?= $link; ?>">
						<img src="<?= $postMeta['video_picture']; ?>" class="card-img-top" alt="<?= $post->post_title; ?>">
						</a>
						<div class="card-body">
							<h5 class="card-title"><?= $post->post_title; ?></h5>
							<p class="card-text"><?= custom_echo($post->post_content); ?></p>
							<a href="<?= $link; ?>" class="btn btn-primary">Watch Video</a>
						</div>
					</div>
	
	
	
					
					</div>
	
					<?php }
			} else {
				echo '<h1> No Video Found </h1>';
			} ?>
			
			</div>
	</div>
</div>

</main>



<?php get_footer(); ?>