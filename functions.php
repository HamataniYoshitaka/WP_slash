<?php
// アイキャッチ画像を使用する
add_theme_support( 'post-thumbnails' );

// コメント機能を有効にする
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

// --- All in One SEO の構造化データを完全に無効化 ---
add_filter( 'aioseo_schema_disable', '__return_true' );
add_filter( 'aioseo_schema_graph', '__return_empty_array' );
// 構造化データの出力を完全に停止
add_action( 'template_redirect', function() {
    remove_action( 'wp_head', array( 'AIOSEO\\Plugin\\Schema\\Schema', 'output' ), 10 );
}, 1 );

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
    $image_id    = get_post_thumbnail_id( $post );
    $image_url   = get_the_post_thumbnail_url( $post, 'full' );
    $description = get_the_excerpt( $post );

    if ( empty( $description ) ) {
        $description = wp_trim_words( wp_strip_all_tags( $post->post_content ), 55, '' );
    }

    // 画像情報を取得（Google Discover対応）
    $image_schema = null;
    if ( $image_id && $image_url ) {
        $image_meta = wp_get_attachment_image_src( $image_id, 'full' );
        $image_schema = array(
            '@type' => 'ImageObject',
            'url'   => $image_url,
        );
        if ( $image_meta && isset( $image_meta[1] ) && isset( $image_meta[2] ) ) {
            $image_schema['width']  = $image_meta[1];
            $image_schema['height'] = $image_meta[2];
        }
    }

    // ロゴ情報を取得（Google Discover対応）
    $logo_url = 'https://slashgear.jp/wp-content/themes/WP_slash/src/image/logo.webp';
    $logo_schema = array(
        '@type' => 'ImageObject',
        'url'   => $logo_url,
    );

    // ロゴの幅・高さを取得（可能な場合）
    $logo_path = get_template_directory() . '/src/image/logo.webp';
    if ( file_exists( $logo_path ) ) {
        $logo_size = @getimagesize( $logo_path );
        if ( $logo_size !== false ) {
            $logo_schema['width']  = $logo_size[0];
            $logo_schema['height'] = $logo_size[1];
        }
    }

    $json = array_filter(
        array(
            '@context'         => 'https://schema.org',
            '@type'            => $type,
            'mainEntityOfPage'  => array(
                '@type' => 'WebPage',
                '@id'   => get_permalink( $post ),
            ),
            'headline'         => get_the_title( $post ),
            'image'            => $image_schema ? array( $image_schema ) : null,
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
                'logo'  => $logo_schema,
            ),
            'description'      => wp_strip_all_tags( $description ),
        )
    );

    echo "\n<!-- Structured Data Auto -->\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo "<script type='application/ld+json'>" . wp_json_encode( $json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} );