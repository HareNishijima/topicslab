<template>
  <div>
    <Fieldset>
      <template #legend>
        <span>{{comment.user.name}}</span>
      </template>
      <div class="comment-text">
        {{comment.body}}
        <!-- ボタンクリック後のclass p-button-raised  クリック前のclass p-button-text 他は同じ-->
        <Button icon="pi pi-heart" v-bind:class="buttonClass" v-on:click="likeComment" class=" p-button-danger p-button-rounded p-button-sm" iconPos="right"/>
      </div>
    </Fieldset>
  </div>
</template>

<script>

export default {
  props: {
    comment: Object
  },
  // いいねボタン
  data () {
    return {
      likeClicked: false
    }
  },
  computed: {
    buttonClass () {
      if (this.likeClicked === true) {
        return 'p-button-raised'
      }
      return 'p-button-text'
    }
  },
  methods: {
    likeComment () {
      this.likeClicked = true
    }
  }
}
</script>

<style lang="scss" scoped>
@mixin p-button(){float:right;
}
.p-fieldset {
  margin-top: 20px;
  .p-button-text{
    @include p-button;
  }
  .p-button-raised{
    @include p-button;
  }
}

.comment-text {
  white-space:pre-wrap;
}
</style>
