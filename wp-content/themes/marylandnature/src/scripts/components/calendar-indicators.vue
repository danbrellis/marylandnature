<template>
    <div class="fc-indicators">
        <transition name="fade" mode="out-in">
            <loader v-if="showLoader"></loader>
            <div v-if="!showLoader && noticeMsg !== ''" class="notice notice--error fc-notice">
                <font-awesome-icon icon="exclamation-circle" size="lg" class="fc-notice__icon"></font-awesome-icon>
                <span>{{ noticeMsg }}</span>
            </div>
        </transition>


    </div>
</template>

<script>
    import Vue from "vue/dist/vue.js";
    import loader from "./loader";
    import { library } from '@fortawesome/fontawesome-svg-core';
    import { faExclamationCircle } from '@fortawesome/free-solid-svg-icons';
    import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

    library.add(faExclamationCircle);

    Vue.component('font-awesome-icon', FontAwesomeIcon);

    export default {
        name: "calendar-indicators",
        props: {
            showLoader: {
                type: Boolean,
                default: false
            },
            noticeMsg: {
                type: String,
                default: ""
            }
        },
        components: {
            loader,
        },
    }
</script>

<style lang="scss">
    @import "../../styles/variables";
    @import "../../styles/mixins";
    .fc-notice {
        font-weight: $font-weight--bold;
        display: flex;
        align-items: center;
    }
    .fc-notice__icon {
        margin-inline-end: .375em;
        color: $alert;
    }
    .fc-indicators {
        height: 2em;
        margin-block-end: 1.5em;
    }
</style>