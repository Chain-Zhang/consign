<template>
    <div>
        <Button type="primary" @click="modal1 = true">新增</Button>
        <Modal
                v-model="modal1"
                title="新增职务"
                @on-ok="ok"
                @on-cancel="cancel">
            <PostAdd @post_name_changed="get_post_name" @post_orderby_changed="get_post_orderby"></PostAdd>
        </Modal>
        <Table stripe :columns="columns1" :data="data1"></Table>
    </div>
</template>
<script>
    import { mapState } from 'vuex'
    import PostAdd from './PostAdd.vue'
    export default {
        components:{PostAdd},
        data () {
            return {
                modal1: false,
                columns1: [
                    {
                        title: '职务名称',
                        key: 'name'
                    },
                    {
                        title: '职务级别',
                        key: 'orderby'
                    },
                ],
                data1: [],
                post_name:"zzc",
                post_orderby:"1"
            }
        },
        mounted:function () {
            this.init();
        },
        computed:{
        },
        methods: {
            init(){
                axios.get('/admin/posts')
                        .then(response => {
                    this.data1 = response.data;
            })
            .catch(error => {
                    console.log(error);
            });
            },
            ok () {
                axios.post('/admin/post_add',{
                    name:this.post_name,
                    orderby:this.post_orderby
                }).then(response => {
                    if(response.data.status == 0){
                        this.init();
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
            cancel () {
                this.$Message.info('点击了取消');
            },
            get_post_name:function (val) {
                this.post_name = val
            },
            get_post_orderby:function (val) {
                this.post_orderby = val
            }
        }
    }
</script>