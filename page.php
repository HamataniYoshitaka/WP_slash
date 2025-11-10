<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="relative w-full h-80 lg:h-[500px] overflow-hidden">
            <!-- 画像本体（暗くする） -->
            <?php the_post_thumbnail('full', ['class' => 'absolute inset-0 w-full h-full object-cover brightness-50']); ?>

            <!-- テキストを中央配置 -->
            <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-4 ">
                <h1 class="xl:w-[1140px] mx-auto text-3xl xl:text-4xl font-bold mb-3 leading-tight"><?php the_title(); ?></h1>
                <div class="text-xs flex flex-wrap justify-center divide-x">
                    <div class="flex items-center gap-2 px-2">
                        <svg class="w-3 h-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M216 64C229.3 64 240 74.7 240 88L240 128L400 128L400 88C400 74.7 410.7 64 424 64C437.3 64 448 74.7 448 88L448 128L480 128C515.3 128 544 156.7 544 192L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 192C96 156.7 124.7 128 160 128L192 128L192 88C192 74.7 202.7 64 216 64zM216 176L160 176C151.2 176 144 183.2 144 192L144 240L496 240L496 192C496 183.2 488.8 176 480 176L216 176zM144 288L144 480C144 488.8 151.2 496 160 496L480 496C488.8 496 496 488.8 496 480L496 288L144 288z"/></svg>
                        <?php echo get_the_date(); ?>
                    </div>
                    
                    <div class="flex items-center gap-2 px-2 ">
                        <svg class="w-3 h-auto -rotate-45" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M96 128C60.7 128 32 156.7 32 192L32 256C32 264.8 39.4 271.7 47.7 274.6C66.5 281.1 80 299 80 320C80 341 66.5 358.9 47.7 365.4C39.4 368.3 32 375.2 32 384L32 448C32 483.3 60.7 512 96 512L544 512C579.3 512 608 483.3 608 448L608 384C608 375.2 600.6 368.3 592.3 365.4C573.5 358.9 560 341 560 320C560 299 573.5 281.1 592.3 274.6C600.6 271.7 608 264.8 608 256L608 192C608 156.7 579.3 128 544 128L96 128zM448 400L448 240L192 240L192 400L448 400zM144 224C144 206.3 158.3 192 176 192L464 192C481.7 192 496 206.3 496 224L496 416C496 433.7 481.7 448 464 448L176 448C158.3 448 144 433.7 144 416L144 224z"/></svg>
                        <div class="hover:text-[#E6675C] transition-all duration-300"><?php the_category(', '); ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<div class="xl:w-[1180px] mx-auto bg-white lg:flex justify-between gap-7 px-4 lg:px-12">
    <div class="grow py-4 lg:py-12">

            <article class="">
            
                <div class="">
                    <!-- 本文 -->
                    <div class="prose prose-lg max-w-none prose-a:break-words">
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php
                    $tags = get_the_tags();
                    if ( $tags ) : ?>
                    <div class="mt-14">
                        <p class="text-base font-bold text-[#333333] space-x-1">
                        <?php
                            $tag_links = array_map(function($tag) {
                            return '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="hover:text-[#E7685D] transition-colors duration-200">'
                                    . esc_html($tag->name)
                                    . '</a>';
                            }, $tags);

                            echo implode(', ', $tag_links); // カンマ区切りで出力
                        ?>
                        </p>
                    </div>
                <?php endif; ?>

                

            </article>
                
        
            
            

            <!-- コメントセクション -->
            <div class="mt-10">
                <?php comments_template(); ?>
            </div>

        </div>
        <?php get_sidebar(); ?>
    </div><!-- .bg-white -->
<?php endwhile; endif; ?>
<div class="px-6 py-3"></div>
<?php get_footer(); ?>
