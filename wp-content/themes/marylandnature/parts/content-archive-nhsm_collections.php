<div id="post-<?php the_ID(); ?>" <?php post_class('archive'); ?> role="article" itemscope itemtype="http://schema.org/WebPage">
    <h3 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h3>
    <p class="collection-meta">
        <span class="collector">Curated by <strong><?php echo nhsm_get_formatted_collector($post); ?></strong></span>
        <?php /* &nbsp;<span class="middot">&middot;</span>&nbsp;
        <span class="specimen-no">Includes <strong>230 specimens</strong></span>
        &nbsp;<span class="middot">&middot;</span>&nbsp;
        <span class="collection-date">Dated to <strong>1904</strong></span> */ ?>
    </p>
    <?php nhsm_the_banner_image(); ?>
</div> <!-- end div.archive -->