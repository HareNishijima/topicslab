<template>
  <div>
    <Modal :message="this.errMessage" v-show="showContent" @close="closeModal" />
    <Loading v-show="loading_status" />
    <Card v-show="!loading_status">
      <template #title>
        会員情報
      </template>
      <template #content>
        {{user.name}}
      </template>
      <template #footer>
        <Button label="トピックの作成" v-on:click="toNewTopic" />
        <Button label="ログアウト" class="p-button-warning" v-on:click="logout" />
        <Button label="アカウント削除" class="p-button-danger" v-on:click="withdraw" />
      </template>
    </Card>
  </div>

  <h2>投稿トピック一覧</h2>
  <Loading v-show="loading_status" />
  <Card v-for="topic in topics" :key="topic.id" v-show="!loding_status">
    <template #content>
      <span class="topic-date">投稿日：{{moment(topic.created_at)}}</span>
      <h2>
        <router-link :to="`/topic/${topic.id}`">
          {{topic.title}}
        </router-link>
      </h2>
    </template>
  </Card>

  <h2>投稿コメント一覧</h2>
  <Loading v-show="loading_status" />
  <Card v-for="comment in comments" :key="comment.id" v-show="!loding_status">
    <template #content>
      <span class="topic-date">投稿日：{{moment(comment.created_at)}}</span>
      <h2>
        <router-link :to="`/topic/${comment.topic_id}`">
          {{comment.body}}
        </router-link>
      </h2>
    </template>
  </Card>
</template>

<script>
import axios from '@/supports/axios'
import moment from 'moment'
import Loading from '@/components/Loading'
import Modal from '@/components/Modal'

export default {
  name: 'Userself',
  components: {
    Loading,
    Modal
  },
  data () {
    return {
      user: {},
      errMessage: 'ユーザ情報の取得に失敗しました．',
      showContent: false,
      topics: {},
      comments: {},
      topiclikes: {},
      commentlikes: {},
      loading_status: true
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('login')
      return
    }
    this.getUser()
  },
  methods: {
    moment: function (date) {
      return moment(date).format('YYYY/MM/DD HH:mm:SS')
    },
    toNewTopic () {
      this.$router.push('topic')
    },
    logout () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/logout')
            .then(res => {
              console.log(res)
              localStorage.setItem('authenticated', 'false')
              this.$router.push('/login')
            })
            .catch(err => {
              console.log(err)
            })
        })
        .catch((err) => {
          alert(err)
        })
    },
    withdraw () {
      //
    },
    getUser () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get('/api/user')
            .then((res) => {
              //  ログインしているアカウントの情報を取得
              if (res.status === 200) {
                this.user = res.data
                //  ユーザが投稿したトピックやコメントの情報を取得
                axios.get(`/api/user/${this.user.id}`)
                  .then((res) => {
                    //  console.log(res)
                    if (res.status === 200) {
                      //  console.log('取得成功')
                      const data = res.data[0]// 取得したデータ
                      this.topics = data.topics
                      this.comments = data.comments
                      this.topiclikes = data.topiclikes
                      this.commentlikes = data.commentlikes
                      this.loading_status = false
                    } else {
                      //  console.log('取得失敗')
                    }
                  })
              } else {
                console.log('ログインしたアカウント情報取得失敗')
              }
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
.p-card-footer {
  .p-button {
    margin-right: 10px;
  }
}

.p-card.p-component {
  margin-bottom: 20px;
}
.p-card-content {
  .topic-date {
    font-size: 80%;
  }
}

</style>
