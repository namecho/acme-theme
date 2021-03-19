<?php
// 移除 emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// 移除管理员 bar
add_filter('show_admin_bar', '__return_false');

// 移除离线编辑器开放接口
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

// 移除 wordpress 版本信息
remove_action('wp_head', 'wp_generator');

// 移除头部加载 DNS 预获取
function remove_dns_prefetch($hints, $relation_type)
{
    if ('dns-prefetch' === $relation_type) {
        return array_diff(wp_dependencies_unique_hosts(), $hints);
    }

    return $hints;
}
add_filter('wp_resource_hints', 'remove_dns_prefetch', 10, 2);

// 移除 wp-json 链接
remove_action('wp_head', 'rest_output_link_wp_head', 10);

// 移除 wp-block-library-css
function fanly_remove_block_library_css()
{
    wp_dequeue_style('wp-block-library');
}
add_action('wp_enqueue_scripts', 'fanly_remove_block_library_css', 100);

// 自定义 wp_head
function acme_header()
{
    echo '';
}
add_action('wp_head', 'acme_header');

// 注册样式
wp_register_style(
    'style', // 名称
    get_template_directory_uri() . '/style.css', // 样式表的路径
    [], // 依存的其他样式表
    '1.0', // 版本号
    'screen' // CSS 媒体类型
);

// 加载静态资源
function acme_scripts()
{
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'acme_scripts');


function modify_html_title($string)
{
    if (!is_singular()) {
        return  $string;
    }
    $count_key = 'seo_title';  //seo_title后台自定义的字段
    global $post;
    $content = get_post_meta($post->ID, $count_key, true);
    if (!$content) {
        return  $string;
    }
    return  $string . $content . ' - ';
}
add_filter('wp_title', 'modify_html_title', 10, 2);


register_nav_menus(
    array(
        'header-menu' => __('导航菜单'),
    )
);
