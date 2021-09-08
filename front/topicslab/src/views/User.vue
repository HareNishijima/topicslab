<template>
  <div>
    <Modal :message="this.errMessage" v-show="showContent" @close="closeModal" />
    <Loading v-show="loading_status" />
    <Card v-show="!loading_status">
      <template #content>
        {{user.name}}
      </template>
    </Card>
    <Loading v-show="loading_status" />
    <Card v-show="!loading_status">
      <template template #content>
        <TabView>
          <TabPanel header="トピック一覧">
            <div v-for="topic in topics" :key="topic.id">
              <span class="topic-date">投稿日：{{moment(topic.created_at)}}</span>
              <h2>
                <router-link :to="`/topic/${topic.id}`">
                {{topic.title}}
              </router-link>
              </h2>
            </div>
          </TabPanel>
          <TabPanel header="コメント一覧">
            <div v-for="comment in comments" :key="comment.id">
                <span class="topic-date">投稿日：{{moment(comment.created_at)}}</span>
                <h2>
                  <router-link :to="`/topic/${comment.topic_id}`">
                  {{comment.body}}
                  </router-link>
                </h2>
            </div>
          </TabPanel>
        </TabView>
      </template>
    </Card>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import moment from 'moment'
import Modal from '@/components/Modal'
import Loading from '@/components/Loading'

export default {
  name: 'user',
  components: {
    Modal,
    Loading
  },
  data () {
    return {
      id: null,
      user: {},
      errMessage: 'ユーザー情報の取得に失敗しました．',
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
      this.$router.push('/login')
      return
    }

    this.id = this.$route.params.id
    if (!this.id) {
      alert('不正なIDです。')
    }
    this.getUser()
  },
  methods: {
    moment: function (date) {
      return moment(date).format('YYYY/MM/DD HH:mm:SS')
    },
    getUser () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get(`/api/user/${this.id}`)
            .then((res) => {
              if (res.status === 200) {
                this.user = res.data[0]
                //  ユーザが投降したトピック、コメントはuser.comments、user.topicsにリストで入っている
                this.topics = this.user.topics
                this.comments = this.user.comments
                this.topiclikes = this.user.topiclikes
                this.commentlikes = this.user.commentlikes
                this.loading_status = false
              } else {
                console.log('取得失敗')
                this.openModal()
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
    openModal () {
      this.showContent = true
    },
    closeModal () {
      this.showContent = false
    }
  }
}
</script>

<style lang="scss" scoped>
.p-card.p-component {
  margin-bottom: 20px;
}
</style>
