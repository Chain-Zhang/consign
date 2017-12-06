/**
 * Created by chain on 2017/10/11.
 */

import Vue from 'vue'
import Router from 'vue-router'
import UserList from '../pages/UserList.vue'
import PostList from '../pages/PostList.vue'
import Home from '../pages/Home.vue'
import TransportAdd from '../pages/TransportAdd.vue'
import TransportList from '../pages/TransportList.vue'
import ResetPassword from '../pages/ResetPassword.vue'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path:'/',
            name:'home',
            component:Home
        },
        {
            path:'/post',
            name:'post',
            component:PostList
        },
        {
            path:'/user-list',
            name:'user-list',
            component:UserList
        },
        {
            path:'/reset-password',
            name:'reset-password',
            component:ResetPassword
        },
        {
            path:'/transport-list',
            name:'transport-list',
            component:TransportList
        },
        {
            path:'/transport/add',
            name:'transport-add',
            component:TransportAdd
        }
    ]
})