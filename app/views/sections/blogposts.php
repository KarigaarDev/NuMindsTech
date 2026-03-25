<?php
// app/views/sections/blogposts.php


// Fetch the blog posts from the WordPress site using the WordPress REST API
$blogs = get_blog_posts();

function get_blog_posts() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 10,
    );

    $query = new WP_Query($args);

    $posts = array();
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        $title = get_the_title();
        $image_url = get_the_post_thumbnail_url();
        $posts[] = array(
            'title' => $title,
            'image_url' => $image_url,
        );
    }
    wp_reset_postdata();

    return $posts;
}

?>

<!-- Render the blog posts here -->
<div class="grid md:grid-cols-2 gap-6">
    <?php foreach ($blogs as $blog): ?>
        <div class="group space-y-4">
            <div class="aspect-[16/10] rounded-2xl overflow-hidden bg-slate-100 dark:bg-brand-secondary border border-slate-100 dark:border-white/5">
                <?php
                // Fetch the image URL from the WordPress site
                $image_url = $blog['image_url'] ?? '';
                if ($image_url) {
                    echo '<img src="' . $image_url . '" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-105">';
                } else {
                    echo '<div class="w-full h-full flex items-center justify-center text-muted">
                        <i class="fa-solid fa-image text-6xl opacity-20"></i>
                    </div>';
                }
                ?>
            </div>
            <h4 class="font-display font-bold text-sm text-heading dark:text-inverse group-hover:text-brand-primary transition-colors pr-4"><?= $blog['title'] ?></h4>
        </div>
    <?php endforeach; ?>
</div>