<?php
get_header();

$page_obj = get_queried_object();
$slug = '';
if ($page_obj instanceof WP_Post) {
  $slug = $page_obj->post_name;
}
?>
<article class="<?php echo $slug ? esc_attr($slug) . '__wrapper' : ''; ?>">
  <div class="<?php echo $slug ? esc_attr($slug) . '__bg' : ''; ?>"></div>
  <p class="common__bread l-page">
    <span><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></span><span><?php the_title(); ?></span>
  </p>
  <h1 class="common__h1 <?php echo $slug ? esc_attr($slug) . '__h1' : ''; ?>"><?php the_title(); ?></h1>
  <?php the_content(); ?>
</article>
<?php get_footer(); ?>