<template>
  <div>
    <div class="el-modal" :aria-hidden="isOpen ? 'false' : 'true'">
      <div class="el-modal__holder">
        <button @click="close()">閉じる</button>
      </div>
      <div class="el-modal__overlay"></div>
    </div>
    <button @click="open()">開く</button>
  </div>
</template>

<script>
export default {
  name: "Modal",
  data: function() {
    return {
      isOpen: false
    };
  },
  methods: {
    open: function() {
      this.isOpen = true;
    },
    close: function() {
      this.isOpen = false;
    }
  }
};
</script>
<style lang="sass">
  .el-modal
    visibility: hidden

    &__holder
      position: fixed
      z-index: 1100
      background-color: blue
      width: 50%
      height: 50%

    &__overlay
      position: fixed
      z-index: 1000
      background-color: red
      width: 100%
      height: 100%

    &[aria-hidden=false]
      visibility: visible
</style>