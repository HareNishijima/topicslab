
<template>
 <div>
  <Modal :message="this.errMessage" v-show="showContent" @close="closeModal" />
  <Card>
    <template #title>
      新しいTopicを投稿しよう
    </template>
    <template #content>
      <div class="p-field">
        <label for="title">Topicタイトル</label>
        <InputText v-model="title" id="title" type="text" aria-describedby="title-help" />
        <small id="title-help">タイトルを入力してください。</small>
        <p><span>{{messages.title}}</span></p>
        <!-- ↑元々は<p>{{messages.title}}</p>-->
      </div>
      <div class="p-field">
        <label for="title">Topic内容</label>
        <Textarea v-model="body" :autoResize="true" rows="10" />
        <p><span>{{messages.body}}</span></p>
      </div>
      <div class="p-field">
        <Button icon="pi pi-check" label="保存" v-on:click="submit" />
        <p>{{messages.submit}}</p>
      </div>
    </template>
  </Card>
 </div>
</template>

<script>
import axios from '@/supports/axios'
import Modal from '@/components/Modal'

export default {
  name: 'NewTopic',
  components: {
    Modal
  },
  data () {
    return {
      title: '',
      body: '',
      messages: {
        submit: '',
        title: '',
        body: ''
      },
      errMessage: '送信に失敗しました。',
      showContent: false
    }
  },
  mounted () {
    if (localStorage.getItem('authenticated') !== 'true') {
      this.$router.push('login')
    }
  },
  methods: {
    submit () {
      const title = this.title.trim()
      if (!title) {
        this.messages.title = '未記入(空白のみ)は送信できません。'
      }
      const body = this.body.trim()
      if (!body) {
        this.messages.body = '未記入(空白のみ)は送信できません。'
      }

      if (!title || !body) return

      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/topic', {
            title: title,
            body: body
          })
            .then((res) => {
              if (res.status === 201) {
                console.log('トピック新規作成')
                console.log(res)
              } else {
                this.openModal()
              }
            })
            .catch((err) => {
              console.log(err)
              this.openModal()
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

<style scoped lang="scss">
.p-field * {
  display: block;
  width: 100%;
  span{
    color: #d00;
  }
}
</style>
