<template>
    <Form :model="formItem" :label-width="120" ref="formItem" :rules="ruleValidate">
        <Row>
            <Col span="12">
                <FormItem label="车型" prop="car_model">
                    <Input v-model="formItem.car_model" placeholder="请输入"></Input>
                </FormItem>
            </Col>
            <Col span="12">
                <FormItem label="车架号" prop="vin_no">
                    <Input v-model="formItem.vin_no" placeholder="请输入"></Input>
                </FormItem>
            </Col>
        </Row>

        <Row>
            <Col span="12">
                <FormItem label="出车方" prop="owner">
                    <Input v-model="formItem.owner" placeholder="请输入"></Input>
                </FormItem>
            </Col>
            <Col span="12">
                <FormItem label="出车方联系电话" prop="owner_phone">
                    <Input v-model="formItem.owner_phone" placeholder="请输入"></Input>
                </FormItem>
            </Col>
        </Row>

        <Row>
            <Col span="12">
                <FormItem label="始发地" prop="from">
                    <Input v-model="formItem.from" placeholder="请输入"></Input>
                </FormItem>
            </Col>
            <Col span="12">
                <FormItem label="目的地" prop="to">
                    <Input v-model="formItem.to" placeholder="请输入"></Input>
                </FormItem>
            </Col>
        </Row>

        <Row>
            <Col span="12">
            <FormItem label="接车人称呼" prop="sendee_name">
                <Input v-model="formItem.sendee_name" placeholder="请输入"></Input>
            </FormItem>
            </Col>
            <Col span="12">
            <FormItem label="接车人电话" prop="sendee_phone">
                <Input v-model="formItem.sendee_phone" placeholder="请输入"></Input>
            </FormItem>
            </Col>
        </Row>

        <Row>
            <Col span="12">
            <FormItem label="总收费" prop="charge">
                <Input v-model="formItem.charge" placeholder="请输入"></Input>
            </FormItem>
            </Col>
        </Row>

        <Row>
            <Col span="12">
            <FormItem label="付款方式" prop="payment_method">
                <Select v-model="formItem.payment_method" placeholder="请选择">
                    <Option value="1">现付</Option>
                    <Option value="2">到付</Option>
                </Select>
            </FormItem>
            </Col>
            <Col span="12">
            <FormItem label="付款状态" prop="payment_status">
                <Select v-model="formItem.payment_status" placeholder="请选择">
                    <Option value="0">未付款</Option>
                    <Option value="1">已付款</Option>
                </Select>
            </FormItem>
            </Col>
        </Row>

        <Row>
            <Col span="12">
            <FormItem label="大板费用">
                <Input v-model="formItem.st_charge" placeholder="请输入"></Input>
            </FormItem>
            </Col>
            <Col span="12">
            <FormItem label="小板费用">
                <Input v-model="formItem.lt_charge" placeholder="请输入"></Input>
            </FormItem>
            </Col>
        </Row>

        <Row>
            <Col span="12">
            <FormItem label="是否中转">
                <i-switch v-model="formItem.is_transfer" @on-change="change" disabled></i-switch>
            </FormItem>
            </Col>
        </Row>


        <Row>
            <Col span="12">
            <FormItem label="业务员" prop="salesman">
                <Select v-model="formItem.salesman" placeholder="请选择">
                    <Option v-for="user in users" :value="user.id" :key="user.id">{{user.id}}-{{user.name }}</Option>
                </Select>
            </FormItem>
            </Col>
        </Row>

        <FormItem>
            <Button type="primary" @click="handleSubmit('formItem')">提交</Button>
        </FormItem>
    </Form>
</template>

<script>
    export default {
        data:function () {
            return{
                formItem:{
                    car_model:'',
                    vin_no:'',
                    owner:'',
                    owner_phone:'',
                    from:'',
                    to:'',
                    charge:0,
                    st_charge:0,
                    lt_charge:0,
                    payment_method:'',
                    payment_status:'',
                    salesman:'',
                    is_transfer : false,
                    sendee_name:'',
                    sendee_phone:''
                },
                ruleValidate: {
                    car_model: [
                        {required: true, message: '车型不能为空', trigger: 'blur'}
                    ],
                    vin_no:[
                        {required:true, message:'车架号不能为空',trgger:'blur'}
                    ],
                    owner:[
                        {required:true, message:'出车方不能为空',trgger:'blur'}
                    ],
                    owner_phone:[
                        {required:true, message:'出车方联系电话不能为空',trgger:'blur'}
                    ],
                    from:[
                        {required:true, message:'始发地不能为空',trgger:'blur'}
                    ],
                    to:[
                        {required:true, message:'目的地不能为空',trgger:'blur'}
                    ],
                    charge:[
                        {required:true, message:'总收费不能为空',trgger:'blur'}
                    ],
                    payment_method:[
                        {required:true, message:'付款方式不能为空',trgger:'blur'}
                    ],
                    payment_status:[
                        {required:true, message:'付款状态不能为空',trgger:'blur'}
                    ],
                    salesman:[
//                        {required:true, message:'业务员不能为空',trgger:'blur'}
                    ],
                    sendee_name:[
                        {required:true, message:'接车人称呼必须输入', trgger:'blur'}
                    ],
                    sendee_phone:[
                        {required:true, message:'接车人电话必须输入', trgger:'blur'}
                    ],
                },
                users:[]
            }
        },
        methods:{
            handleSubmit (name) {
//                console.log(this.$regs[name]);
                this.$refs[name].validate(valid => {
                    if (valid) {
                        axios.post('/admin/transport_add',{
                            car_model:this.formItem.car_model,
                            vin_no:this.formItem.vin_no,
                            owner:this.formItem.owner,
                            owner_phone:this.formItem.owner_phone,
                            from:this.formItem.from,
                            to:this.formItem.to,
                            charge:this.formItem.charge,
                            st_charge:this.formItem.st_charge,
                            lt_charge:this.formItem.lt_charge,
                            payment_method:this.formItem.payment_method,
                            payment_status:this.formItem.payment_status,
                            salesman_id:this.formItem.salesman,
                            is_transfer:this.formItem.is_transfer,
                            sendee_name : this.formItem.sendee_name,
                            sendee_phone : this.formItem.sendee_phone
                        }).then(response => {
                            if(response.data.status == 0){
                            this.$Message.info(response.data.message);
                            this.$router.push({path:'/transport-list'});
                        }
                        else{
                                this.$Message.error(response.data.message);
                            }

                        })
                        .catch (err => {
                                console.log(err);
                            this.$Message.error("err");
                        });
                    } else {
                        this.$Message.error('表单验证失败!');
                    }
                })
            },
            change (status) {
                this.formItem.is_stransfer = status;
            }
        },
        mounted:function () {
            axios.get('/admin/getEmplyee').then(response =>{
                this.users = response.data;
                console.log(this.users)
            }).catch (err => {
                console.log(err);
            })
        }
    }
</script>