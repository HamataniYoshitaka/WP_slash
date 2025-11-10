<?php
// アイキャッチ画像を使用する
add_theme_support( 'post-thumbnails' );

// コメント機能を有効にする
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

// cf7の改行を無効化
add_filter( 'wpcf7_autop_or_not', '__return_false' );

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

    // 投稿（post）のみに限定（固定ページは除外）
    if ( 'post' !== get_post_type( $post ) ) {
        return;
    }

    $type        = 'NewsArticle';
    $image_id    = get_post_thumbnail_id( $post );
    $image_url   = get_the_post_thumbnail_url( $post, 'full' );
    $description = get_the_excerpt( $post );

    if ( empty( $description ) ) {
        $description = wp_trim_words( wp_strip_all_tags( $post->post_content ), 55, '' );
    }

    // 記事本文を取得（HTMLタグを除去）
    $article_body = wp_strip_all_tags( $post->post_content );
    // 長すぎる場合は最初の5000文字程度に制限（Googleの推奨範囲内）
    if ( mb_strlen( $article_body ) > 5000 ) {
        $article_body = mb_substr( $article_body, 0, 5000 ) . '...';
    }

    // カテゴリを取得（articleSection用）
    $categories = get_the_category( $post->ID );
    $article_section = ! empty( $categories ) ? $categories[0]->name : null;

    // タグを取得（keywords用）
    $tags = get_the_tags( $post->ID );
    $keywords = array();
    if ( $tags ) {
        foreach ( $tags as $tag ) {
            $keywords[] = $tag->name;
        }
    }
    // カテゴリ名もキーワードに追加
    if ( $categories ) {
        foreach ( $categories as $category ) {
            if ( ! in_array( $category->name, $keywords, true ) ) {
                $keywords[] = $category->name;
            }
        }
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

    // about/mentions用のデータを準備（タグやカテゴリから組織・人物名を推測）
    $about_items = array();
    $mentions_items = array();
    
    // タグとカテゴリから組織名や人物名を抽出（簡単な推測ロジック）
    if ( $tags ) {
        foreach ( $tags as $tag ) {
            $tag_name = $tag->name;
            // 人物名の可能性があるもの（例：氏、さん、などが含まれる、または短い名前）
            if ( preg_match( '/(氏|さん|くん|ちゃん|様|Mr\.|Ms\.|Dr\.)/u', $tag_name ) || 
                 ( mb_strlen( $tag_name ) <= 6 && ! preg_match( '/(株式会社|有限会社|合同会社|Inc|Corp|Japan|グループ|Group|Media|Tech|AI|技術|システム)/u', $tag_name ) ) ) {
                // 敬称を除去
                $person_name = preg_replace( '/(氏|さん|くん|ちゃん|様|Mr\.|Ms\.|Dr\.)/u', '', $tag_name );
                if ( ! empty( $person_name ) ) {
                    $mentions_items[] = array(
                        '@type' => 'Person',
                        'name'  => trim( $person_name ),
                    );
                }
            }
            // 会社名や組織名の可能性があるもの（例：株式会社、Inc、Japanなどが含まれる）
            elseif ( preg_match( '/(株式会社|有限会社|合同会社|Inc|Corp|Japan|グループ|Group|Media|Tech)/u', $tag_name ) ) {
                $about_items[] = array(
                    '@type' => 'Organization',
                    'name'  => $tag_name,
                );
            } else {
                // その他の場合はThingとして追加
                $about_items[] = array(
                    '@type' => 'Thing',
                    'name'  => $tag_name,
                );
            }
        }
    }

    // 言語設定を取得
    $locale = get_locale();
    $language = 'ja-JP'; // デフォルト
    if ( 'ja' === $locale || strpos( $locale, 'ja_' ) === 0 ) {
        $language = 'ja-JP';
    } elseif ( 'en_US' === $locale || strpos( $locale, 'en_' ) === 0 ) {
        $language = 'en-US';
    }

    // canonical URL（正規URL）を取得
    // WordPress 4.6以降の場合はwp_get_canonical_url()を使用（推奨）
    $canonical_url = get_permalink( $post );
    if ( function_exists( 'wp_get_canonical_url' ) ) {
        $wp_canonical = wp_get_canonical_url( $post );
        if ( $wp_canonical ) {
            $canonical_url = $wp_canonical;
        }
    }
    // 各種SEOプラグインのcanonical URLフィルターを適用
    // Yoast SEO
    $canonical_url = apply_filters( 'wpseo_canonical', $canonical_url );
    // Rank Math
    $canonical_url = apply_filters( 'rank_math/frontend/canonical', $canonical_url );
    // All in One SEO（フィルター経由で取得を試行）
    $canonical_url = apply_filters( 'aioseo_canonical_url', $canonical_url );

    $json = array_filter(
        array(
            '@context'         => 'https://schema.org',
            '@type'            => $type,
            'mainEntityOfPage'  => array(
                '@type' => 'WebPage',
                '@id'   => $canonical_url,
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
            'articleBody'      => ! empty( $article_body ) ? $article_body : null,
            'articleSection'   => $article_section,
            'keywords'         => ! empty( $keywords ) ? $keywords : null,
            'about'            => ! empty( $about_items ) ? $about_items : null,
            'mentions'         => ! empty( $mentions_items ) ? $mentions_items : null,
            'inLanguage'       => $language,
        ),
        function( $value ) {
            // null、空配列、空文字列を除外
            return ! is_null( $value ) && $value !== '' && $value !== array();
        }
    );

    echo "\n<!-- Structured Data Auto -->\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo "<script type='application/ld+json'>" . wp_json_encode( $json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    // パンくずリスト（BreadcrumbList）を出力
    $breadcrumb_items = array();
    $position = 1;

    // ホーム
    $breadcrumb_items[] = array(
        '@type'    => 'ListItem',
        'position' => $position++,
        'name'     => 'ホーム',
        'item'     => home_url( '/' ),
    );

    // カテゴリ（最初のカテゴリのみ）
    if ( ! empty( $categories ) && ! empty( $categories[0] ) ) {
        $category = $categories[0];
        $breadcrumb_items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => $category->name,
            'item'     => get_category_link( $category->term_id ),
        );
    }

    // 現在の記事
    $breadcrumb_items[] = array(
        '@type'    => 'ListItem',
        'position' => $position,
        'name'     => get_the_title( $post ),
        'item'     => $canonical_url,
    );

    $breadcrumb_json = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $breadcrumb_items,
    );

    echo "<script type='application/ld+json'>" . wp_json_encode( $breadcrumb_json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} );

