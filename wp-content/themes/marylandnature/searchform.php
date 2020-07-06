<?php $search_field_id = 'search-field_' . microtime(true);
$placeholders = [
    "Try 'mammals', 'minerals', 'moss', or more!",
    "Try 'omnivores', 'ocean', 'ornithology', or others!",
    "Try 'amphibians, 'aquatic', 'archaeology', or another!",
    "Try 'entomology, 'ecosystem', 'events', etc!",
    "Try 'snakes', 'science', 'soil', and such!",
    "Try 'lichens', and the like!"
];
?>
<form role="search" class="inline-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="inline-form__group inline-form-child--grow">
        <label for="<?php echo $search_field_id; ?>">Search for:</label>
        <input type="search" class="search-field inline-form__control form__control inline-form-child--grow" id="<?php echo $search_field_id; ?>" placeholder="<?php echo $placeholders[mt_rand(0, count($placeholders) - 1)]; ?>" value="<?php echo get_search_query() ?>" name="s" title="Search for:" />
    </div>
    <div class="inline-form__group">
        <input type="submit" class="search-submit button button--primary" value="Search" />
    </div>
</form>

