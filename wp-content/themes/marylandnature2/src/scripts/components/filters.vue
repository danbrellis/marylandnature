<template>
    <fieldset class="fieldset--normalize fc-category-filters">
        <div class="inline-fieldset">
            <legend class="inline-form__label inline-fieldset__legend">Filter: </legend>
            <ul class="inline-checkboxes flex-list flex-list--wrap">
                <li v-for="filter in filterOptions" class="flex-list__item flex-list__item--lessSpacing">
                    <input
                            type="checkbox"
                            :value="filter.slug"
                            v-model="checkedCats"
                            :id="'filter_for_' + filter.slug"
                            class="inline-form__control" />
                    <label :for="'filter_for_' + filter.slug" v-html="filter.label"></label>
                </li>
            </ul>
        </div>
    </fieldset>

</template>

<script>
    export default {
        name: "filters",
        props: {
            filterOptions: {
                type: Array,
                default: []
            }
        },
        data: function(){
            return {
                checkedCats: []
            }
        },
        watch: {
            checkedCats: function () {
                this.$emit('categoryFiltersChanged', this.checkedCats)
            }
        },
    }
</script>

<style scoped>

</style>