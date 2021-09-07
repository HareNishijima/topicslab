<template>
  <div>
    <Modal :message="this.errMessage" v-show="showContent" @close="closeModal" />
    <Card>
      <template #title>
        Login
      </template>
      <template #content>
        <div class="fields">
          <div class="p-field">
            <label for="email">メールアドレス</label>
            <InputText id="email" type="email" v-model="email" />
          </div>
          <div class="p-field">
            <label for="password">パスワード</label>
            <InputText id="password" type="password" v-model="password" />
          </div>
        </div>
        <div class="p-field">
          <Button icon="pi pi-check" label="Login" v-on:click="login" />
        </div>
      </template>
    </Card>
  </div>
</template>

<script>
import axios from '@/supports/axios'
import Modal from '@/components/Modal'

export default {
  name: 'Login',
  components: { Modal },
  data () {
    return {
      email: '',
      password: '',
      error: false,
      errMessage: 'ログインに失敗しました。',
      showContent: false
    }
  },
  methods: {
    login () {
      axios.get('/sanctum/csrf-cookie')
        .then(() => {
          axios.post('/api/login', {
            email: this.email,
            password: this.password
          })
            .then((res) => {
              if (res.status === 200) {
                console.log('ログイン成功')
                localStorage.setItem('authenticated', 'true')
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

<style lang="scss" scoped>
.p-card-content {
  .fields {
    text-align: center;
  }

  .p-field {
    display: block;

    label {
      display: inline-block;
      width: 10em;
      margin-bottom: 10px;
    }

    .p-button {
      margin-top: 20px;
      display: block;
      width: 100%;
    }
  }
}
</style>
