<template>
  <div>
    <Fieldset>
      <template #legend>
        <span>
          <router-link :to="`/user/${comment.user_id}`">
          {{comment.user.name}}
          </router-link>
        </span>
      </template>
      <div class="comment-text">
        {{comment.body}}
        <!-- ボタンクリック後のclass p-button-raised  クリック前のclass p-button-text 他は同じ-->
        <Button icon="pi pi-heart" v-bind:class="buttonClass" v-on:click="likeComment(comment.id, comment.user.id)" class=" p-button-danger p-button-rounded p-button-sm" iconPos="right"/>
      </div>
    </Fieldset>
  </div>
</template>

<script>
import axios from '@/supports/axios'
export default {
  props: {
    comment: Object
  },
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
    //  コメントにいいねをする
    likeComment (commentId, userId) {
      console.log('likeComment')
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          console.log('sanctum ok')
          axios.post('/api/commentlike', {
            comment_id: commentId,
            user_id: userId
          })
            .then((res) => {
              console.log(res)
              if (res.status === 201) {
                console.log('いいねしました')
                this.likeClicked = true
              } else {
                console.log('いいねに失敗しました')
                console.log(res)
              }
            })
            .catch((err) => {
              console.log(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
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
