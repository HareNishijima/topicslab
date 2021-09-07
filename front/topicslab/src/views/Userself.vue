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
</template>

<script>
import axios from '@/supports/axios'
import Modal from '@/components/Modal'
import Loading from '@/components/Loading'

export default {
  name: 'Userself',
  components: {
    Loading
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
  components: {
    Modal
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('login')
      return
    }

    this.getUser()
  },
  methods: {
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
                this.openModal()
                console.log('ログインしたアカウント情報取得失敗')
              }
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
.p-card-footer {
  .p-button {
    margin-right: 10px;
  }
}
</style>
