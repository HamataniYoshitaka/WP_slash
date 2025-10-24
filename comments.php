<?php
/**
 * Comments template with Tailwind CSS styling
 * Theme: WP_slash
 */

if ( post_password_required() ) {
    return;
}

if ( ! function_exists( 'wp_slash_tailwind_comment' ) ) :
    /**
     * Custom callback for rendering a single comment with Tailwind classes
     */
    function wp_slash_tailwind_comment( $comment, $args, $depth ) {
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> <?php comment_class( 'p-4 rounded-md border border-gray-200 bg-white' ); ?> id="comment-<?php comment_ID(); ?>">
            <div class="flex items-start gap-3">
                <div class="shrink-0">
                    <?php echo get_avatar( $comment, 48, '', '', array( 'class' => 'w-12 h-12 rounded-full' ) ); ?>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-x-2 text-sm text-gray-600">
                        <span class="font-semibold text-gray-900"><?php echo get_comment_author_link(); ?></span>
                        <span>・</span>
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="hover:underline">
                            <?php printf( '%1$s %2$s', get_comment_date(), get_comment_time() ); ?>
                        </a>
                        <?php edit_comment_link( '(編集)', '<span class="ml-2 text-xs">', '</span>' ); ?>
                    </div>

                    <?php if ( '0' === $comment->comment_approved ) : ?>
                        <p class="mt-2 text-xs text-orange-600">あなたのコメントは現在モデレーション待ちです。</p>
                    <?php endif; ?>

                    <div class="prose prose-sm mt-2 max-w-none text-gray-800 leading-relaxed">
                        <?php comment_text(); ?>
                    </div>

                    <div class="mt-3 text-sm text-[#E6675C] hover:underline">
                        <?php
                        comment_reply_link( array_merge( $args, array(
                            'add_below' => 'comment',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'before'    => '<div>',
                            'after'     => '</div>',
                            'reply_text'=> '返信する',
                        ) ) );
                        ?>
                    </div>
                </div>
            </div>
        <?php
    }
endif;
?>

<div id="comments" class="comments-area">
    <?php if ( have_comments() ) : ?>
        <div class="mt-12 w-auto h-8 flex items-center font-bold mb-4">
            <h3 class="uppercase bg-[#E6675C] text-lg text-white px-2 py-1 font-bold w-auto">
                <?php echo number_format_i18n( get_comments_number() ); ?> Comments
            </h3>
        </div> 
        
        <ol class="space-y-6">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
                'callback'    => 'wp_slash_tailwind_comment',
                'max_depth'   => intval( get_option( 'thread_comments_depth', 5 ) ),
            ) );
            ?>
        </ol>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav class="mt-6 flex items-center justify-between text-sm" aria-label="コメントナビゲーション">
                <div><?php previous_comments_link( '<span class="inline-flex items-center gap-2 text-[#E6675C] hover:underline">&larr; 古いコメント</span>' ); ?></div>
                <div><?php next_comments_link( '<span class="inline-flex items-center gap-2 text-[#E6675C] hover:underline">新しいコメント &rarr;</span>' ); ?></div>
            </nav>
        <?php endif; ?>

        <?php if ( ! comments_open() && get_comments_number() ) : ?>
            <p class="mt-4 text-sm text-gray-500">コメントは受け付けていません。</p>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    // Build Tailwind-styled form fields
    $commenter     = wp_get_current_commenter();
    $req           = get_option( 'require_name_email' );
    $aria_req      = $req ? " aria-required='true' required" : '';

    $fields = array(
        'author' =>
            '<div class="md:grid md:grid-cols-2 md:gap-4">' .
                '<div class="mb-4">' .
                
                    '<input id="author" name="author" type="text" placeholder="Name" value="' . esc_attr( $commenter['comment_author'] ) . '" class="block w-full bg-gray-100 border border-gray-300 px-3 py-2 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E6675C] focus:border-[#E6675C]"' . $aria_req . ' />' .
                '</div>',
        'email'  =>
                '<div class="mb-4">' .
                    
                    '<input id="email" name="email" type="email" placeholder="Email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" class="block w-full bg-gray-100 border border-gray-300 px-3 py-2 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E6675C] focus:border-[#E6675C]"' . $aria_req . ' />' .
                '</div>' .
            '</div>',
        'url'    =>
            '<div class="mb-4">' .
                
                '<input id="url" name="url" placeholder="Url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" class="block w-full bg-gray-100 border border-gray-300 px-3 py-2 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E6675C] focus:border-[#E6675C]" />' .
            '</div>',
    );

    $comment_field =
        '<div class="mb-4">' .
            
            '<textarea id="comment" name="comment" placeholder="Comment here ..." rows="5" class="block w-full  border bg-gray-100 border-gray-300 px-3 py-2 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E6675C] focus:border-[#E6675C]" aria-required="true" required></textarea>' .
        '</div>';

    $args = array(
        'title_reply'          => have_comments() ? 'leave a comment' : 'leave a comment',
        'title_reply_before'   => '<div class="mt-12 w-auto h-8 flex items-center font-bold mb-4"><h3 id="reply-title" class="uppercase bg-[#E6675C] text-lg text-white px-2 py-1 font-bold w-auto">',
        'title_reply_after'    => '</h3><div class="h-8 grow border-y border-y-[#F4F4F4] border-r border-r-[#E6675C]"></div></div>',
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
        'class_form'           => 'mt-6',
        'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
        'comment_field'        => $comment_field,
        'submit_field'         => '<div class="mt-6">%1$s %2$s</div>',
        'submit_button'        => '<button type="submit" class="inline-flex items-center bg-[#E6675C] px-5 py-2.5 text-white font-medium hover:bg-[#d3584f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#E6675C] transition-colors duration-200">%4$s</button>',
        'label_submit'         => 'Submit Comment',
        'cancel_reply_link'    => '返信をキャンセル',
        'logged_in_as'         => '',
    );

    // Move the comment textarea above the other fields (author/email/url)
    $wp_slash_reorder_comment_field = function( $fields ) {
        if ( isset( $fields['comment'] ) ) {
            $comment_field = $fields['comment'];
            unset( $fields['comment'] );
            $fields = array_merge( array( 'comment' => $comment_field ), $fields );
        }
        return $fields;
    };
    add_filter( 'comment_form_fields', $wp_slash_reorder_comment_field );

    comment_form( $args );

    // Clean up the filter to avoid affecting other forms in the same request
    remove_filter( 'comment_form_fields', $wp_slash_reorder_comment_field );
    ?>
</div>
