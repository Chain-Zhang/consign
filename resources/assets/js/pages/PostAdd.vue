<template>
    <Form :label-width="80">
        <FormItem label="职务名称">
            <Input v-model="post_name" placeholder="请输入"></Input>
        </FormItem>
        <FormItem label="职务级别">
            <Input v-model="post_orderby" placeholder="请输入"></Input>
        </FormItem>
    </Form>
</template>

<script>
    export default {
        props:["name","orderby"],
        data(){
            return {
                post_name:this.name,
                post_orderby:this.orderby
            }
        },
        watch:{
            name:function (val) {
                this.post_name = val
            },
            post_name:function (val) {
                this.$emit("post_name_changed", val)
            },
            orderby:function (val) {
                this.post_orderby = val
            },
            post_orderby:function (val) {
                this.$emit("post_orderby_changed", val)
            }
        }

    }
</script>