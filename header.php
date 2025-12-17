<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo get_template_directory_uri(); ?>/src/output.css?v=<?php echo wp_get_theme()->get('Version'); ?>" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
    <meta name="apple-mobile-web-app-title" content="TECH NOISY">
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
            <div class="absolute h-9 right-4 top-0 hidden md:flex items-center z-50">
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
        <a href="https://x.com/tech_noisy_" target="_blank" rel="noopener noreferrer" class="w-11 h-full hover:bg-[#E6675C] hidden lg:flex justify-center items-center transition-all duration-500" aria-label="X">
            <svg class="w-4 h-auto text-white" viewBox="0 0 1200 1227" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path fill="currentColor" d="m714.163 519.284 446.727-519.284h-105.86l-387.893 450.887-309.809-450.887h-357.328l468.492 681.821-468.492 544.549h105.866l409.625-476.152 327.181 476.152h357.328l-485.863-707.086zm-144.998 168.544-47.468-67.894-377.686-540.2396h162.604l304.797 435.9906 47.468 67.894 396.2 566.721h-162.604l-323.311-462.446z"/>
            </svg>
        </a>
    </div>
</div>
<div class="w-full h-32 bg-[#050a18] flex justify-center md:justify-between items-center md:px-32">
    <a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/src/image/logo-tn-l.webp" alt="" class="w-56 md:w-96"></a>
    <button id="mobile-nav-toggle" class="fixed top-0 right-0 z-50 flex md:hidden bg-[#E6675C] w-9 h-9 justify-center items-center transition-colors duration-300" aria-expanded="false" aria-controls="mobile-nav">
        <span class="sr-only">グローバルナビゲーションを開閉</span>
        <svg data-icon="open" class="w-7 h-auto text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="currentColor" d="M96 160C96 142.3 110.3 128 128 128L512 128C529.7 128 544 142.3 544 160C544 177.7 529.7 192 512 192L128 192C110.3 192 96 177.7 96 160zM96 320C96 302.3 110.3 288 128 288L512 288C529.7 288 544 302.3 544 320C544 337.7 529.7 352 512 352L128 352C110.3 352 96 337.7 96 320zM544 480C544 497.7 529.7 512 512 512L128 512C110.3 512 96 497.7 96 480C96 462.3 110.3 448 128 448L512 448C529.7 448 544 462.3 544 480z"/></svg>
        <svg data-icon="close" class="w-5 h-auto text-white hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M376.6 84.5c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 178.7 52.7 39.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 224 7.4 363.3c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 269.3 331.3 408.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 224 376.6 84.5z"/></svg>
    </button>
</div>
<nav id="mobile-nav" class="fixed inset-0 bg-[#050a18] text-[#C9564C] opacity-0 pointer-events-none md:hidden z-40 transition-opacity duration-300 ease-out" aria-hidden="true">
    <div class="w-full h-full flex flex-col items-center justify-center gap-6 px-8 text-center text-lg font-medium">
        <a href="<?php echo home_url(); ?>" class="">
            <img src="<?php echo get_template_directory_uri(); ?>/src/image/logo-tn-l.webp" alt="" class="w-56">
        </a>
        <a href="<?php echo home_url(); ?>/privacy-policy/" class="hover:text-[#E6675C] transition-colors duration-300">privacy policy</a>
        <a href="<?php echo home_url(); ?>/ethics/" class="hover:text-[#E6675C] transition-colors duration-300">ethics</a>
        <a href="<?php echo home_url(); ?>/editorial-policies/" class="hover:text-[#E6675C] transition-colors duration-300">editorial policies</a>
        <a href="<?php echo home_url(); ?>/experts/" class="hover:text-[#E6675C] transition-colors duration-300">experts</a>
        <a href="<?php echo home_url(); ?>/contact/" class="hover:text-[#E6675C] transition-colors duration-300">contact</a>
        <a href="https://x.com/tech_noisy_" target="_blank" rel="noopener noreferrer" class="hover:text-[#E6675C] transition-colors duration-300 flex items-center gap-2" aria-label="X">
            <svg class="w-5 h-auto fill-current" viewBox="0 0 1200 1227" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="m714.163 519.284 446.727-519.284h-105.86l-387.893 450.887-309.809-450.887h-357.328l468.492 681.821-468.492 544.549h105.866l409.625-476.152 327.181 476.152h357.328l-485.863-707.086zm-144.998 168.544-47.468-67.894-377.686-540.2396h162.604l304.797 435.9906 47.468 67.894 396.2 566.721h-162.604l-323.311-462.446z"/>
            </svg>
        </a>
        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" 
            class=" flex items-center gap-2 z-10">
            <input name="s" type="text" placeholder="Search..." 
                class="h-8 border border-gray-300 px-2 py-1 max-w-[578px] text-gray-900" />
            <button type="submit" class="px-2 py-1 text-white bg-[#E6675C] hover:brightness-50 flex justify-center items-center transition-all duration-500">
                <p>Search</p>
            </button>
        </form>
    </div>
