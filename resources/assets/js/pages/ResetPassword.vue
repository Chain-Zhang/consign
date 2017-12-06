<template>
    <Form ref="formCustom" :model="formCustom" :rules="ruleCustom" :label-width="80">
        <FormItem label="旧密码" prop="oldpasswd">
            <Input type="password" v-model="formCustom.oldpasswd"></Input>
        </FormItem>
        <FormItem label="新密码" prop="passwd">
            <Input type="password" v-model="formCustom.passwd"></Input>
        </FormItem>
        <FormItem label="确认密码" prop="passwdCheck">
            <Input type="password" v-model="formCustom.passwdCheck"></Input>
        </FormItem>
        <FormItem>
            <Button type="primary" @click="handleSubmit('formCustom')">修改</Button>
        </FormItem>
    </Form>
</template>

<script>
    export default {
        data () {
            const validateOldPass = (rule, value, callback) => {
                if(value === ''){
                    callback(new Error('请输入旧密码'))
                }
                else {
                    callback();
                }
            };
            const validatePass = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请输入你的新密码'));
                } else if(value === this.formCustom.oldpasswd){
                    callback(new Error('新密码不能与旧密码一样'));
                }
                else {
                    if (this.formCustom.passwdCheck !== '') {
                        // 对第二个密码框单独验证
                        this.$refs.formCustom.validateField('passwdCheck');
                    }
                    callback();
                }
            };
            const validatePassCheck = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请再次输入你的密码'));
                } else if (value !== this.formCustom.passwd) {
                    callback(new Error('两次输入的密码不一样'));
                } else {
                    callback();
                }
            };

            return {
                formCustom: {
                    passwd: '',
                    passwdCheck: '',
                    oldpasswd: ''
                },
                ruleCustom: {
                    oldpasswd:[
                        { validator: validateOldPass, trigger: 'blur' }
                    ],
                    passwd: [
                        { validator: validatePass, trigger: 'blur' }
                    ],
                    passwdCheck: [
                        { validator: validatePassCheck, trigger: 'blur' }
                    ]
                }
            }
        },
        methods:{
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        axios.post('/admin/reset_password',
                                {
                                    oldpasswd:this.formCustom.oldpasswd,
                                    passwd:this.formCustom.passwd
                                }).then(response => {
                            if(response.data.status == 0){
                                this.$refs[name].resetFields();
                                this.$Message.info(response.data.message);
                            }
                            else{
                                this.$Message.error(response.data.message);
                            }
                        })
                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            },
        }
    }
</script>
