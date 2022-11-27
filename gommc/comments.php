<?php
defined('ABSPATH') || exit;

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package gommc
 * @author MMC 
 * @since 1.0.0
 */

/*
 * If the current post is protected by a password and the visitor
 * has not yet entered the password then return without loading the comments.
 */
if (post_password_required()) return;

if (have_comments() || comments_open()) {
    echo '<div id="comments">';
}

if (have_comments()) :
    ?>
    <h3 class="comments-title">
        <?php
        $comments_number = get_comments_number();
        if ( '1' === $comments_number ) {
            /* translators: %s: post title */
            printf( _x( 'Comment<span class="number-comments">(01)</span>', 'comments title', 'gommc' ));
        } else {
            $comments_number = (int) $comments_number < 10 ? '0'.$comments_number : $comments_number;
            printf(
                _nx(
                    'Comments<span class="number-comments">(%1$s)</span>',
                    'Comments<span class="number-comments">(%1$s)</span>',
                    $comments_number,
                    'comments title',
                    'gommc'
                ),
                $comments_number
            );
        }
        ?>
    </h3>

    <ol class="commentlist">
        <?php
            wp_list_comments(array(
                'walker' => new GoMMC_Walker_Comment(),
                'avatar_size' => 70,
                'short_ping' => true
            ) );
        ?>
    </ol>
    <?php
    if (get_comment_pages_count() > 1) {
        ?>
        <div><?php paginate_comments_links(); ?></div>
        <?php
    }
endif;
    $args = array();
    $args['fields'] = array(
        'author' => '<div class="comment-form-author tpc_col-6"><label for="author" class="label-name"></label><input type="text" placeholder="' . esc_attr__('Your Name', 'gommc') . '" title="' . esc_attr__('Your Name', 'gommc') . '" id="author" name="author" class="form_field"></div>',
        'email' => '<div class="comment-form-email tpc_col-6"><label for="email" class="label-email"></label><input type="text" placeholder="' . esc_attr__('Your Email', 'gommc') . '" title="' . esc_attr__('Your Email', 'gommc') . '" id="email" name="email" class="form_field"></div>',
        'url' => '<div class="comment-form-url tpc_col-12"><label for="url" class="label-url"></label><input type="text" placeholder="' . esc_attr__('Website', 'gommc') . '" title="' . esc_attr__('Website', 'gommc') . '" id="url" name="url" class="form_field"></div>'
    );
    $args['comment_field'] = '<div class="comment-form-comment tpc_col-12"><label for="comment" class="label-message" ></label><textarea name="comment" cols="45" rows="5" placeholder="' . esc_attr__('Your Comment', 'gommc') . '" id="comment" class="form_field"></textarea></div>';

    ob_start();
    comment_form($args);
    $comment_form = ob_get_clean();
    echo trim($comment_form);


if (have_comments() || comments_open()) {
    echo '</div>';
}
