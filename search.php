<?php get_header(); ?>
<div class="xl:w-[1180px] mx-auto bg-white lg:flex justify-between gap-7 px-4 lg:px-12">
    <div class="grow py-4 lg:py-12">

        <div class="flex">
            <h1 class="w-auto h-8 flex justify-center items-center text-sm font-bold mb-4 text-white bg-[#E6675C] px-2 py-1">
                <span class="pr-1">SEARCH RESULTS FOR:</span><?php echo get_search_query(); ?>
            </h1>
            <div class="h-8 grow border-y border-y-[#F4F4F4] border-r border-r-[#E6675C]"></div>
        </div>

        <?php $search_query = trim(get_search_query()); ?>

        <?php if ($search_query === '') : ?>
            <div class="flex flex-col">
                    <p class="text-gray-700">No relevant search results found. Try a different search keyword.</p>
                    <form action="<?php echo esc_url(home_url('/')); ?>" method="get" 
                        class=" mt-1 bg-white p-2 flex items-center gap-2 z-10">
                        <input name="s" type="text" placeholder="Search..." 
                            class="h-8 border border-gray-300 px-2 py-1 w-[578px]" />
                        <button type="submit" class="px-2 py-1 text-white bg-[#E6675C] hover:brightness-50 flex justify-center items-center transition-all duration-500">
                            <p>Search</p>
                        </button>
                    </form>
                </div>
        <?php else : ?>

            <?php if ( have_posts() ) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 shrink-0 gap-x-7 gap-y-14 ">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part('components/archive-cell'); ?>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <div class="flex flex-col">
                    <p class="text-gray-700">No relevant search results found. Try a different search keyword.</p>
                    <form action="<?php echo esc_url(home_url('/')); ?>" method="get" 
                        class=" mt-1 bg-white p-2 flex items-center gap-2 z-10">
                        <input name="s" type="text" placeholder="Search..." 
                            class="h-8 border border-gray-300 px-2 py-1 w-[578px]" />
                        <button type="submit" class="px-2 py-1 text-white bg-[#E6675C] hover:brightness-50 flex justify-center items-center transition-all duration-500">
                            <p>Search</p>
                        </button>
                    </form>
                </div>
            <?php endif; ?>
    
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
        <?php endif; ?>

        
    </div>
    <?php get_sidebar(); ?>





</div>
<?php get_footer(); ?>