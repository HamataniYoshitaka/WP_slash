<article id="post-<?php the_ID(); ?>" <?php post_class('post-item group'); ?>>      
    <div class="relative">
        <!-- サムネイル -->
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>" class="">
                <?php the_post_thumbnail('large', array('class' => 'w-full h-[calc(60vw)] md:h-52 object-cover')); ?>
            </a>
        <?php else: ?>
            <a href="<?php the_permalink(); ?>">
                <img class="w-full h-[calc(60vw)] md:h-52 object-cover" src="https://placehold.jp/368x245.png?text=No+image" alt="" />
            </a>
        <?php endif; ?>

        <!-- カテゴリー -->
        <div class="absolute left-0 bottom-0 flex items-end gap-1">
            <?php
            $categories = get_the_category();
            if ( ! empty( $categories ) ) {
                foreach ( $categories as $category ) {
                    echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class=" text-white font-bold text-xs bg-[#E7685D] h-6 px-2 flex justify-center items-center hover:bg-[#c9564c] transition-all duration-500">';
                    echo esc_html( $category->name );
                    echo '</a>';
                }
            }
            ?>
        </div>
    </div>

    <!-- 日付 -->
    <div class="flex items-center gap-2 text-[#646464] py-2">
        <svg class="w-4 h-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M216 64C229.3 64 240 74.7 240 88L240 128L400 128L400 88C400 74.7 410.7 64 424 64C437.3 64 448 74.7 448 88L448 128L480 128C515.3 128 544 156.7 544 192L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 192C96 156.7 124.7 128 160 128L192 128L192 88C192 74.7 202.7 64 216 64zM216 176L160 176C151.2 176 144 183.2 144 192L144 240L496 240L496 192C496 183.2 488.8 176 480 176L216 176zM144 288L144 480C144 488.8 151.2 496 160 496L480 496C488.8 496 496 488.8 496 480L496 288L144 288z"/></svg>
        <time class="post-date text-xs" datetime="<?php echo get_the_date('c'); ?>">
            <?php echo get_the_date('Y年m月d日'); ?>
        </time>
    </div>

    <!-- タイトル -->
    <h2 class="post-title text-3xl font-bold">
        <a href="<?php the_permalink(); ?>" class="group-hover:text-[#E7685D] transition-all duration-500"><?php the_title(); ?></a>
    </h2>

</article>