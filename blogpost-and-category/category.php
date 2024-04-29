<?php

/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header();
$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
$blog_args = array(
    'post_type' => 'post',
    'posts_per_page' => 10,
    'paged' => $paged,
    'cat' => get_query_var('cat')
);
$blog_query = new WP_Query($blog_args); ?>

<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <?php if (have_posts()) : ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php printf(__('Category Archives: %s', 'twentythirteen'), single_cat_title('', false)); ?></h1>

                <?php if (category_description()) : // Show an optional category description 
                ?>
                    <div class="archive-meta"><?php echo category_description(); ?></div>
                <?php endif; ?>
            </header><!-- .archive-header -->

            <?php /* The loop */ ?>
            <div class="container cosychats_blog">
                <div class="col-sm-10 col-sm-offset-1" style="margin-top: 15px;" id="blog-singles">
                    <div class="row">
                        <?php while (have_posts()) : the_post(); ?>
                            <?php //get_template_part( 'content', get_post_format() ); 
                            $blog_query->the_post();
                            $blog_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                            ?>
                            <div class="">
                                <div class="blog-single-style">
                                    <div class="col-sm-3">
                                        <a href="<?php echo get_permalink(); ?>"><img class="center-block img-circle img-responsive" src="<?php echo $blog_image[0]; ?>"></a>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="blog_title">
                                            <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
                                        </div>
                                        <!-- <div class="blog_date">
                                    <i><?php // echo 'Posted on ' . get_the_date(); 
                                        ?></i>
                                </div> -->
                                        <div class="blog_date">
                                            <i><?php echo 'Posted on ' . get_the_time('F j, Y g:i a');  ?></i>
                                        </div>
                                        <div class="blog_categories">
                                            <?php
                                            $categories = get_the_category();
                                            if ($categories) {
                                                echo '<ul>';
                                                foreach ($categories as $category) {

                                                    echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
                                                }
                                                echo '</ul>';
                                            }
                                            ?>
                                        </div>
                                        <div class="blog_content">
                                            <?php echo substr(get_the_excerpt(), 0, 250) . ' <a href="' . get_permalink() . '">Read more...</a>'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="blog_pagination text-center">
                <?php
                $big = 99999;
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $blog_query->max_num_pages
                ));
                ?>
            </div>
            <?php //twentythirteen_paging_nav(); 
            ?>

        <?php else : ?>
            <?php get_template_part('content', 'none'); ?>
        <?php endif; ?>

    </div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>