<template>
  <dialog
    class="tooltip"
    v-bind:open="showTooltip"
    v-show="showTooltip"
    :style="tooltipStyle"
  >
    <header class="tooltip__header">
      <button
        class="tooltip__close-button"
        aria-label="Close event details"
        type="button"
        v-on:click="$emit('closeTip')"
      >
        <span aria-hidden="true">×</span>
      </button>
      <h3 class="tooltip__title">{{ title }}</h3>
    </header>
    <div class="tooltip__cat-labels" v-html="cats"></div>

    <table class="tooltip__data">
      <tbody>
        <tr>
          <th>When</th>
          <td>{{ when }}</td>
        </tr>
        <tr>
          <th>Where</th>
          <td v-html="location"></td>
        </tr>
        <tr v-if="tags">
          <th>Topics</th>
          <td v-html="tags"></td>
        </tr>
      </tbody>
    </table>
    <a
      :href="url"
      class="button button--primary button--small tooltip__cta-button"
      :title="title"
      >Visit event page</a
    >
  </dialog>
</template>

<script>
//add focus trap
export default {
  name: "tooltip",
  props: {
    e: {
      type: Object,
      required: true,
    },
    tooltipStyle: {
      type: Object,
      default: () => {
        return {
          top: "0px",
          left: "0px",
        };
      },
    },
    showTooltip: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    title: function () {
      return "title" in this.e ? this.e.title : "";
    },
    cats: function () {
      return "extendedProps" in this.e ? this.e.extendedProps.c : "";
    },
    when: function () {
      return "extendedProps" in this.e ? this.e.extendedProps.d : "";
    },
    location: function () {
      return "extendedProps" in this.e ? this.e.extendedProps.l : "";
    },
    tags: function () {
      return "extendedProps" in this.e ? this.e.extendedProps.t : "";
    },
    url: function () {
      return "extendedProps" in this.e ? this.e.extendedProps.u : "";
    },
  },
};
</script>

<style lang="scss">
@import "../../styles/variables";

.tooltip {
  position: absolute;
  background: $white;
  padding: 1em;
  border: 1px solid $gray--dark;
  font-size: 0.875em;
  z-index: 9;
  margin: 0;
  max-width: 370px;
  color: $reading;
  box-shadow: 0 0 10px 0 $reading;
}
.tooltip__header {
  display: flex;
  justify-content: space-between;
  margin-block-end: 0.75em;
}
.tooltip__close-button {
  background: none;
  color: $reading;
  font-size: 2rem;
  width: 2rem;
  height: 2rem;
  margin: -0.5rem -0.5rem 0 0;
  border: 0;
  font-family: Courier, monospace;
  font-weight: 500;
  order: 2;
  align-self: start;
  border-radius: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  line-height: 1;

  &:hover {
    cursor: pointer;
    background: $gray;
    color: $black;
  }
  &:focus {
    box-shadow: 0 0 0 0.2rem rgba(76, 91, 106, 0.5);
    background: $gray;
    color: $black;
    outline: 0;
  }
  &:active {
    background: $dark;
    color: $white;

    outline: 0;
  }
}
.tooltip__title {
  margin: 0;
  font-size: 1.25rem;
}
.tooltip__data {
  margin-block-end: 0.5em;

  tr {
    display: flex;
    align-items: baseline;
  }
  th {
    text-transform: uppercase;
    font-size: 0.625em;
    color: lighten($reading, 20%);
  }
  td {
    font-size: 0.875em;
  }
  th,
  td {
    padding: 0.625rem;
  }
  address {
    font-style: normal;
  }
}
</style>
