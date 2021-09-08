<template>
  <div>
    <Card>
      <template #title>
        会員情報
      </template>
      <template #content>
        {{user.name}}
        <div class="p-field">
          自己紹介文
        <Textarea  v-model="introduction" :autoResize="true" rows="6" />
        <Button icon="pi" iconPos="center" class="p-button-rounded p-button-help p-button-outlined p-button-sm" label="保存する" v-on:click="submit" />
        </div>
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

export default {
  name: 'Userself',
  data () {
    return {
      user: {},
      introduction: ''
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
    // submit () {
    //   const comment = this.comment.trim()
    //   if (!comment) {
    //     this.message = '未記入(空白のみ)は送信できません。'
    //     return
    //   }
    // },
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
              if (res.status === 200) {
                this.user = res.data
              } else {
                console.log('取得失敗')
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
@mixin button-center(){display: block;
  margin: 0 auto;
}
Textarea{
  width: 100%;
  margin-bottom: 15px;
}
.p-field{
  margin-top: 15px;
  Button{
    @include button-center;
  }
}
.p-card-footer {
  .p-button {
    margin-right: 10px;
  }
}
</style>
