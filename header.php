<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo get_template_directory_uri(); ?>/src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&family=Noto+Sans+JP:wght@500;700&display=swap" rel="stylesheet">
    <title>スラッシュ</title>
    <?php wp_head(); ?>
</head>
<body class="bg-[#F6F6F6]">

    <!-- ▼ Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- ▼ Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- ▼ 初期化スクリプト -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.mySwiper', {
        loop: true,
        slidesPerView: 1,
        allowTouchMove: false, // スマホでスワイプしないように
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        speed: 1500,
        navigation: {
            nextEl: '.slide-next',
            prevEl: '.slide-prev',
        },
        effect: 'slide',
    });
    });
    </script>

<div class="bg-black w-full h-9">
    <div class="flex h-full">
        <div class="relative lg:ml-32 border-x-2 border-[#333333] w-full lg:w-[690px] h-full flex justify-center items-center">
            <div class="news-slider bg-black text-white w-full overflow-hidden relative">
                <div class="swiper mySwiper">
                    <!-- スライド群 -->
                    <div class="swiper-wrapper">
                    <?php
                    $latest_posts = new WP_Query(array(
                        'posts_per_page' => 5,
                        'post_status'    => 'publish',
                    ));
                    if ($latest_posts->have_posts()) :
                        while ($latest_posts->have_posts()) : $latest_posts->the_post();
                        $categories = get_the_category();
                        $cat_name = $categories ? esc_html($categories[0]->name) : '未分類';
                    ?>
                        <div class="swiper-slide">
                            <div class="flex items-center gap-3 ml-4 mr-12 truncate">
                                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1"><?php echo $cat_name; ?></span>
                                <a href="<?php the_permalink(); ?>" class="text-xs font-semibold hover:underline whitespace-nowrap overflow-hidden text-ellipsis">
                                    <?php the_title(); ?>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                    </div>
                </div>
            </div>
            <div class="absolute h-9 right-4 top-0 flex items-center z-50">
                    <!-- 前へ（左矢印） -->
                    <button class="slide-prev p-2 h-9" aria-label="前へ">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M15 6L9 12L15 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <!-- 次へ（右矢印） -->
                    <button class="slide-next p-2 h-9" aria-label="次へ">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
        </div>
        <div class="hidden w-48 h-full border-r-2 border-[#333333] text-white lg:flex justify-center items-center">
            <?php echo date('Y/m/d'); ?>
        </div>
        <a href="https://x.com/ai_tech_slash" target="_blank" rel="noopener noreferrer" class="w-11 h-full hover:bg-[#E6675C] hidden lg:flex justify-center items-center transition-all duration-500" aria-label="X">
            <svg class="w-4 h-auto text-white" viewBox="0 0 1200 1227" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path fill="currentColor" d="m714.163 519.284 446.727-519.284h-105.86l-387.893 450.887-309.809-450.887h-357.328l468.492 681.821-468.492 544.549h105.866l409.625-476.152 327.181 476.152h357.328l-485.863-707.086zm-144.998 168.544-47.468-67.894-377.686-540.2396h162.604l304.797 435.9906 47.468 67.894 396.2 566.721h-162.604l-323.311-462.446z"/>
            </svg>
        </a>
    </div>
</div>
<div class="w-full h-32 bg-transparent flex justify-between items-center px-32">
    <a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/src/image/logo.webp" alt="" class="w-56"></a>
    <?php 
    // <button class="md:hidden flex bg-[#E6675C] w-10 h-10 justify-center items-center">
    //     <svg class="w-8 h-auto text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M96 160C96 142.3 110.3 128 128 128L512 128C529.7 128 544 142.3 544 160C544 177.7 529.7 192 512 192L128 192C110.3 192 96 177.7 96 160zM96 320C96 302.3 110.3 288 128 288L512 288C529.7 288 544 302.3 544 320C544 337.7 529.7 352 512 352L128 352C110.3 352 96 337.7 96 320zM544 480C544 497.7 529.7 512 512 512L128 512C110.3 512 96 497.7 96 480C96 462.3 110.3 448 128 448L512 448C529.7 448 544 462.3 544 480z"/></svg>
    // </button>
    ?>
</div>
<div class="hidden lg:block bg-[#282828] w-full h-11 border-b-2 border-[#E6675C]">
    <div class="xl:w-[1180px] mx-auto h-full border-r-2 border-[#333333] flex justify-end relative">
    <!-- 🔍 検索ボタン -->
    <button id="search-toggle" class="w-11 h-full hover:bg-[#E6675C] flex justify-center items-center transition-all duration-500">
        <svg class="w-4 h-auto text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
            <path fill="currentColor" d="M480 272C480 317.9 465.1 360.3 440 394.7L566.6 521.4C579.1 533.9 579.1 554.2 566.6 566.7C554.1 579.2 533.8 579.2 521.3 566.7L394.7 440C360.3 465.1 317.9 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272zM272 416C351.5 416 416 351.5 416 272C416 192.5 351.5 128 272 128C192.5 128 128 192.5 128 272C128 351.5 192.5 416 272 416z"/>
        </svg>
    </button>

    <!-- 🔎 検索フォーム（最初は非表示） -->
    <form id="search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get" 
            class="!hidden absolute right-0 top-full mt-1 bg-white shadow-lg p-2 flex items-center z-50">
        <input name="s" type="text" placeholder="Search..." 
            class="h-8 border border-gray-300 px-2 py-1 w-48" />
        <button type="submit" class="w-8 h-8 bg-[#E6675C] hover:brightness-50 flex justify-center items-center transition-all duration-500">
            <svg class="w-4 h-auto text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                <path fill="currentColor" d="M480 272C480 317.9 465.1 360.3 440 394.7L566.6 521.4C579.1 533.9 579.1 554.2 566.6 566.7C554.1 579.2 533.8 579.2 521.3 566.7L394.7 440C360.3 465.1 317.9 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272zM272 416C351.5 416 416 351.5 416 272C416 192.5 351.5 128 272 128C192.5 128 128 192.5 128 272C128 351.5 192.5 416 272 416z"/>
            </svg>
        </button>
    </form>
</div>

<script>
document.getElementById('search-toggle').addEventListener('click', function() {
    const form = document.getElementById('search-form');
    form.classList.toggle('!hidden');
});
</script>

</div>


<div id="header" class="fixed top-0 bg-[#282828] w-full h-11 border-b-2 border-[#E6675C] -translate-y-full transition-transform duration-700 z-50 hidden lg:flex items-center">
    <a href="<?php echo home_url(); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/src/image/logo-white.webp" alt="" class="w-24 ml-32">
    </a>
</div>

<script>
    const header = document.getElementById('header');
    const showAt = 208;

    window.addEventListener('scroll', () => {
        header.classList.toggle('-translate-y-full', window.scrollY <= showAt);
    });
</script>
