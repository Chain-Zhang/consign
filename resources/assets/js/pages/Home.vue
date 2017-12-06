<template>
    <div>
        <h2>
            成都中伟轿车托运
        </h2>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                switch1: false
            }
        },
        methods: {
            change (status) {
                this.$Message.info('开关状态：' + status);
            }
        }
    }
</script>