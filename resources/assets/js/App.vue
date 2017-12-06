<style scoped>
    .layout{
        border: 1px solid #d7dde4;
        background: #f5f7f9;
    }
    .layout-logo{
        width: 100px;
        height: 30px;
        background: #5b6270;
        border-radius: 3px;
        float: left;
        position: relative;
        top: 15px;
        left: 20px;
    }
    .layout-nav{
        width: 420px;
        margin: 0 auto;
    }
    .layout-assistant{
        width: 300px;
        margin: 0 auto;
        height: inherit;
    }
    .layout-breadcrumb{
        padding: 10px 15px 0;
    }
    .layout-content{
        min-height: 200px;
        margin: 15px;
        /*overflow: hidden;*/
        background: #fff;
        border-radius: 4px;
    }
    .layout-content-main{
        padding: 10px;
    }
    .layout-copy{
        text-align: center;
        padding: 10px 0 20px;
        color: #9ea7b4;
    }
</style>
<template>
    <div class="layout">
        <div class="layout-content">
            <Row>
                <Col span="5">
                <Menu active-name="1" width="auto" :open-names="['1']">
                    <MenuItem name="1">
                        <Icon type="home"></Icon>
                        <router-link to="/" class="layout-text" tag="span">主页</router-link>
                    </MenuItem>

                    <Submenu name="2">
                        <template slot="title">
                            <Icon type="android-car"></Icon>
                            轿运管理
                        </template>
                        <MenuItem name="2-1" v-if="auth<5">
                            <router-link to="/transport-list" class="layout-text" tag="span">运输列表</router-link>
                        </MenuItem>
                        <MenuItem name="2-2">
                            <router-link to="/transport/add" class="layout-text" tag="span">新增运输</router-link>
                        </MenuItem>
                    </Submenu>
                    <MenuItem name="3" v-if="auth<1">
                        <Icon type="social-buffer"></Icon>
                        <router-link to="/post" class="layout-text" tag="span">职务管理</router-link>
                    </MenuItem>
                    <Submenu name="4" v-if="auth<2">
                        <template slot="title">
                            <Icon type="ios-people"></Icon>
                            员工管理
                        </template>
                        <MenuItem name="4-1">
                            <router-link to="/user-list" class="layout-text" tag="span">员工列表</router-link>
                        </MenuItem>
                    </Submenu>
                    <Submenu name="5">
                        <template slot="title">
                            <Icon type="person"></Icon>
                            个人中心
                        </template>
                        <MenuItem name="5-1">
                            <router-link to="/reset-password" class="layout-text" tag="span">修改密码</router-link>
                        </MenuItem>
                    </Submenu>
                </Menu>
                </Col>
                <Col span="19">
                <div class="layout-content-main">
                    <router-view></router-view>
                </div>
                </Col>
            </Row>
        </div>
        <div class="layout-copy">
            2017 &copy; 中伟轿运
        </div>
    </div>
</template>

<script>
    export default {
        data:function () {
            return{
                auth:99
            }
        },
        mounted:function () {
             axios.get('/admin/get_permission')
                     .then(response => {
                        this.auth = response.data.orderby;
                        console.log(response.data)
             }).catch(err => {
                 console.log(err);
            })
        }
    }
</script>