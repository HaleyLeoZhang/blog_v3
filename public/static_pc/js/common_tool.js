// --------------------------
//     公共工具库 - blog_v3
// --------------------------
(function (window, undefined) {
    function Tool() {}
    /**
     * 字符串计算 crc32 
     * @param string str 等待被hash的字符串
     * @return int
     */
    Tool.prototype.crc32 = function (str) {
        var hash = 0;
        if(str.length == 0) return hash;
        for(i = 0; i < str.length; i++) {
            char = str.charCodeAt(i);
            hash = ((hash << 5) - hash) + char;
            hash = hash & hash; // Convert to 32bit integer
        }
        return hash;
    };
    /**
     * 保留只是两位数
     * @param int num
     * @return string
     */
    Tool.prototype.zero_add = function (num) {
        if(num < 9) {
            return "0" + num;
        } else {
            return "" + num + "";
        }
    };
    /**
     * 获取格式化后的时间
     * - 如： format_time("Y-m-d h:i:s") 输出 2017-12-11 22:46:11
     * @param string str 待格式化的时间
     * @param int timestamp 指定的时间戳，不填，则显示为当前的时间
     * @return string 
     */
    Tool.prototype.format_time = function (str, timestamp) {
        timestamp = timestamp === undefined ? 0 : timestamp;
        timestamp = parseInt(timestamp) * 1000;
        var date = timestamp === 0 ? 　new Date() : new Date(timestamp);
        var Y = date.getFullYear(),
            m = this.add_zero(date.getMonth() + 1),
            d = this.add_zero(date.getDate()),
            h = this.add_zero(date.getHours()),
            i = this.add_zero(date.getMinutes()),
            s = this.add_zero(date.getSeconds());
        str = str.replace("Y", Y);
        str = str.replace("m", m);
        str = str.replace("d", d);
        str = str.replace("h", h);
        str = str.replace("i", i);
        str = str.replace("s", s);
        return str;
    };
    /**
     * 文字数量溢出，剪裁
     * @param string str 文字内容
     * @param int  len 文字数量超出这个数字，则剪裁
     * @return string 
     */
    Tool.prototype.sub_word = function (str, timestamp) {
        if(str.length < len) {
            return str;
        } else {
            return str.substr(0, len - 1) + "...";
        }
    };
    /**
     * 设备类型判断
     * - 电脑、手机
     * @param string str 文字内容
     * @param int  len 文字数量超出这个数字，则剪裁
     * @return bool
     * - true 是移动端，false 不是移动端 
     */
    Tool.prototype.is_mobile = function (str, timestamp) {
        if(navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i)) {
            return true;
        }
        return false;
    };



    window.tool = new Tool();
})(window);