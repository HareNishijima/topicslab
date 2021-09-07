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
      </template>
      <template #footer>
        <span>
          <router-link :to="`/user/${user.id}`">{{user.name}}</router-link>
        </span>
      </template>
    </Card>
    <Comments :comments="this.comments" />
    <CommentForm :topicId="this.topic.id" @sentComment="receiveComment" />
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
      topic_likes: {},
      comments: [],
      comment_likes: {},
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
                console.log('取得成功')
                console.log(res)
                //  topicのデータを取得する
                this.topic = res.data[0]
                this.user = this.topic.user
                this.topic_likes = this.topic.like

                this.comments.splice(0)
                this.comments.push(...this.topic.comments)
                this.comment_likes = this.comments[0].like
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
    },
    //  トピックにいいねをする
    likeTopic (topicId, userId) {
      console.log('likeTopic')
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          //  console.log('sanctum ok')
          axios.post('/api/topiclike', {
            topic_id: topicId,
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

<style scoped>
.body-text {
  white-space:pre-wrap;
}
.p-card-footer span {
  text-align: right;
  display: block;
}
</style>
