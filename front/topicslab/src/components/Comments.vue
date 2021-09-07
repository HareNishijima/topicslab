<template>
  <div>
    <Fieldset v-for="comment in comments" :key="comment.id">
      <template #legend>
        <span>
          <router-link :to="`/user/${comment.user_id}`">{{comment.user.name}}</router-link>
        </span>
      </template>
      <div class="comment-text">
        {{comment.body}}
      </div>
    </Fieldset>
  </div>
</template>

<script>
import axios from '@/supports/axios'

export default {
  name: 'Comments',
  props: {
    comments: Array
  },
  methods: {
    //  コメントにいいねをする
    likeComment (commentId, userId) {
      //  console.log('likeComment')
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          //  console.log('sanctum ok')
          axios.post('/api/commentlike', {
            comment_id: commentId,
            user_id: userId
          })
            .then((res) => {
              //  console.log(res)
              if (res.status === 201) {
                //  console.log('いいねしました')
              } else {
                //  console.log('いいねに失敗しました')
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
.p-fieldset {
  margin-top: 20px;
}

.comment-text {
  white-space:pre-wrap;
}
</style>
