<?php

/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
get_header();
?>
<?php
$get_queried_object = get_queried_object();
?>
<div class="container ">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <?php /* The loop */ ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php
                $blog_main_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                ?>
                <div class="">
                    <img class="center-block img-responsive" src="<?php echo $blog_main_image[0]; ?>">
                </div>
                <div class="blog_title">
                    <h1><?php echo get_the_title(); ?></h1>
                </div>
                <?php if ($get_queried_object->post_type == 'post') : ?>
                    <div class="">
                        <i><?php echo 'Posted on ' . get_the_date(); ?></i>
                    </div>
                <?php endif; ?>
                <div class="">
                    <?php echo get_the_content(); ?>
                </div>
            <?php endwhile; ?>

        </div><!-- #content -->
    </div>
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>