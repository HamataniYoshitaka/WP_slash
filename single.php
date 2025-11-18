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
        
                        <!-- 前の記事・次の記事 -->
            <div class="pt-12 grid grid-cols-1 md:grid-cols-2 bg-white">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>

                    <div class="  ">
                    <?php if (!empty($prev_post)): ?>
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="flex justify-between text-left group border border-[#F4F4F4]">
                            <?php if (has_post_thumbnail($prev_post->ID)): ?>
                                <div class="overflow-hidden w-16 h-16 shrink-0">
                                    <?php echo get_the_post_thumbnail($prev_post->ID, 'thumbnail', ['class' => ' object-cover group-hover:opacity-80 transition-all duration-300']); ?>
                                </div>
                            <?php endif; ?>
                            <div class="flex flex-col justify-center pr-2">
                                <div class="flex items-center text-gray-600 text-base">
                                    <svg class="w-3 rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M471.1 297.4C483.6 309.9 483.6 330.2 471.1 342.7L279.1 534.7C266.6 547.2 246.3 547.2 233.8 534.7C221.3 522.2 221.3 501.9 233.8 489.4L403.2 320L233.9 150.6C221.4 138.1 221.4 117.8 233.9 105.3C246.4 92.8 266.7 92.8 279.2 105.3L471.2 297.3z"/></svg>
                                    <div class=" text-sm block">Previous Post</div>
                                </div>
                                <div class="w-[calc(100vw-8rem)] md:w-72 text-gray-900 font-semibold text-base group-hover:underline truncate"><?php echo get_the_title($prev_post->ID); ?></div>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>

                <div class=" text-right ">
                    <?php if (!empty($next_post)): ?>
                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="flex justify-between text-right group border border-[#F4F4F4]">
                            <div class="flex flex-col justify-center pl-2">
                                <div class="flex items-center text-gray-600 text-base justify-end">
                                    <div class="text-sm block">Next Post</div>
                                    <svg class="w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M471.1 297.4C483.6 309.9 483.6 330.2 471.1 342.7L279.1 534.7C266.6 547.2 246.3 547.2 233.8 534.7C221.3 522.2 221.3 501.9 233.8 489.4L403.2 320L233.9 150.6C221.4 138.1 221.4 117.8 233.9 105.3C246.4 92.8 266.7 92.8 279.2 105.3L471.2 297.3z"/></svg>
                                </div>
                                <div class="w-[calc(100vw-8rem)] md:w-72 text-gray-900 font-semibold text-base group-hover:underline truncate"><?php echo get_the_title($next_post->ID); ?></div>
                            </div>
                            <?php if (has_post_thumbnail($next_post->ID)): ?>
                                <div class="overflow-hidden w-16 h-16 shrink-0">
                                    <?php echo get_the_post_thumbnail($next_post->ID, 'thumbnail', ['class' => 'object-cover group-hover:opacity-80 transition-all duration-300']); ?>
                                </div>
                            <?php endif; ?>
                            
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 関連する記事 -->
            <?php
            // 現在の投稿と同じタグを持つ記事から、共有タグ数の多い順に最大3件を表示
            $current_tags = get_the_tags();
            if ( $current_tags ) :
                $tag_ids = wp_list_pluck( $current_tags, 'term_id' );

                // まずは候補を十分に取得（orderbyは暫定、後でPHP側で重み付けソート）
                $rel_query = new WP_Query( array(
                    'post_type'           => 'post',
                    'post__not_in'        => array( get_the_ID() ),
                    'posts_per_page'      => 30,
                    'ignore_sticky_posts' => 1,
                    'tag__in'             => $tag_ids,
                    'orderby'             => 'date',
                    'order'               => 'DESC',
                    'no_found_rows'       => true,
                ) );

                $related_posts = array();

                if ( $rel_query->have_posts() ) :
                    while ( $rel_query->have_posts() ) : $rel_query->the_post();
                        $candidate_tag_ids = wp_get_post_tags( get_the_ID(), array( 'fields' => 'ids' ) );
                        $overlap           = count( array_intersect( $tag_ids, $candidate_tag_ids ) );
                        if ( $overlap > 0 ) {
                            $related_posts[] = array(
                                'ID'      => get_the_ID(),
                                'overlap' => $overlap,
                                'date'    => get_post_time( 'U' ), // タイブレーク用（新しい順）
                            );
                        }
                    endwhile;
                    wp_reset_postdata();

                    if ( ! empty( $related_posts ) ) :
                        // 重なりタグ数の多い順（同数なら新しい順）に並べ替え
                        usort( $related_posts, function ( $a, $b ) {
                            if ( $a['overlap'] === $b['overlap'] ) {
                                return $b['date'] <=> $a['date'];
                            }
                            return $b['overlap'] <=> $a['overlap'];
                        } );

                        // 最大3件に絞る
                        $related_posts = array_slice( $related_posts, 0, 3 );
                        ?>
                        <div class="pt-12">
                            <div class="flex items-center gap-4 mb-4">
                                <h2 class=" font-bold text-3xl text-neutral-500 uppercase">Related posts</h2>
                                <h6 class="text-sm text-gray-500 font-bold">- 関連する記事</h6>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <?php foreach ( $related_posts as $rel ) :
                                    $post_id   = $rel['ID'];
                                    $permalink = get_permalink( $post_id );
                                    $title     = get_the_title( $post_id );
                                ?>
                                    <a href="<?php echo esc_url( $permalink ); ?>" class="group block border border-[#F4F4F4] hover:shadow-sm transition-shadow duration-300">
                                        <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                                            <div class="overflow-hidden">
                                                <?php echo get_the_post_thumbnail( $post_id, 'medium', array( 'class' => 'w-full h-40 object-cover group-hover:opacity-90 transition-all duration-300' ) ); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="p-3">
                                            <div class="text-xs text-gray-500 mb-1"><?php echo esc_html( get_the_date( '', $post_id ) ); ?></div>
                                            <h3 class="text-sm font-semibold text-gray-900 truncate group-hover:text-[#E7685D] transition-colors duration-300"><?php echo esc_html( $title ); ?></h3>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php
                    endif; // !empty($related_posts)
                endif; // $rel_query->have_posts()
            endif; // $current_tags
            ?>
                        
            <div class="mt-10 p-6 bg-[#F4F4F4] flex flex-col md:flex-row items-center md:items-start space-x-4">
                <!-- 投稿者アイコン -->
                <?php echo get_avatar( get_the_author_meta('ID'), 80, '', '', array( 'class' => 'w-36 h-36' ) ); ?>

                <!-- 投稿者情報 -->
                <div class="text-center md:text-left">
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID') ) ); ?>"
                        class="inline-block mt-3 text-lg text-[#333333] font-bold hover:text-[#E6675C] transition-all duration-300">
                        <?php the_author(); ?>
                    </a>

                    <?php if ( get_the_author_meta('description') ) : ?>
                        <p class="text-[#747474] text-sm leading-relaxed pt-2">
                            <?php echo nl2br( esc_html( get_the_author_meta('description') ) ); ?>
                        </p>
                    <?php else : ?>
                        <p class="text-[#747474] text-sm pt-2">プロフィール情報はまだありません。</p>
                    <?php endif; ?>
                    <ul class="flex items-center justify-center gap-4 mt-4">
                        <?php if (get_the_author_meta('url')):?>
                        <li>
                            <a class="text-gray-800 hover:text-[#E6675C] transition-colors duration-300" href="<?php echo esc_url( get_the_author_meta('url') ); ?>" target="_blank" rel="noopener noreferrer">
                                <svg class="w-6 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M415.9 344L225 344C227.9 408.5 242.2 467.9 262.5 511.4C273.9 535.9 286.2 553.2 297.6 563.8C308.8 574.3 316.5 576 320.5 576C324.5 576 332.2 574.3 343.4 563.8C354.8 553.2 367.1 535.8 378.5 511.4C398.8 467.9 413.1 408.5 416 344zM224.9 296L415.8 296C413 231.5 398.7 172.1 378.4 128.6C367 104.2 354.7 86.8 343.3 76.2C332.1 65.7 324.4 64 320.4 64C316.4 64 308.7 65.7 297.5 76.2C286.1 86.8 273.8 104.2 262.4 128.6C242.1 172.1 227.8 231.5 224.9 296zM176.9 296C180.4 210.4 202.5 130.9 234.8 78.7C142.7 111.3 74.9 195.2 65.5 296L176.9 296zM65.5 344C74.9 444.8 142.7 528.7 234.8 561.3C202.5 509.1 180.4 429.6 176.9 344L65.5 344zM463.9 344C460.4 429.6 438.3 509.1 406 561.3C498.1 528.6 565.9 444.8 575.3 344L463.9 344zM575.3 296C565.9 195.2 498.1 111.3 406 78.7C438.3 130.9 460.4 210.4 463.9 296L575.3 296z"/></svg>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (get_the_author_meta('note')):?>
                        <li>
                            <a class="text-gray-800 hover:text-[#E6675C] transition-colors duration-300" href="<?php echo esc_url( get_the_author_meta('note') ); ?>" target="_blank" rel="noopener noreferrer">
                                <svg class="w-4 h-auto fill-current" width="432" height="428" viewBox="0 0 432 428" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M431.5 428H313V213C313 174.79 314.3 135.32 293 118.5C265.52 96.8 166.32 105.27 118.5 106.5V428H0V26.5C0 20.86 0 0.5 0 0.5L147.5 0.500014C147.5 0.500014 204.17 0.170014 232.5 1.40667e-05C305.1 1.40667e-05 367.46 4.39001 399 45C430.28 85.28 432 148.39 432 221C431.83 289.99 431.67 359.01 431.5 428Z"/>
                                </svg>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (get_the_author_meta('x')):?>
                        <li>
                            <a class="text-gray-800 hover:text-[#E6675C] transition-colors duration-300" href="<?php echo esc_url( get_the_author_meta('x') ); ?>" target="_blank" rel="noopener noreferrer">
                                <svg class="w-6 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M453.2 112L523.8 112L369.6 288.2L551 528L409 528L297.7 382.6L170.5 528L99.8 528L264.7 339.5L90.8 112L236.4 112L336.9 244.9L453.2 112zM428.4 485.8L467.5 485.8L215.1 152L173.1 152L428.4 485.8z"/></svg>                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (get_the_author_meta('tiktok')):?>
                        <li>
                            <a class="text-gray-800 hover:text-[#E6675C] transition-colors duration-300" href="<?php echo esc_url( get_the_author_meta('tiktok') ); ?>" target="_blank" rel="noopener noreferrer">
                                <svg class="w-6 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M544.5 273.9C500.5 274 457.5 260.3 421.7 234.7L421.7 413.4C421.7 446.5 411.6 478.8 392.7 506C373.8 533.2 347.1 554 316.1 565.6C285.1 577.2 251.3 579.1 219.2 570.9C187.1 562.7 158.3 545 136.5 520.1C114.7 495.2 101.2 464.1 97.5 431.2C93.8 398.3 100.4 365.1 116.1 336C131.8 306.9 156.1 283.3 185.7 268.3C215.3 253.3 248.6 247.8 281.4 252.3L281.4 342.2C266.4 337.5 250.3 337.6 235.4 342.6C220.5 347.6 207.5 357.2 198.4 369.9C189.3 382.6 184.4 398 184.5 413.8C184.6 429.6 189.7 444.8 199 457.5C208.3 470.2 221.4 479.6 236.4 484.4C251.4 489.2 267.5 489.2 282.4 484.3C297.3 479.4 310.4 469.9 319.6 457.2C328.8 444.5 333.8 429.1 333.8 413.4L333.8 64L421.8 64C421.7 71.4 422.4 78.9 423.7 86.2C426.8 102.5 433.1 118.1 442.4 131.9C451.7 145.7 463.7 157.5 477.6 166.5C497.5 179.6 520.8 186.6 544.6 186.6L544.6 274z"/></svg>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (get_the_author_meta('instagram')):?>
                        <li>
                            <a class="text-gray-800 hover:text-[#E6675C] transition-colors duration-300" href="<?php echo esc_url( get_the_author_meta('instagram') ); ?>" target="_blank" rel="noopener noreferrer">
                                <svg class="w-6 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M320.3 205C256.8 204.8 205.2 256.2 205 319.7C204.8 383.2 256.2 434.8 319.7 435C383.2 435.2 434.8 383.8 435 320.3C435.2 256.8 383.8 205.2 320.3 205zM319.7 245.4C360.9 245.2 394.4 278.5 394.6 319.7C394.8 360.9 361.5 394.4 320.3 394.6C279.1 394.8 245.6 361.5 245.4 320.3C245.2 279.1 278.5 245.6 319.7 245.4zM413.1 200.3C413.1 185.5 425.1 173.5 439.9 173.5C454.7 173.5 466.7 185.5 466.7 200.3C466.7 215.1 454.7 227.1 439.9 227.1C425.1 227.1 413.1 215.1 413.1 200.3zM542.8 227.5C541.1 191.6 532.9 159.8 506.6 133.6C480.4 107.4 448.6 99.2 412.7 97.4C375.7 95.3 264.8 95.3 227.8 97.4C192 99.1 160.2 107.3 133.9 133.5C107.6 159.7 99.5 191.5 97.7 227.4C95.6 264.4 95.6 375.3 97.7 412.3C99.4 448.2 107.6 480 133.9 506.2C160.2 532.4 191.9 540.6 227.8 542.4C264.8 544.5 375.7 544.5 412.7 542.4C448.6 540.7 480.4 532.5 506.6 506.2C532.8 480 541 448.2 542.8 412.3C544.9 375.3 544.9 264.5 542.8 227.5zM495 452C487.2 471.6 472.1 486.7 452.4 494.6C422.9 506.3 352.9 503.6 320.3 503.6C287.7 503.6 217.6 506.2 188.2 494.6C168.6 486.8 153.5 471.7 145.6 452C133.9 422.5 136.6 352.5 136.6 319.9C136.6 287.3 134 217.2 145.6 187.8C153.4 168.2 168.5 153.1 188.2 145.2C217.7 133.5 287.7 136.2 320.3 136.2C352.9 136.2 423 133.6 452.4 145.2C472 153 487.1 168.1 495 187.8C506.7 217.3 504 287.3 504 319.9C504 352.5 506.7 422.6 495 452z"/></svg>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (get_the_author_meta('suno')):?>
                        <li>
                            <a class="text-gray-800 hover:text-[#E6675C] transition-colors duration-300" href="<?php echo esc_url( get_the_author_meta('suno') ); ?>" target="_blank" rel="noopener noreferrer">
                                <svg class="w-4 h-auto fill-current" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.25 0C10.321 0 12 2.6865 12 6H7.5C7.5 9.3135 5.821 12 3.75 12C1.679 12 0 9.3135 0 6H4.5C4.5 2.6865 6.179 0 8.25 0Z" />
                                </svg>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (get_the_author_meta('sora')):?>
                        <li>
                            <a class="text-gray-800 hover:text-[#E6675C] transition-colors duration-300" href="<?php echo esc_url( get_the_author_meta('sora') ); ?>" target="_blank" rel="noopener noreferrer">
                                <svg class="w-5 h-auto fill-current" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.48403 5.57349C4.53813 5.57349 4.59002 5.59498 4.62828 5.63324C4.66654 5.67149 4.68803 5.72338 4.68803 5.77749C4.68803 5.83159 4.66654 5.88348 4.62828 5.92174C4.59002 5.95999 4.53813 5.98149 4.48403 5.98149C4.42993 5.98149 4.37804 5.95999 4.33978 5.92174C4.30152 5.88348 4.28003 5.83159 4.28003 5.77749C4.28003 5.72338 4.30152 5.67149 4.33978 5.63324C4.37804 5.59498 4.42993 5.57349 4.48403 5.57349Z" />
                                    <path d="M3.60497 4.37401C3.62747 4.36801 3.64847 4.37551 3.66897 4.39601C3.76647 4.49601 3.86397 4.59501 3.96247 4.69401C3.9711 4.70218 3.98156 4.70818 3.99297 4.71151L4.39797 4.81601C4.42597 4.82301 4.44297 4.83751 4.44897 4.86001C4.45547 4.88301 4.44797 4.90501 4.42747 4.92501L4.12947 5.21751C4.12532 5.22203 4.12179 5.22707 4.11897 5.23251C4.11573 5.23765 4.11321 5.2432 4.11147 5.24901C4.07647 5.38401 4.04147 5.51901 4.00747 5.65401C4.00047 5.68151 3.98547 5.69901 3.96247 5.70501C3.93997 5.71101 3.91847 5.70351 3.89847 5.68251C3.80097 5.58301 3.70347 5.48402 3.60497 5.38502C3.5961 5.3769 3.5855 5.37091 3.57397 5.36751L3.16897 5.26301C3.14097 5.25601 3.12397 5.24101 3.11747 5.21801C3.11197 5.19601 3.11947 5.17451 3.13997 5.15401C3.23997 5.05701 3.33897 4.95901 3.43797 4.86151C3.44239 4.85712 3.4461 4.85206 3.44897 4.84651C3.45199 4.84151 3.45434 4.83613 3.45597 4.83051C3.49097 4.69551 3.52597 4.56051 3.55997 4.42551C3.56697 4.39751 3.58197 4.38051 3.60497 4.37401Z"/>
                                    <path d="M7.91348 4.65501C7.94116 4.65364 7.96882 4.65791 7.99479 4.66756C8.02077 4.6772 8.04451 4.69203 8.06458 4.71113C8.08465 4.73023 8.10063 4.75321 8.11154 4.77867C8.12246 4.80414 8.12809 4.83155 8.12809 4.85926C8.12809 4.88697 8.12246 4.91438 8.11154 4.93985C8.10063 4.96531 8.08465 4.98829 8.06458 5.00739C8.04451 5.0265 8.02077 5.04132 7.99479 5.05097C7.96882 5.06061 7.94116 5.06488 7.91348 5.06351C7.85925 5.06351 7.80723 5.04197 7.76888 5.00361C7.73053 4.96526 7.70898 4.91325 7.70898 4.85901C7.70898 4.80477 7.73053 4.75276 7.76888 4.71441C7.80723 4.67606 7.85925 4.65451 7.91348 4.65451V4.65501Z" />
                                    <path d="M7.03553 3.45751C7.05853 3.45151 7.08053 3.45901 7.10053 3.47951C7.19753 3.57951 7.29453 3.67851 7.39203 3.77751C7.40081 3.78585 7.41143 3.79202 7.42303 3.79551L7.82653 3.90051C7.85453 3.90751 7.87153 3.92301 7.87803 3.94551C7.88403 3.96801 7.87653 3.98951 7.85553 4.00951L7.55753 4.30101C7.54943 4.30978 7.54329 4.32018 7.53953 4.33151L7.43453 4.73551C7.42753 4.76351 7.41253 4.78051 7.38953 4.78701C7.36703 4.79251 7.34553 4.78501 7.32553 4.76451C7.22853 4.66451 7.13103 4.56551 7.03403 4.46651C7.02963 4.46209 7.02457 4.45838 7.01903 4.45551C7.01406 4.45241 7.00867 4.45005 7.00303 4.44851L6.59903 4.34351C6.57103 4.33651 6.55403 4.32151 6.54803 4.29851C6.54203 4.27601 6.54953 4.25501 6.57003 4.23451C6.67003 4.13751 6.76903 4.04051 6.86803 3.94301C6.87246 3.93862 6.87617 3.93356 6.87903 3.92801C6.88223 3.92304 6.88475 3.91766 6.88653 3.91201L6.99153 3.50901C6.99853 3.48051 7.01303 3.46401 7.03553 3.45751Z" />
                                    <path d="M4.04294 0.228505C4.52458 0.0304967 5.04889 -0.0409368 5.56594 0.0210048C6.23244 0.0975048 6.82644 0.381005 7.34794 0.871005C7.35494 0.877695 7.3635 0.882527 7.37285 0.88506C7.38219 0.887592 7.39202 0.887745 7.40144 0.885505C8.10594 0.712505 8.78244 0.773505 9.43244 1.0685L9.46294 1.083L9.54044 1.1215C10.2189 1.473 10.7054 2.006 10.9994 2.72C11.1384 3.06 11.2084 3.414 11.2099 3.7835C11.2198 4.05827 11.1895 4.333 11.1199 4.599C11.1165 4.61248 11.1165 4.62662 11.12 4.64009C11.1235 4.65356 11.1303 4.66592 11.1399 4.676C11.533 5.07468 11.8062 5.57569 11.9284 6.122C12.1214 7.0725 11.9244 7.92901 11.3374 8.69201L11.2469 8.802C10.8582 9.2468 10.348 9.56831 9.77894 9.72701C9.76662 9.7307 9.75537 9.7373 9.74614 9.74627C9.73691 9.75523 9.72999 9.76629 9.72594 9.7785C9.59844 10.1465 9.46994 10.4605 9.23194 10.7745C8.63244 11.5655 7.75094 12.0055 6.75794 11.9995C5.96644 11.996 5.26494 11.7065 4.65294 11.1315C4.6437 11.1229 4.63234 11.117 4.62004 11.1143C4.60774 11.1115 4.59494 11.1121 4.58294 11.116C4.32394 11.1995 4.06294 11.2115 3.78044 11.2085C3.33009 11.2048 2.8865 11.0984 2.48344 10.8975C2.06138 10.6882 1.69398 10.3833 1.41044 10.007C1.30894 9.872 1.20844 9.74601 1.13444 9.59651C1.03325 9.39042 0.950589 9.17574 0.887442 8.955C0.754402 8.4532 0.751476 7.92576 0.878942 7.4225C0.882943 7.41061 0.884141 7.39794 0.882442 7.3855C0.880104 7.3733 0.873772 7.36222 0.864442 7.354C0.55618 7.04229 0.320569 6.66633 0.174442 6.253C0.0775802 5.99838 0.0213929 5.7301 0.00794239 5.458C-0.0161655 5.10028 0.0155473 4.74098 0.101942 4.393C0.326942 3.6505 0.756442 3.068 1.39094 2.646C1.53194 2.552 1.66544 2.479 1.79094 2.4265C1.93169 2.36804 2.07557 2.31747 2.22194 2.275C2.23226 2.27199 2.24166 2.26643 2.24926 2.25882C2.25686 2.25122 2.26243 2.24183 2.26544 2.2315C2.37449 1.83863 2.56229 1.47203 2.81744 1.154C3.15744 0.731505 3.56594 0.423005 4.04294 0.228505ZM4.52544 4.052C3.94844 3.642 3.16044 3.8455 2.86994 4.4895C2.71944 4.8225 2.68994 5.1735 2.78094 5.5425L2.85344 5.8355L2.98344 6.3105C3.03594 6.577 3.13844 6.8205 3.28944 7.0415L3.30444 7.063C3.38444 7.1575 3.47194 7.244 3.56644 7.322C4.25944 7.8915 5.20394 7.5115 5.39244 6.6605L5.41744 6.554L5.42344 6.514C5.45344 6.314 5.44444 6.118 5.39694 5.9265C5.31337 5.58721 5.22235 5.2498 5.12394 4.91451C5.01544 4.54551 4.81594 4.258 4.52544 4.052ZM8.07744 3.229C7.64644 2.828 6.98194 2.8135 6.55394 3.216C6.38694 3.373 6.27094 3.584 6.20544 3.8485C6.14033 4.11711 6.14033 4.39739 6.20544 4.666L6.21244 4.693L6.23994 4.783C6.30344 4.993 6.36244 5.2 6.41644 5.4035C6.47244 5.615 6.51744 5.7565 6.55144 5.8285C6.83844 6.4315 7.46144 6.8655 8.13994 6.5895C8.77044 6.3325 8.96044 5.5845 8.81744 4.9795C8.79594 4.888 8.77244 4.797 8.74744 4.7065C8.68233 4.44269 8.61097 4.18045 8.53344 3.92C8.45244 3.666 8.30044 3.436 8.07744 3.229Z"/>
                                </svg>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (get_the_author_meta('facebook')):?>
                        <li>
                            <a class="text-gray-800 hover:text-[#E6675C] transition-colors duration-300" href="<?php echo esc_url( get_the_author_meta('facebook') ); ?>" target="_blank" rel="noopener noreferrer">
                                <svg class="w-6 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M240 363.3L240 576L356 576L356 363.3L442.5 363.3L460.5 265.5L356 265.5L356 230.9C356 179.2 376.3 159.4 428.7 159.4C445 159.4 458.1 159.8 465.7 160.6L465.7 71.9C451.4 68 416.4 64 396.2 64C289.3 64 240 114.5 240 223.4L240 265.5L174 265.5L174 363.3L240 363.3z"/></svg>
                            </a>
                        </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>
        </div>
        <?php get_sidebar(); ?>
    </div><!-- .bg-white -->
<?php endwhile; endif; ?>
<?php get_footer(); ?>
