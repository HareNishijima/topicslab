<template>
  <div>
    <Modal :message="this.errMessage" v-show="showContent" @close="closeModal" />
    <Loading v-show="loading_status" />
    <Card v-for="topic in topics" :key="topic.id" v-show="!loading_status">
        <template #content>
          <span class="topic-date">投稿日：{{moment(topic.created_at)}}</span>
          <h2>
            <router-link :to="`/topic/${topic.id}`">
              {{topic.title}}
            </router-link>
          </h2>
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
  name: 'AllTopics',
  components: {
    Modal,
    Loading
  },
  data () {
    return {
      topics: [],
      loading_status: true,
      errMessage: 'Topicsの取得に失敗しました．',
      showContent: false
    }
  },
  componemts: {
    Modal
  },
  mounted () {
    this.getAllTopics()
  },
  methods: {
    moment: function (date) {
      return moment(date).format('YYYY/MM/DD HH:mm:SS')
    },
    getAllTopics () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.get('/api/topics')
            .then((res) => {
              if (res.status === 200) {
                this.topics.splice(0)
                this.topics.push(...res.data)
                this.loading_status = false
              } else {
                console.log('取得失敗')
                this.openModal()
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
.p-card.p-component {
  margin-bottom: 20px;
}
.p-card-content {
  .topic-date {
    font-size: 80%;
  }
}
</style>
