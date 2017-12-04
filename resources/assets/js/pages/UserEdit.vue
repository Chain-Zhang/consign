<template>
    <Form :label-width="80">
        <FormItem label="姓名">
            <Input v-model="user_name" placeholder="请输入"></Input>
        </FormItem>
        <FormItem label="电话">
            <Input v-model="user_phone" placeholder="请输入"></Input>
        </FormItem>
        <FormItem label="角色">
            <Select v-model="user_post_id" style="width:200px">
                <Option v-for="post in postList" :value="post.id" :key="post.id">{{ post.name }}</Option>
            </Select>
        </FormItem>
    </Form>
</template>

<script>
    export default{
        props:["name","phone","post_id"],
        data:function(){
            return {
                user_name:this.name,
                user_phone:this.phone,
                postList:[],
                user_post_id: ''
            }
        },
        watch:{
            name:function (val) {
                this.user_name = val
            },
            user_name:function (val) {
                this.$emit("user_name_changed", val)
            },
            phone:function (val) {
                this.user_phone = val
            },
            user_phone:function (val) {
                this.$emit("user_phone_changed", val)
            },
            post_id:function (val) {
                this.user_post_id = val;
            },
            user_post_id:function (val) {
                this.$emit("user_post_id_changed",val)
            }
        },
        mounted:function () {
            axios.get('/admin/get_posts')
                    .then(response => {
                        this.postList = response.data;
            }).catch (err => {
                console.log(err);
            })
        }
    }
</script>