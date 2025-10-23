<?php get_header(); ?>
<div class="w-[1180px] mx-auto bg-white flex justify-between gap-7 p-12">

    <div class="grow">
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
                    <form id="search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get" 
                        class=" mt-1 bg-white p-2 flex items-center gap-2 z-50">
                        <input name="s" type="text" placeholder="Search..." 
                            class="h-8 border border-gray-300 px-2 py-1 w-[578px]" />
                        <button type="submit" class="px-2 py-1 text-white bg-[#E6675C] hover:brightness-50 flex justify-center items-center transition-all duration-500">
                            <p>Search</p>
                        </button>
                    </form>
                </div>
        <?php else : ?>


            <?php if ( have_posts() ) : ?>
                <div class="grid grid-cols-2 shrink-0 gap-x-7 gap-y-14">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="w-[368px]">
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                            
                                <div class="relative">
                                    <!-- サムネイル -->
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <a href="<?php the_permalink(); ?>" class="">
                                            <?php the_post_thumbnail('full'); ?>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <img src="https://placehold.jp/368x245.png?text=No+image" alt="" />
                                        </a>
                                    <?php endif; ?>
            
                                    <!-- カテゴリー -->
                                    <div class="absolute left-0 bottom-0 flex items-end gap-1">
                                        <div class="post-category  text-white font-bold text-xs bg-[#E7685D] h-6 px-2 flex justify-center items-center hover:bg-[#c9564c] transition-all duration-500">
                                            <?php the_category(', '); ?>
                                        </div>
            
                                        <a href="<?php the_permalink(); ?>" class="text-white bg-[#E7685D] h-6 px-2 flex justify-center items-center hover:bg-[#c9564c] transition-all duration-500">
                                            <svg class="w-3 h-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>share</title><path fill="currentColor" d="M21,12L14,5V9C7,10 4,15 3,20C5.5,16.5 9,14.9 14,14.9V19L21,12Z" /></svg>
                                        </a>
                                    </div>
                                </div>
                
                                <!-- 日付 -->
                                <div class="flex items-center gap-2 text-[#646464] py-2">
                                    <svg class="w-3 h-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M216 64C229.3 64 240 74.7 240 88L240 128L400 128L400 88C400 74.7 410.7 64 424 64C437.3 64 448 74.7 448 88L448 128L480 128C515.3 128 544 156.7 544 192L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 192C96 156.7 124.7 128 160 128L192 128L192 88C192 74.7 202.7 64 216 64zM216 176L160 176C151.2 176 144 183.2 144 192L144 240L496 240L496 192C496 183.2 488.8 176 480 176L216 176zM144 288L144 480C144 488.8 151.2 496 160 496L480 496C488.8 496 496 488.8 496 480L496 288L144 288z"/></svg>
                                    <time class="post-date text-xs" datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date('Y年m月d日'); ?>
                                    </time>
                                </div>
                
                                <!-- タイトル -->
                                <h2 class="post-title text-3xl">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                
                            </article>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <div class="flex flex-col">
                    <p class="text-gray-700">No relevant search results found. Try a different search keyword.</p>
                    <form id="search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get" 
                        class=" mt-1 bg-white p-2 flex items-center gap-2 z-50">
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