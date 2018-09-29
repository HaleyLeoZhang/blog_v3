export default class tools {

  /**
   * 超出长度则省略
   * @param string str 字符串
   * @param int len 字符串长度限制
   * @return string
   */
  static subStr(str, len) {
    if(str.length > len) {
      return str.substring(0, len) + '...';
    } else {
      return str;
    }
  }

  /**
   * 如果要把个位数变成两位数的字符串
   * @param int|string 一个数字或者带数字的字符串
   * @return string
   */
  static needZero(d) {
    d = parseInt(d);
    if(isNaN(d)) {
      d = 0;
    }
    if(d < 10) {
      return "0" + d;
    }
    return "" + d;
  }


  /**
   * 计算发布时间，距离现在有多久了
   * @param string 一个时间字符串  如，`2018-10-25 18:25:30` 或 `2018-10-25`
   * @return string
   */
  static timeCompute(str) {
    if(!str) return '';
    let date = new Date(str);
    let time = new Date().getTime() - date.getTime(); //现在的时间-传入的时间 = 相差的时间（单位 = 毫秒）
    if(time < 0) {
      return '';
    } else if((time / 1000 < 30)) {
      return '刚刚';
    } else if(time / 1000 < 60) {
      return parseInt((time / 1000)) + '秒前';
    } else if((time / 60000) < 60) {
      return parseInt((time / 60000)) + '分钟前';
    } else if((time / 3600000) < 24) {
      return parseInt(time / 3600000) + '小时前';
    } else if((time / 86400000) < 31) {
      return parseInt(time / 86400000) + '天前';
    } else if((time / 2592000000) < 12) {
      return parseInt(time / 2592000000) + '月前';
    } else {
      return parseInt(time / 31536000000) + '年前';
    }
  }

  /**
   * 获取格式化后的时间
   *    如： format_time("Y-m-d h:i:s") 输出 2017-12-11 22:46:11
   * @param string str 待格式化的时间
   * @param int timestamp 时间戳， 0为不处理
   * @return string
   */
  static format_time(str, timestamp = 0) {
    const add_zero = num => {
      if(num < 9) {
        return "0" + num;
      } else {
        return "" + num + "";
      }
    }
    timestamp = parseInt(timestamp) * 1000;
    let date = timestamp === 0 ? 　new Date() : new Date(timestamp);
    let Y = date.getFullYear(),
      m = add_zero(date.getMonth() + 1),
      d = add_zero(date.getDate()),
      h = add_zero(date.getHours()),
      i = add_zero(date.getMinutes()),
      s = add_zero(date.getSeconds());
    str = str.replace("Y", Y);
    str = str.replace("m", m);
    str = str.replace("d", d);
    str = str.replace("h", h);
    str = str.replace("i", i);
    str = str.replace("s", s);
    return str;
  }

}
