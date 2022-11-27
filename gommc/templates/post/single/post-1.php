<?php

$postID = get_the_ID();

$single = GoMMC_Single_Post::getInstance();
$single->set_post_data();
$single->set_image_data();
$single->set_post_views($postID);

$hide_all_meta = GoMMC_Theme_Helper::get_option('single_meta');
$use_author_info = GoMMC_Theme_Helper::get_option('single_author_info');
$use_tags = GoMMC_Theme_Helper::get_option('single_meta_tags') && has_tag();
$use_likes = GoMMC_Theme_Helper::get_option('single_likes') && function_exists('tpc_simple_likes');
$use_shares = GoMMC_Theme_Helper::get_option('single_share') && function_exists('tpc_theme_helper');
$use_views = GoMMC_Theme_Helper::get_option('single_views');

$has_media = $single->meta_info_render;

$meta_date = $meta_data = $meta_likes = [];
if (!$hide_all_meta) {
	//$meta_data['category'] = !GoMMC_Theme_Helper::get_option('single_meta_categories');
	$meta_data['author'] = !GoMMC_Theme_Helper::get_option('single_meta_author');
	$meta_data['date'] = !GoMMC_Theme_Helper::get_option('single_meta_date');
	$meta_data['comments'] = !GoMMC_Theme_Helper::get_option('single_meta_comments');	
}
$use_likes = GoMMC_Theme_Helper::get_option('single_likes') && function_exists('tpc_simple_likes');
$use_views = GoMMC_Theme_Helper::get_option('single_views');

// Render ?>
<article class="blog-post blog-post-single-item format-<?php echo esc_attr($single->get_pf()); ?>">
<div <?php post_class('single_meta'); ?>>
<div class="item_wrapper">
<div class="blog-post_content"><?php

	// Title ?>
	<h1 class="blog-post_title"><?php echo get_the_title(); ?></h1>

	<div class="post_meta-wrap"><?php

	// Date, Author, Comments
	if ( !$hide_all_meta ) $single->render_post_meta($meta_data);

	// Likes, Views
	if ( $use_views || $use_likes ) { ?>
		<div class="meta-data"><?php
			// Views
		    echo ( (bool)$use_views ? $single->get_post_views($postID) : '' );
			
			// Likes
			if ($use_likes) {
				tpc_simple_likes()->likes_button($postID, 0);
			} ?>
		</div><?php
	} ?>

	</div><?php // meta-wrap

    // Media
    $single->render_featured();

    // Content
    the_content();

    // Pagination
    wp_link_pages(GoMMC_Theme_Helper::pagination_wrapper());

	if ( $use_tags || $use_shares ) { ?>
		<div class="single_post_info"><?php

			// Tags
            if ($use_tags) {
                echo '<div class="tagcloud-wrapper"><div class="tagcloud">'; ?>
               <span class="title_tags"><?php echo esc_html__('Tags:','gommc'); ?></span>
                <?php the_tags('', ' ', '');
                echo '</div></div>';
			// Socials
			if ($use_shares) {
				tpc_theme_helper()->render_post_share();
			}
			}?>
			
		</div><?php
    }

    // Author Info
    if ($use_author_info) {
    $single->render_author_info();
    }?>

    <div class="post_info-divider"></div>
    <div class="clear"></div>
</div><!--blog-post_content-->
</div><!--item_wrapper-->
</div>
</article>
