<?php global $post; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('article archiveArticle'); ?>>

    <header class="article__header">
        <h1 class="article__title archiveArticle__title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
        <ul class="post-meta flex-list flex-list--wrap">
            <li class="post-meta-date flex-list__item icon-with-text"><i class="far fa-clock icon icon--accentuate"></i>&nbsp;<?php echo nhsm_format_date_range(strtotime($post->event_occurrence_start_date), strtotime($post->event_occurrence_end_date), em_is_all_day($post->ID)); ?></li>
            <?php if(nhsm_is_event_over()): ?>
                <li class="post-meta-notice flex-list__item icon-with-text"><i class="fas fa-exclamation-circle icon icon--accentuate"></i>&nbsp;This event has passed.</li>
            <?php endif; ?>
            <?php the_tags('<li class="post-meta-tags flex-list__item icon-with-text"><i class="fas fa-tags icon icon--accentuate" title="Tagged with:"></i>&nbsp;', ', ', '</li>'); ?>
        </ul>

        <?php
        nhsm_the_banner_image();
        nhsm_em_the_event_terms_list(); ?>
    </header><!-- end article header -->

    <section class="entry-content" itemprop="articleBody">
        <?php the_excerpt(); ?>
        <?php if( have_rows('registration_types') ){
            $prices = [];
            while ( have_rows('registration_types') ){
                the_row();
                $prices[] = get_sub_field('base_price');

            }
            if(count($prices) === 1)
                printf('<p>Cost: $%d', $prices[0]);
            else printf('<p>Cost: $%d-%d', min($prices), max($prices));
        } ?>

    </section> <!-- end article section -->

    <footer class="article-footer">
        <a class="more-link button button--primary button--small" href="<?php the_permalink(); ?>" title="Continue reading <?php the_title(); ?>">Read more</a>
    </footer> <!-- end article footer -->

</article> <!-- end article -->