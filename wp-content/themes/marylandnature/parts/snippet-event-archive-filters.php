<?php
$qo = get_queried_object();
$queried_term_id = is_a($qo, 'WP_Post_Type') ? false : $qo->term_id;
$terms = get_terms( array(
    'taxonomy' => 'event-category',
    'hide_empty' => false,
) );

$scope = isset($_GET['show']) ? sanitize_title($_GET['show']) : 'upcoming';	?>

<form class="inline-form" method="get" action="">
    <fieldset class="fieldset--normalize">
        <div class="inline-fieldset">
            <legend class="inline-form__label inline-fieldset__legend">Filter: </legend>
            <label for="show-scope" class="sr-only">Scope</label>
            <select name="show" id="show-scope" class="select-css inline-form__control inline-form__control--grow" onchange="this.form.submit()">
                <option value="upcoming" <?php selected($scope, 'upcoming'); ?>>Upcoming Events</option>
                <option value="past" <?php selected($scope, 'past'); ?>>Past Events</option>
            </select>

            <label for="show-cats" class="sr-only">Category</label>
            <?php if($terms && !empty($terms) && !is_wp_error($terms)): ?>
                <select class="select-css inline-form__control inline-form__control--grow" id="show-cats" onchange="javascript:location.href = this.value;">
                    <option value="<?php echo add_query_arg('show', $scope, get_post_type_archive_link('event')); ?>">All Categories</option>
                    <?php foreach($terms as $term): ?>
                        <option value="<?php echo add_query_arg('show', $scope, get_term_link($term)); ?>" <?php selected( $term->term_id, $queried_term_id ); ?>><?php echo $term->name; ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </div>
    </fieldset>


</form>