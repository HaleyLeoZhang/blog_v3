<template>
  <div class="notfound">
    <div class="error"></div>
    <div class="msg">页面不存在！</div>
  </div>
</template>
<style lang="scss" scoped>

.error {
  width: 200px;
  height: 200px;
  margin: 30% auto 0px auto;
  background: url(../assets/img/error.png) no-repeat;
  background-size: 100%;
  background-position: -10px center;
}

.msg {
  text-align: center;
  color: #555;
  margin-bottom: 20px;
}

</style>
