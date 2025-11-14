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
        <h1 class="detail__header-title"><?php the_title(); ?></h1>
      </div>
    </div>
    <div class="detail__content">
      <div class="detail__inner">
        <div class="detail__content-wrap">
          <p class="sponsor-detail__postdate">掲載日　<span><?php echo get_the_date('Y.n.j'); ?></span></p>
          <?php the_content(); ?>
          <div class="detail__content-block">
            <h2>募集期間</h2>
            <p>2026年5月15日〜6月15日</p>
          </div>
          <div class="detail__content-block">
            <h2>募集内容</h2>
            <div class="detail__content-img">
              <img src="../../assets/img/event/media_2.png" alt="">
            </div>
            <p>開催テーマに基づき、多種多様な団体や企業に出典募集します。<br>
              また来場者の興味やニーズに合わせた出典内容にすることで、<br>
              本フェアの統一感を高め、出店者のみならず主催者、来場者等の一体感を高めます。<br>
              これらの協賛展示により、新たなコミュニティを形成し、本フェア終了後も活動や購入等の継続を目指します。</p>
          </div>
          <div class="detail__content-block">
            <h2>会場</h2>
            <p>にいじゅくみらい公園</p>
          </div>
          <div class="detail__content-block">
            <h2>応募資格</h2>
            <p>応募資格がはいります応募資格がはいります応募資格がはいります応募資格がはいります</p>
          </div>
          <div class="detail__content-block">
            <h2>その他</h2>
            <p>
              その他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいりますその他内容がはいります
            </p>
          </div>
          <div class="sponsor-detail__contact">
            <p>以下お問い合わせより受付いたします。</p>
            <a href="" class="sponsor-detail__contact--btn">
              <span>お問い合わせはこちら</span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <a href="/sponsors/" class="detail__back"><span>もどる</span></a>
  </div>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>