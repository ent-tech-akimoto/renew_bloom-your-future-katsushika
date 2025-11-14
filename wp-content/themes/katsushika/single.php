<?php
// お知らせ詳細
$slug = 'news';
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<article class="detail">
  <div class="detail__wrap">
    <p class="common__bread detail">
      <span><a href="<?php echo esc_url( home_url('/') ); ?>">TOP</a></span><span><a
          href="<?php echo esc_url( home_url('/news/') ); ?>">お知らせ</a></span><span><?php the_title(); ?></span>
    </p>
    <div class="detail__header">
      <div class="detail__inner">
        <?php
        $new_days = 7;
        $now_local = current_time('timestamp');
        $published_local = get_post_time('U');
        $is_published = (get_post_status() === 'publish');

        $is_new = $is_published && (($now_local - $published_local) < ($new_days * DAY_IN_SECONDS));
        $display_date = get_the_date('Y年n月j日');
        ?>
        <div class="detail__header-top news" <?php echo $is_new ? ' data-update="new"' : ''; ?>>
          <div class="detail__header-datetime"><span><?php echo esc_html($display_date); ?></span></div>
        </div>
        <?php
        // 投稿に紐づくカテゴリを取得
        $categories = get_the_category();
        if ($categories && !is_wp_error($categories)) : ?>
        <div class="detail__header-category">
          <?php foreach ($categories as $cat) : ?>
          <p class="<?php echo esc_attr($cat->slug); ?>">#<?php echo esc_html($cat->name); ?></p>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <h1 class="detail__header-title"><?php the_title(); ?></h1>
      </div>
    </div>
    <div class="detail__content">
      <div class="detail__inner">
        <div class="detail__content-wrap">
          <?php the_content(); ?>
        </div>
      </div>
    </div>
    <a href="/news/" class="detail__back">もどる</a>
  </div>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>