<?php global $post; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('archive'); ?> role="article" itemscope itemtype="http://schema.org/WebPage">
					
    <header class="article-header">
        <h3 class="entry-title single-title" itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
        <ul class="post-meta clearfix no-bullet">
            <li class="post-meta-date"><i class="fi-clock"></i>&nbsp;<?php echo nhsm_format_date_range(strtotime($post->event_occurrence_start_date), strtotime($post->event_occurrence_end_date), em_is_all_day($post->ID)); ?></li>
            <?php if(nhsm_is_event_over()): ?>
            <li class="post-meta-notice"><i class="fi-alert"></i>&nbsp;This event has passed.</li>
            <?php endif; ?>
            <?php the_tags('<li class="post-meta-tags"><i class="fi-pricetag-multiple" title="Tagged with:"></i>&nbsp;', ', ', '</li>'); ?>
        </ul>
        <?php nhsm_the_banner_image(); ?>
        <?php nhsm_em_the_event_terms_list(); ?>

    </header> <!-- end article header -->

    <section class="entry-content" itemprop="articleBody">
        <?php the_excerpt(); ?>
        <?php nhsm_addthis(); ?>
        <a class="more-link button small" href="<?php the_permalink(); ?>" title="Continue reading <?php the_title(); ?>">Read more</a>
        <?php wp_link_pages(); ?>
    </section> <!-- end article section -->

    <footer class="article-footer clearfix">

    </footer> <!-- end article footer -->
						    
</article> <!-- end article -->