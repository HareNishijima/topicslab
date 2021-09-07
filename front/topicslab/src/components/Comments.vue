<template>
  <div>
    <Comment :comment="c" v-for="c in comments" :key="c.id"/>
  </div>
</template>

<script>
import Comment from '@/components/Comment '
export default {
  name: 'Comments',
  components: { Comment },
  props: {
    comments: Array
  }
}
</script>

<style lang="scss" scoped></style>
