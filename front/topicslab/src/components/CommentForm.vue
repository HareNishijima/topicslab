<template>
  <div>
    <Modal :message="this.errMessage" v-show="showContent" @close="closeModal" />
    <Card>
      <template #content>
        <div class="p-field">
          <Textarea v-model="comment" :autoResize="true" rows="5" />
          <p>{{message}}</p>
        </div>
        <div class="p-field">
          <Button icon="pi pi-check" label="コメントする" v-on:click="submit" />
        </div>
      </template>
    </Card>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import Modal from '@/components/Modal'

export default {
  name: 'CommentForm',
  components: {
    Modal
  },
  props: {
    topicId: Number
  },
  data () {
    return {
      comment: '',
      message: '',
      errMessage: '送信に失敗しました。',
      showContent: false
    }
  },
  methods: {
    submit () {
      const comment = this.comment.trim()
      if (!comment) {
        this.message = '未記入(空白のみ)は送信できません。'
        return
      }

      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/comment', {
            topicId: this.topicId,
            body: comment
          })
            .then((res) => {
              if (res.status === 201) {
                this.comment = ''
                this.$emit('sentComment', res.data)
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
    receiveComment (comment) {
      this.comments.push(comment)
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

<style scoped>
.p-card.p-component {
  margin-top:  20px;
}
.p-field * {
  display: block;
  width: 100%;
}
</style>
