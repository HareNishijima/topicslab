<template>
  <div>
    <Card>
      <template #content>
        <div class="move">
          <div class="date"></div>
          <div class="title"></div>
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
  position: absolute;
}
.move {
  position: relative;
  display: block;
  width: 100%;
  height: 100%;
  background: #fff;
  overflow: hidden;
  z-index: 50;
}
@keyframes skeleton-animation {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
}
.move::before {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 100;
  content: "";
  display: block;
  height: 100%;
  width: 100%;
  background: linear-gradient(
    90deg,
    transparent,
    rgba(255, 255, 255, 0.2),
    transparent
  );
  animation: skeleton-animation 1.2s linear infinite;
}
.date {
  width:100%;
  height: 20px;
  background-color: #E2E2E2;
  border-radius: 5px;
}
.title {
  margin-top: 25px;
  width:100%;
  height: 48px;
  background-color: #E2E2E2;
  border-radius: 5px;
}
</style>
