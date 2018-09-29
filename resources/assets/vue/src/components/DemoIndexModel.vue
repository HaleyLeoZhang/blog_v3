<template>
    <div>
        <div>
            <el-input placeholder="请输入名称" v-model="siteName">
                <template slot="prepend">Http://</template>
                <template slot="append">.top</template>
            </el-input>
        </div>
        <div style="margin-top: 15px;">
            <el-input :placeholder="getsiteNameModel" v-model="changeClassList" class="input-with-select">
                <el-select v-model="select" slot="prepend" placeholder="请选择">
                    <el-option label="餐厅名" value="1"></el-option>
                    <el-option label="订单号" value="2"></el-option>
                    <el-option label="用户电话" value="3"></el-option>
                </el-select>
                <el-button slot="append" icon="el-icon-search"></el-button>
            </el-input>
        </div>
        <!-- 循环渲染 -->
        <ol>
            <li :class="getClassList" v-for="site in sites">
                {{ site.name }}
            </li>
        </ol>
        <!-- 复选框 -->
        <el-checkbox-group v-model="checkList">
            <el-checkbox label="复选框 A"></el-checkbox>
            <el-checkbox label="复选框 B"></el-checkbox>
            <el-checkbox label="复选框 C"></el-checkbox>
            <el-checkbox label="禁用" disabled></el-checkbox>
            <el-checkbox label="选中且禁用" disabled></el-checkbox>
        </el-checkbox-group>
    </div>
</template>
<script>
export default {
    data() {
        return {
            input3: '',
            siteName: '',
            changeClassList: '',
            select: '',
            sites: [
                { name: 'Runoob' },
                { name: 'Google' },
                { name: 'Taobao' }
            ],
            checkList: ['选中且禁用', '复选框 A'],
        }
    },
    computed: {
        getsiteNameModel() {
            return `请输入${this.siteName}.top的站长信息`;
        },
        // 返回的 class 可以是 数组->里面是样式对象 ， 可以是 样式对象 ，如  :class="{"classA":true , "classB":false}" 变成 class="classA"
        // 同理 css 也可以 以 数组、对象方式得到，这点类似 react-native
        getClassList() {
            return {
                "classA": true,
                "classB": this.changeClassList != '' ? true : false,
            };
        },
    },
}
</script>
<style>
.el-select .el-input {
    width: 130px;
}

.input-with-select .el-input-group__prepend {
    background-color: #fff;
}
</style>