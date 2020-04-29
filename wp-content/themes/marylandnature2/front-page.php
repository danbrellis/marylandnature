<?php get_header(); ?>
    <main class="main main--homepage" id="main">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; endif; ?>
        <!--
        <section class="homepage-section nhsm-cta-newsletter-signup">
            <div class="container nhsm-cta-newsletter-signup__inner">
                <h2 class="nhsm-cta-newsletter-signup__title">Natural History in Your Inbox!</h2>
                <p class="nhsm-cta-newsletter-signup__body">Sign up to get regular email updates about upcoming field trips, Nature Connections, courses, lectures and workshops, special events, and club happenings.</p>
                <a href="/get-involved/email-updates/" class="button button--primary button--prominent nhsm-cta-newsletter-signup__button iconButton--iconFirst iconButton--grow"><i class="fas fa-paper-plane"></i> Sign Up For Emails</a>
                <div class="nhsm-cta-newsletter-signup__figure">
                    <figure class="figure figure--captionOverlay figure--circle">
                        <img src="https://www.marylandnature.org/wp-content/uploads/2019/04/Photo-by-Joe-McSharry-975x975-1573825204.jpg" width="975" height="975" srcset="https://www.marylandnature.org/wp-content/uploads/2019/04/Photo-by-Joe-McSharry-975x975-1573825204.jpg 975w, https://www.marylandnature.org/wp-content/uploads/2019/04/Photo-by-Joe-McSharry-200x200.jpg 200w, https://www.marylandnature.org/wp-content/uploads/2019/04/Photo-by-Joe-McSharry-125x125.jpg 125w" sizes="(max-width: 975px) 100vw, 975px" title="NHSM Museum wall" alt="The wall of a natural history museum- various animal mounts are hung on the walls, such as eagles, deer, and a black bear, and display cases contain artifacts and other specimens." class=" img-responsive">
                        <figcaption class="figure__caption">Photo by Joe McSharry</figcaption>
                    </figure>
                </div>
            </div>
        </section>
        <?php
        $collections_args = [
            'post_type' => 'nhsm_collections',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'orderby' => 'rand'
        ];
        $collections = new WP_Query($collections_args);
        if($collections->have_posts()):
        ?>
        <section class="homepage-section nhsm-cta-collections">
            <div class="container nhsm-cta-collections__inner">
                <h2 class="nhsm-cta-collections__title">To Collect and Preserve</h2>
                <p class="nhsm-cta-collections__lead">Our collections show a glimpse into the vast and fascinating natural world of Maryland.</p>
                <section class="nhsm-cta-collections__collectionGrid">
                    <h3 class="nhsm-cta-collections__collectionsGridTitle">
                        <span>Learn about </span><a href="/learn/collections" class="button button--primary button--prominent nhsm-cta-collections__button">our collections</a>
                    </h3>
                    <?php while($collections->have_posts()): $collections->the_post(); ?>
                            <?php get_template_part( 'parts/card', get_post_type() ); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                </section>
            </div>
        </section>
        <?php endif; ?>
        -->
        <section class="homepage-section nhsm-cta-join">
            <div class="container nhsm-cta-join__inner">
                <h2 class="nhsm-cta-join__title">Show Your Support</h2>
                <p class="nhsm-cta-join__body">Help us continue to deliver quality, engaging programs and provide a space for all Marylanders to learn and explore.</p>
                <p class="nhsm-cta-join__actions"><a href="/" class="button button--primary button--prominent">Become a member</a> or <a href="/" class="button button--primary button--prominent">learn more</a> about what we do</p>
            </div>
            <span class="bg-caption">Photo by <a href="https://www.flickr.com/photos/allianceforthebay/13726291073/in/album-72157643586815294/" target="_blank">Alliance for the Chesapeake Bay</a></span>
        </section>
    </main>
<?php get_footer(); ?>