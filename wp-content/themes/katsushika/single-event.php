<?php
// イベント詳細
$slug = 'event';
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<article class="detail">
  <div class="detail__wrap">
    <p class="common__bread detail">
      <span><a href="<?php echo esc_url( home_url('/') ); ?>">TOP</a></span><span><a
          href="<?php echo esc_url( home_url('/event/') ); ?>">イベント情報</a></span><span><?php the_title(); ?></span>
    </p>
    <div class="detail__header">
      <div class="detail__inner">
        <?php $event_period = get_field('event_period');?>
        <div class="detail__header-datetime">
          <?php if ($event_period) : ?>
          <?php echo esc_html($event_period); ?>
          <?php endif; ?>
        </div>
        <?php $event_areas = get_the_terms(get_the_ID(), 'event_area'); ?>
        <?php if ($event_areas && ! is_wp_error($event_areas)) : ?>
        <?php
          $area = $event_areas[0];
          $area_slug = $area->slug;
          $area_name = $area->name;
        ?>
        <p class="detail__header-area" data-area="<?php echo esc_attr($area_slug); ?>">
          <svg viewBox="0 0 19 27" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M9.35714 0C4.18955 0 0 3.85528 0 8.61057C0 13.3659 9.35714 27 9.35714 27C9.35714 27 18.7143 13.3665 18.7143 8.61057C18.7143 3.8546 14.5247 0 9.35714 0ZM9.35714 12.6835C6.60824 12.6835 4.37921 10.633 4.37921 8.10274C4.37921 5.57247 6.60749 3.52198 9.35714 3.52198C12.1068 3.52198 14.3351 5.57247 14.3351 8.10274C14.3351 10.633 12.1068 12.6835 9.35714 12.6835Z" />
          </svg>
          <span><?php echo esc_html($area_name); ?></span>
        </p>
        <?php endif; ?>
        <?php $event_cats = get_the_terms(get_the_ID(), 'event_cat');?>

        <?php if ($event_cats && ! is_wp_error($event_cats)) : ?>
        <div class="detail__header-category">
          <?php foreach ($event_cats as $cat) : ?>
          <p>#<?php echo esc_html($cat->name); ?></p>
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
    <a href="/event/" class="detail__back"><span>もどる</span></a>
  </div>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>