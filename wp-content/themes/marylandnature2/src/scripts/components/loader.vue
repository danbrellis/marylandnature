<template>
  <div title="Loading" v-show="showLoader">
    <div class="loader">Loading...</div>
  </div>
</template>

<script>
export default {
  name: "loader",
  props: {
    showLoader: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../styles/variables";
.loader,
.loader:after {
  border-radius: 50%;
  width: 2em;
  height: 2em;
}
.loader {
  font-size: 10px;
  position: relative;
  text-indent: -9999em;
  border-top: 0.5em solid rgba($dark, 0.2);
  border-right: 0.5em solid rgba($dark, 0.2);
  border-bottom: 0.5em solid rgba($dark, 0.2);
  border-left: 0.5em solid $dark;
  transform: translateZ(0);
  animation: load8 1.5s infinite linear;
}
@-webkit-keyframes load8 {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@keyframes load8 {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
