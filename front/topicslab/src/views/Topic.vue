<template>
  <div>
    <Card>
      <template #title>
        {{topic.title}}
      </template>
      <template #content>
        <div class="body-text">
          {{topic.body}}
        </div>
        <div class="body-text">{{topic.like}}</div><!--いいねの数-->
      </template>
      <template #footer>
        <span>
          <router-link :to="`/user/${user.id}`">{{user.name}}</router-link>
        </span>
      </template>
    </Card>
    <Comments :comments="this.comments" />
    <CommentForm :topicId="this.topic.id" @sentComment="receiveComment" />
      <div class="body-text">{{this.comment_likes}}</div><!--いいねの数-->
  </div>
</template>

<script>
import axios from '@/supports/axios'
import Comments from '@/components/Comments'
import CommentForm from '@/components/CommentForm'

//  export defaultで囲まれた範囲は他のコンポーネント(templete,style)から参照できるようになる
export default {
  name: 'Topic',
  components: {
    Comments,
    CommentForm
  },
  data () {
    return {
      topic: {},
      user: {},
      like: {},
      comments: [],
      comment_likes: null,
      id: null
    }
  },
  mounted () {
    this.id = this.$route.params.id
    if (!this.id) {
      alert('不正なIDです。')
    }
    this.getTopic()
  },
  methods: {
    getTopic () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(`/api/topic/${this.id}`)
            .then((res) => {
              if (res.status === 200 && res.data.length === 1) {
                //  topicのデータを取得する
                this.topic = res.data[0]
                this.user = this.topic.user
                //  ↓WithCount()に変える必要がある
                this.topic.like = 'いいねの数：' + String(this.topic.like.length)

                console.log(this.topic.comments)
                this.comments.splice(0)
                this.comments.push(...this.topic.comments)
                this.comment_likes = 'いいねの数：' + String(this.comments[0].like.length)
              } else {
                console.log('取得失敗')
              }
            })
            .catch((err) => {
              console.log(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    receiveComment (comment) {
      this.comments.push(comment)
    }
  }
}
</script>

<style scoped>
.body-text {
  white-space:pre-wrap;
}
.p-card-footer span {
  text-align: right;
  display: block;
}
</style>
