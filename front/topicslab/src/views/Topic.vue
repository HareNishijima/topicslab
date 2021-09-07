<template>
  <div>
    <Loading v-show="loading_status" />
    <Card v-show="!loading_status">
      <template #title>
        {{topic.title}}
      </template>
      <template #content>
        <div class="body-text">
          {{topic.body}}
        </div>
        <!-- ボタンクリック後のclass p-button-raised  クリック前のclass p-button-text 他は同じ-->
        <Button icon="pi pi-heart" v-bind:class="buttonClass" v-on:click="likeTopic(this.topic.id, this.user.id)" class=" p-button-danger p-button-rounded p-button-sm" iconPos="right"/>
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
import Loading from '@/components/Loading'

//  export defaultで囲まれた範囲は他のコンポーネント(templete,style)から参照できるようになる
export default {
  name: 'Topic',
  components: {
    Comments,
    CommentForm,
    Loading
  },
  data () {
    return {
      topic: {},
      user: {},
      topic_likes: {},
      comments: [],
      id: null,
      loading_status: true,
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
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('/login')
      return
    }
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
                //  console.log('取得成功')
                //  console.log(res)
                this.topic = res.data[0]
                this.user = this.topic.user
                this.topic_likes = this.topic.like
                this.comments.splice(0)
                this.comments.push(...this.topic.comments)
                this.loading_status = false
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
          console.log('sanctum ok')
          axios.post('/api/topiclike', {
            topic_id: topicId,
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

<style scoped lang="scss">
@mixin p-button(){float:right;
}
.body-text {
  white-space:pre-wrap;
}
.p-card-footer span {
  text-align: right;
  display: block;
}

.p-button-text{
  @include p-button;
}
.p-button-raised{
  @include p-button;
}
</style>
