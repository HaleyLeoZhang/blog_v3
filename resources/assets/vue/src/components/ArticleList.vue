<template>
  <div class="ho_ul">
    <div v-for="item in listInfo" class="ho_li">
      <router-link :to="'/article/'+item.id">
        <h5>{{item.title}}</h5>
      </router-link>
      <router-link :to="'/article/'+item.id">
        <img :src="item.cover_url" alt="" />
      </router-link>
      <div class="others" yth-descript="[都要带图标的]发布时间、阅读量、评论数、所属分类">
        <span class="others_block" title="发布时间">
            <i class="fa fa-clock-o" aria-hidden="true"></i>
            {{item.created_at}}            <font></font>
          </span>
        <span class="others_block _cate" title="所属分类">
            <i class="fa fa-folder-open-o"></i>
            <router-link :to="`/category/`+item.cate_id">
              {{item.cate_name}}
            </router-link>
            <font></font>
          </span>
        <span class="others_block" title="浏览量">
            <i class="fa fa-eye" aria-hidden="true"></i>
            {{item.statistic}}         
          </span>
      </div>
      <div class="descript">
        <p>
          {{item.descript}}
        </p>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
import api from '@/fetch';

export default {
  // 基础类型检测 String Number Boolean Function Object Array
  props: {
    listInfo
: Array, // 也可以设置为多种类型  [String, Number]
  },
  computed: {},
  methods: {

  }
}

</script>
<style scoped lang="scss">
@import '../assets/css/function';
.ho_li {
  margin-top: px2rem(70px);
  padding-bottom: px2rem(35px);
  margin-bottom: px2rem(70px);
  border-bottom: px2rem(1px) dashed #DAD2D2;
  &:last-child {
    border-bottom: none;
  }
  a {
    font-family: Helvetica Neue, Helvetica, PingFang SC, \5FAE\8F6F\96C5\9ED1, Tahoma, Arial, sans-serif;
    text-decoration: none;
  }
  $this_h5_h: px2rem(90px);
  h5 {
    letter-spacing: 0.1em;
    text-align: center;
    font-size: px2rem(80px);
    line-height: $this_h5_h;
    height: $this_h5_h;
    color: #2b2b2b;
  }
  img {
    width: 100%;
    height: auto;
  }
  .others {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    margin-top: px2rem(30px);
    margin-bottom: px2rem(30px);
    .others_block {
      font-size: px2rem(70px);
    }
    ._cate {
      color: #333;
      a {
        text-decoration: none;
        color: #333;
      }
    }
  }
  .descript {
    p {
      font-size: $this_h5_h*0.8;
      line-height: $this_h5_h *1.15;
      text-indent: 2em;
      letter-spacing: 0.1em;
      &:after {
        content: '...';
      }
    }
  }
}

</style>
