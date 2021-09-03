<template>
  <div>
    <Card>
        loading
    </Card>
  </div>
</template>

<script>
import { defineComponent } from '@vue/composition-api'

export default {
    name: 'loading',
    data() {
        return{
            info: null,
            loading: true,
            errored: false
        }
    },
}
</script>
