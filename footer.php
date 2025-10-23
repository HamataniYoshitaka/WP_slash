<div class="w-full bg-[#282828]">
    <div class="w-[1180px] mx-auto p-12 flex gap-[428px]">
        <div>
            <h3 class="text-[#333333] font-bold text-3xl mb-2">アーカイブ</h3>
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
                        class="space-y-1 text-xs text-white transition-all duration-300 hover:text-[#E7685D]">
                        <?php echo esc_html($label); ?>
                    </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <hr class="w-[326px] border-[#333333] mt-4 mb-6">
            <h3 class="text-[#333333] font-bold text-3xl mb-2">カテゴリー</h3>
            <ul class="">
                <?php
                $categories = get_categories();
                foreach ($categories as $category) :
                ?>
                    <li>
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                        class="space-y-1 text-xs text-white transition-all duration-300 hover:text-[#E7685D]">
                        <?php echo esc_html($category->name); ?>
                    </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <hr class="w-[326px] border-[#333333] mt-4 mb-6">
        </div>
        <div class="space-y-5 flex flex-col text-[#C9564C] ">
            <a href="<?php echo home_url(); ?>/privacy-policy/" class="hover:text-[#E6675C] transition-all duration-300">privacy policy</a>
            <a href="<?php echo home_url(); ?>/ethics/" class="hover:text-[#E6675C] transition-all duration-300">ethics</a>
            <a href="<?php echo home_url(); ?>/editorial-policies/" class="hover:text-[#E6675C] transition-all duration-300">editorial policies</a>
            <a href="<?php echo home_url(); ?>/experts/" class="hover:text-[#E6675C] transition-all duration-300">experts</a>
        </div>
    </div>
</div>
<div class="w-full h-10 bg-black px-32 ">
    <p class="text-xs text-[#b7b7b7] border-r-2 border-[#333333] h-full flex items-center w-[393px]">Copyright &copy; 2025 AI TECH MEDIA スラッシュ. All rights reserved.</p>
</div>


</body>
</html>