</nav>
<div class="hidden lg:block bg-[#050a18] w-full border-b-2 border-[#E6675C]">
    <div class="xl:w-[1180px] mx-auto h-full border-r-2 border-[#333333] flex justify-end relative">

    <!-- 検索フォーム -->
    <form id="search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get" 
            class=" p-1">
        <div class="flex items-center gap-2">
            <input name="s" type="text" placeholder="Search..." 
                class="h-8 border border-gray-300 px-2 py-1 w-48" />
            <button type="submit" class="w-8 h-8 bg-[#E6675C] hover:brightness-50 flex justify-center items-center transition-all duration-500">
                <svg class="w-4 h-auto text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                    <path fill="currentColor" d="M480 272C480 317.9 465.1 360.3 440 394.7L566.6 521.4C579.1 533.9 579.1 554.2 566.6 566.7C554.1 579.2 533.8 579.2 521.3 566.7L394.7 440C360.3 465.1 317.9 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272zM272 416C351.5 416 416 351.5 416 272C416 192.5 351.5 128 272 128C192.5 128 128 192.5 128 272C128 351.5 192.5 416 272 416z"/>
                </svg>
            </button>
        </div>
    </form>
</div>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('mobile-nav-toggle');
    const overlay = document.getElementById('mobile-nav');
    if (!toggleButton || !overlay) {
        return;
    }

    const openIcon = toggleButton.querySelector('[data-icon="open"]');
    const closeIcon = toggleButton.querySelector('[data-icon="close"]');

    const toggleNav = (forceState) => {
        const shouldOpen = forceState !== undefined ? forceState : overlay.classList.contains('opacity-0');

        if (shouldOpen) {
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
            document.body.classList.add('overflow-hidden');
            toggleButton.setAttribute('aria-expanded', 'true');
            overlay.setAttribute('aria-hidden', 'false');
            if (openIcon) openIcon.classList.add('hidden');
            if (closeIcon) closeIcon.classList.remove('hidden');
        } else {
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden');
            toggleButton.setAttribute('aria-expanded', 'false');
            overlay.setAttribute('aria-hidden', 'true');
            if (openIcon) openIcon.classList.remove('hidden');
            if (closeIcon) closeIcon.classList.add('hidden');
        }
    };

    toggleButton.addEventListener('click', () => toggleNav());

    overlay.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => toggleNav(false));
    });
});
</script>

</div>


<div id="header" class="fixed top-0 bg-[#050a18] w-full h-11 border-b-2 border-[#E6675C] -translate-y-full transition-transform duration-700 z-50 hidden lg:flex items-center">
    <a href="<?php echo home_url(); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/src/image/logo-tn-s.webp" alt="" class="w-40 ml-32">
    </a>
</div>

<script>
    const header = document.getElementById('header');
    const showAt = 208;

    window.addEventListener('scroll', () => {
        header.classList.toggle('-translate-y-full', window.scrollY <= showAt);
    });
</script>
