<?php get_header(); ?>
<div class="grow">
    <div class="grid grid-cols-2 shrink-0 gap-x-7 gap-y-14 ">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part('components/archive-cell'); ?>
            <?php endwhile; ?>
            


        <?php else : ?>
            <p>記事がありません。</p>
        <?php endif; ?>
            

    </div>
    <?php
        $prev_link = get_previous_posts_link('NEWER POSTS');
        $next_link = get_next_posts_link('OLDER POSTS');
    ?>

    <?php if ( $prev_link || $next_link ) : ?>
        <nav class="w-full mt-8 flex justify-between">
            <div>
            <?php if ( $prev_link ) : ?>
                <a href="<?php echo esc_url( get_previous_posts_page_link() ); ?>" class="inline-block px-4 py-2 border rounded hover:bg-gray-100 transition">
                    NEWER POSTS
                </a>
            <?php endif; ?>
            </div>

            <div>
            <?php if ( $next_link ) : ?>
                <a href="<?php echo esc_url( get_next_posts_page_link() ); ?>" class="inline-block px-4 py-2 border rounded hover:bg-gray-100 transition">
                    OLDER POSTS
                </a>
            <?php endif; ?>
            </div>
        </nav>
    <?php endif; ?>
</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>