<?php
/*
 * Template Name: Blog Template
 * 
 */
get_header();
$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
$blog_args = array(
    'post_type' => 'post',
    'posts_per_page' => 10,
    'paged' => $paged,
);
$blog_query = new WP_Query($blog_args); ?>
<div class="container cosychats_blog">
    <h1><span><strong>blog</strong></span></h1>
    <div class="search-drop service">
        <div class="row">
            <form id="category-select">
                <?php
                $args = array(
                    'show_option_none' => __('Select Category'),
                    'orderby'          => 'ID',
                    'echo'             => 0,
                );
                $select  = wp_dropdown_categories($args);
                echo $select;
                ?>
            </form>
        </div>
    </div>

    <div class="col-sm-10 col-sm-offset-1" style="margin-top: 15px;">
        <div id="posts-container"></div>
    </div>
    <div class="col-sm-10 col-sm-offset-1" style="margin-top: 15px;" id="blog-singles">
        <div class="row">
            <?php
            if ($blog_query->have_posts()) :

                while ($blog_query->have_posts()) :
                    $blog_query->the_post();
                    $blog_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail'); ?>

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
                <?php
                endwhile;
                ?>
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
    <?php
            else :
            endif;
    ?>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        jQuery('#category-select select').on('change', function() {
            var categoryID = jQuery(this).val();
            jQuery('#blog-singles').css('display', 'none');

            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',

                data: {
                    action: 'get_posts',
                    category_id: categoryID
                },
                success: function(result) {
                    jQuery('#posts-container').html(result);


                }
            });
        });
    });
</script>
<?php
get_footer();
