<template>
  <div>
    <Card>
      <template #content>
          <div class="card-detail">
            <h3 class="title -loading"></h3>
            <p class="description -loading"></p>
          </div>
      </template>
    </Card>
  </div>
</template>

<script>
export default {
  name: 'loading',
  data () {
    return {
      info: null,
      loading: true,
      errored: false
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
.card-detail {
  padding: 2px 16px;

  > .title {
    letter-spacing: 3px;
  }
  > .description {
    letter-spacing: 1px;
  }
  &::after {
    display: block;
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    transform: translateX(-100%);
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .2), transparent);
    animation: loading 1.5s infinite;
  }
}
@keyframes loading {
  100% {
    transform: translateX(100%);
  }
}
.-loading {
  position: relative;
  background-color: #E2E2E2;
  border-radius: 5px;
}
.title.-loading {
  height: 1rem;
}
.description.-loading {
  height: 70px;
}
</style>
