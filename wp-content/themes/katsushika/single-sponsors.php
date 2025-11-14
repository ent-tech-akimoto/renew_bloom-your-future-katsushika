<?php
// 募集情報詳細
$slug = 'sponsors';
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<article class="detail sponsor-detail">
  <div class="detail__wrap">
    <p class="common__bread detail">
      <span><a href="<?php echo esc_url( home_url('/') ); ?>">TOP</a></span><span><a
          href="<?php echo esc_url( home_url('/sponsors/') ); ?>">募集情報</a></span><span><?php the_title(); ?></span>
    </p>
    <div class="detail__header">
      <div class="detail__inner">
        <div class="detail__header-top sponsors">
          <h1 class="detail__header-title"><?php the_title(); ?></h1>
        </div>
      </div>
    </div>
    <div class="detail__content">
      <div class="detail__inner">
        <div class="detail__content-wrap">
          <p class="sponsor-detail__postdate">掲載日　<span><?php echo get_the_date('Y.n.j'); ?></span></p>
          <?php the_content(); ?>
        </div>
      </div>
    </div>
    <a href="/sponsors/" class="detail__back"><span>もどる</span></a>
  </div>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>