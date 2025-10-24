<div class="lg:w-72 shrink-0 mt-20 lg:mt-0">
    <div class="sticky top-24 self-start text-[#333333]">
        <h3 class=" font-bold text-3xl mb-4">RECENT POSTS</h3>
        <?php
            // 最新記事5件を取得して表示する例（テンプレート用）
            $query = new WP_Query( array(
            'posts_per_page' => 5,
            'post_status'    => 'publish',
            ) );

            if ( $query->have_posts() ) : ?>
            <ul class="latest-posts space-y-5">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>" class="hover:text-[#E7685D] transition-all duration-500 flex gap-2">
                            <div>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="w-16 h-16">
                                    <?php the_post_thumbnail( 'thumbnail' ); ?>
                                </div>
                            <?php else: ?>
                                <div class="w-16 h-16">
                                    <img src="https://placehold.jp/150x150.png?text=No+image" alt="" class="object-cover" />
                                </div>
                            <?php endif; ?>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 text-[#646464]">
                                    <svg class="w-3 h-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M216 64C229.3 64 240 74.7 240 88L240 128L400 128L400 88C400 74.7 410.7 64 424 64C437.3 64 448 74.7 448 88L448 128L480 128C515.3 128 544 156.7 544 192L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 192C96 156.7 124.7 128 160 128L192 128L192 88C192 74.7 202.7 64 216 64zM216 176L160 176C151.2 176 144 183.2 144 192L144 240L496 240L496 192C496 183.2 488.8 176 480 176L216 176zM144 288L144 480C144 488.8 151.2 496 160 496L480 496C488.8 496 496 488.8 496 480L496 288L144 288z"/></svg>
                                    <time class="post-date text-xs" datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date('Y年m月d日'); ?>
                                    </time>
                                </div>
                                <div class="line-clamp-2"><?php the_title(); ?></div>
                            </div>
                        </a>
                        
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php
            endif;
            wp_reset_postdata();
        ?>
        <h3 class="font-bold text-3xl mb-2 mt-12">MONTHLY ARCHIVES</h3>
        <ul class="space-y-1">
            <?php
                global $wpdb;
                // 年・月別のアーカイブを取得
                $months = $wpdb->get_results("
                    SELECT DISTINCT YEAR(post_date) AS year, MONTH(post_date) AS month
                    FROM $wpdb->posts
                    WHERE post_type = 'post' AND post_status = 'publish'
                    ORDER BY post_date DESC
                ");

            foreach ($months as $month) :
                $url = get_month_link($month->year, $month->month);
                $label = sprintf('%d年%d月', $month->year, $month->month);
            ?>
                <li>
                    <a href="<?php echo esc_url($url); ?>"
                        class="space-y-1 text-xs transition-all duration-300 hover:text-[#E7685D]">
                        <?php echo esc_html($label); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <h3 class="font-bold text-3xl mb-2 mt-12">CATEGORIES</h3>
        <ul class="">
            <?php
            $categories = get_categories();
            foreach ($categories as $category) :
            ?>
                <li>
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                        class="space-y-1 text-xs transition-all duration-300 hover:text-[#E7685D]">
                        <?php echo esc_html($category->name); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <h3 class="font-bold text-3xl mb-2 mt-12">TAGS</h3>
        <ul class="">
            <?php
            $tags = get_tags();
            foreach ($tags as $tag) :
            ?>
                <li>
                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                        class="space-y-1 text-xs transition-all duration-300 hover:text-[#E7685D]">
                        <?php echo esc_html($tag->name); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>