// --- WebSite構造化データ（サイト全体） ---
add_action( 'wp_head', function () {
    if ( is_admin() || is_feed() ) {
        return;
    }

    $website_json = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'WebSite',
        'name'            => 'AI Tech Media スラッシュ',
        'url'             => home_url( '/' ),
        'potentialAction' => array(
            '@type'       => 'SearchAction',
            'target'      => home_url( '/?s={search_term_string}' ),
            'query-input' => 'required name=search_term_string',
        ),
    );

    echo "\n<!-- WebSite Structured Data -->\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo "<script type='application/ld+json'>" . wp_json_encode( $website_json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}, 5 );

// --- Organization構造化データ（サイト全体） ---
add_action( 'wp_head', function () {
    if ( is_admin() || is_feed() ) {
        return;
    }

    // ロゴ情報を取得
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

    // SNSアカウント（必要に応じて追加）
    $same_as = array();
    // Twitter/X
    $same_as[] = 'https://x.com/ai_tech_slash';
    // 他のSNSアカウントがあればここに追加

    $organization_json = array_filter(
        array(
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => 'AI Tech Media スラッシュ',
            'url'      => home_url( '/' ),
            'logo'     => $logo_schema,
            'sameAs'   => ! empty( $same_as ) ? $same_as : null,
        ),
        function( $value ) {
            return ! is_null( $value ) && $value !== '' && $value !== array();
        }
    );

    echo "\n<!-- Organization Structured Data -->\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo "<script type='application/ld+json'>" . wp_json_encode( $organization_json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}, 5 );