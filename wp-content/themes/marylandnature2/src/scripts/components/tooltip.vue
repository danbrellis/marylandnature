<template>
    <div>
        <h4>{{event.title}}</h4>
        <?php nhsm_em_the_event_terms_list($id, 'div'); ?>
        <table class="unstriped event-tooltip-data">
            <tr>
                <th>When</th>
                <td><?php echo nhsm_format_date_range(strtotime($post->event_occurrence_start_date), strtotime($post->event_occurrence_end_date), em_is_all_day($post->ID)); ?></td>
            </tr>
            <?php if($locs && is_array($locs) && !empty($locs[0])): ?>
            <tr>
                <th>Where</th>
                <?php foreach($locs as $loc) $wheres[] = sprintf('%s <a href="https://www.google.com/maps/search/'.str_replace(' ', '+', $loc->name).'/@%f,%f,15z" target="_blank">map</a>', $loc->name, $loc->location_meta['google_map']['latitude'], $loc->location_meta['google_map']['longitude']); ?>
                <td><?php echo implode($wheres); ?></td>
            </tr>
            <?php endif; ?>
            <?php $tag_list = get_the_tag_list( '<tr><th>Topics</th><td>', ', ', '</td></tr>');
            echo str_replace('/"', '/#events"', $tag_list); ?>
        </table>
        <a href="<?php echo get_permalink(); ?>" class="button small" title="<?php the_title(); ?>">More details</a>
    </div>
</template>

<script>
    export default {
        name: "tooltip",
        props: {
            event: {
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>