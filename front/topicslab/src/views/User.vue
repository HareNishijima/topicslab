<template>
  <div>
    <Loading v-show="loading_status" />
    <Card v-show="!loading_status">
      <template #content>
        {{user.name}}
      </template>
    </Card>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import Loading from '@/components/Loading'

export default {
  name: 'user',
  components: {
    Loading
  },
  data () {
    return {
      id: null,
      user: {},
      topics: {},
      comments: {},
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
                this.loading_status = false
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
    }
  }
}
</script>
