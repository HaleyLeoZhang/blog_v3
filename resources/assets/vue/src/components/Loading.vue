<template>
  <div v-show="flag" class="spinner">
    <div class="bounce1"></div>
    <div class="bounce2"></div>
    <div class="bounce3"></div>
  </div>
</template>
<script>
export default {
  props: {
    flag: Boolean
  }
}

</script>
<style lang="scss" scoped>
@import '../assets/css/function';


.spinner {
  margin: px2rem(50px) auto px2rem(50px);
  width: px2rem(600px);
  text-align: center;
  $spinner_div_h: px2rem(120px);
  div {
    width: $spinner_div_h;
    height: $spinner_div_h;
    background-color: #67CF22;
    border-radius: 100%;
    display: inline-block;
    animation: bouncedelay 1.4s infinite ease-in-out;
    animation-fill-mode: both;
  }
  .bounce1 {
    animation-delay: -0.32s;
  }
  .bounce1 {
    animation-delay: -0.32s;
  }
  .bounce2 {
    animation-delay: -0.16s;
  }
}


@keyframes bouncedelay {
  0%,
  80%,
  100% {
    transform: scale(0.0);
    -webkit-transform: scale(0.0);
  }
  40% {
    transform: scale(1.0);
    -webkit-transform: scale(1.0);
  }
}

</style>
