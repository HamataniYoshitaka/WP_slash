<?php get_header(); ?>
<div class="xl:w-[1180px] mx-auto bg-white lg:flex justify-between gap-7 p-4 lg:p-12">
    <div>
        <?php
            $tag = get_queried_object();
        ?>
        
        <div class="flex">
            <h1 class="w-auto h-8 flex justify-center items-center text-sm font-bold mb-4 text-white bg-[#E6675C] px-2 py-1">
                <span class="pr-1">TAG ARCHIVES:</span><?php echo esc_html( $tag->name ); ?>
            </h1>
            <div class="h-8 grow border-y border-y-[#F4F4F4] border-r border-r-[#E6675C]"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 shrink-0 gap-x-7 gap-y-14 ">
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





</div>
<?php get_footer(); ?>