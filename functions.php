<?php
// アイキャッチ画像を使用する
add_theme_support( 'post-thumbnails' );

// コメント機能を有効にする
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

// --- 構造化データ自動出力（AI Tech Media スラッシュ） ---
add_action( 'wp_head', function () {
    if ( is_admin() || is_search() || is_feed() || ! is_singular() ) {
        return;
    }

    global $post;

    if ( ! $post instanceof WP_Post ) {
        return;
    }

    $type        = ( 'post' === get_post_type( $post ) ) ? 'NewsArticle' : 'Article';
    $image_url   = get_the_post_thumbnail_url( $post, 'full' );
    $description = get_the_excerpt( $post );

    if ( empty( $description ) ) {
        $description = wp_trim_words( wp_strip_all_tags( $post->post_content ), 55, '' );
    }

    $json = array_filter(
        array(
            '@context'         => 'https://schema.org',
            '@type'            => $type,
            'mainEntityOfPage' => get_permalink( $post ),
            'headline'         => get_the_title( $post ),
            'image'            => $image_url ? array( $image_url ) : null,
            'datePublished'    => get_the_date( 'c', $post ),
            'dateModified'     => get_the_modified_date( 'c', $post ),
            'author'           => array(
                '@type' => 'Person',
                'name'  => get_the_author_meta( 'display_name', $post->post_author ),
                'url'   => get_author_posts_url( $post->post_author ),
            ),
            'publisher'        => array(
                '@type' => 'Organization',
                'name'  => 'AI Tech Media スラッシュ',
                'logo'  => array(
                    '@type' => 'ImageObject',
                    'url'   => 'https://slashgear.jp/wp-content/themes/WP_slash/src/image/logo.webp',
                ),
            ),
            'description'      => wp_strip_all_tags( $description ),
        )
    );

    echo "\n<!-- Structured Data Auto -->\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo "<script type='application/ld+json'>" . wp_json_encode( $json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} );
