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
        <Button class="p-button-outlined"/>
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
      comments: [],
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
                console.log(res)
                this.topic = res.data[0]
                this.user = this.topic.user
                this.comments.splice(0)
                this.comments.push(...this.topic.comments)
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
.p-button-outlined{
  font-family: primeicons;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  box-sizing: border-box;
  margin-top: 15px;
  /* float: right;
  overflow: hidden; */
}
.p-button-outlined::before{
  content: "\e984";
}
</style>
