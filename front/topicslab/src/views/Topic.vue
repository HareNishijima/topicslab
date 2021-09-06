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
        <!-- ボタンクリック後のclass p-button-raised  クリック前のclass p-button-text 他は同じ-->
        <Button icon="pi pi-heart" v-bind:class="buttonClass" v-on:click="likeTopic" class=" p-button-danger p-button-rounded p-button-sm" iconPos="right"/>
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
      id: null,
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
    this.id = this.$route.params.id
    if (!this.id) {
      alert('不正なIDです。')
    }
    this.getTopic()
  },
  methods: {
    likeTopic () {
      console.log('aaaa')
      this.likeClicked = true
    },
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
