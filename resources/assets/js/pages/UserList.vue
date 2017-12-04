<template>
    <div>
        <Button type="primary" @click="modal1 = true">新增</Button>
        <Modal
                v-model="modal1"
                title="新增职工"
                @on-ok="ok"
                @on-cancel="cancel">
            <user-edit @user_name_changed="get_user_name"
                       @user_phone_changed="get_user_phone"
                       @user_post_id_changed="get_user_post_id">
            </user-edit>
        </Modal>
        <Table stripe :columns="columns1" :data="data1"></Table>
    </div>
</template>

<script>
    import UserEdit from './UserEdit.vue';
    export default {
        components:{UserEdit},
        data : function() {
            return {
                modal1: false,
                columns1: [
                    {
                        title: '姓名',
                        key: 'name'
                    },
                    {
                        title:'角色',
                        key:'role',
                    },
                    {
                        title: '电话',
                        key: 'phone'
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 150,
                        align: 'center',
                        render: (h, params) => {
                            return h('div', [
                                h('Button', {
                                    props: {
                                        type: 'primary',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.show(params.index)
                                        }
                                    }
                                }, '查看'),
                                h('Button', {
                                    props: {
                                        type: 'error',
                                        size: 'small'
                                    },
                                    on: {
                                        click: () => {
                                            this.remove(params.index)
                                        }
                                    }
                                }, '删除')
                            ]);
                        }
                    }
                ],
                data1: [],
                user_name:'',
                user_phone:'',
                post_id:'',
            }
        },
        mounted:function () {
            this.initialUsers();
        },
        methods:{
            initialUsers:function () {
                axios.get('/admin/users')
                    .then(response => {
                        this.data1 = response.data;
                    })
                    .catch (err => {
                        console.log(err);
                    })
            },

            ok:function () {
                axios.post('/admin/user_add',{
                    name:this.user_name,
                    phone:this.user_phone,
                    post_id:this.post_id
                }).then(response => {
                    if(response.data.status == 0){
                    this.initialUsers();
                    this.$Message.info(response.data.message);
                }
                else{
                    this.$Message.error(response.data.message);
                }

            })
                .catch (err => {
                    console.log(err);
                this.$Message.error("err");
            });
            },

            cancel:function () {

            },
            get_user_name:function (val) {
                this.user_name = val
            },
            get_user_phone:function (val) {
                this.user_phone = val
            },
            get_user_post_id:function (val) {
                this.post_id = val
            },
            show (index) {
                this.$Modal.info({
                    title: '用户信息',
                    content: `姓名：${this.data1[index].name}<br>id：${this.data1[index].id}`
                })
            },
        }
    }
</script>