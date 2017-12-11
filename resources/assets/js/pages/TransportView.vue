<template>
<Form :model="formItem" :label-width="120">
    <Row>
        <Col span="12">
        <FormItem label="订单编号">
            <Input v-model="formItem.order_id" disabled></Input>
        </FormItem>
        </Col>
        <Col span="12">
        <FormItem label="下单时间">
            <DatePicker :value="formItem.ordered_date" format="yyyy-MM-dd hh:mm" type="date" disabled></DatePicker>
        </FormItem>
        </Col>
    </Row>
    <Row>
        <Col span="12">
        <FormItem label="车型">
            <Input v-model="formItem.car_model" disabled></Input>
        </FormItem>
        </Col>
        <Col span="12">
        <FormItem label="车架号" >
            <Input v-model="formItem.vin_no" disabled></Input>
        </FormItem>
        </Col>
    </Row>

    <Row>
        <Col span="12">
        <FormItem label="出车方" >
            <Input v-model="formItem.owner" disabled></Input>
        </FormItem>
        </Col>
        <Col span="12">
        <FormItem label="出车方联系电话">
            <Input v-model="formItem.owner_phone" disabled></Input>
        </FormItem>
        </Col>
    </Row>

    <Row>
        <Col span="12">
        <FormItem label="始发地">
            <Input v-model="formItem.from" disabled></Input>
        </FormItem>
        </Col>
        <Col span="12">
        <FormItem label="目的地">
            <Input v-model="formItem.to" disabled></Input>
        </FormItem>
        </Col>
    </Row>

    <Row>
        <Col span="12">
        <FormItem label="接车人称呼">
            <Input v-model="formItem.sendee_name" disabled></Input>
        </FormItem>
        </Col>
        <Col span="12">
        <FormItem label="接车人电话">
            <Input v-model="formItem.sendee_phone" disabled></Input>
        </FormItem>
        </Col>
    </Row>

    <Row>

        <FormItem label="总收费">
            <Col span="10">
            <Input v-model="formItem.charge" disabled></Input>
            </Col>
            <Col span="11" offset="1" v-if="permission < 2">
            <Button type="primary" @click="updateCharge">修改</Button>
            </Col>
        </FormItem>

    </Row>

    <Row>
        <Col span="12">
        <FormItem label="付款方式">
            <Input v-model="formItem.payment_method_desc" disabled></Input>
        </FormItem>
        </Col>
    </Row>

    <Row>
        <FormItem label="付款状态">
            <Col span="10">
            <Input v-model="formItem.payment_status_desc" disabled></Input>
            </Col>
            <Col span="11" offset="1" v-if="isPayed">
            <Button type="primary" @click="payment">付款</Button>
            </Col>

        </FormItem>
    </Row>

    <Row>
        <Col span="12">
        <FormItem label="大板费用">
            <Col span="18">
            <Input v-model="formItem.st_charge" disabled></Input>
            </Col>
            <Col span="5" offset="1" v-if="permission < 2">
            <Button type="primary" @click="updateStCharge">修改</Button>
            </Col>
        </FormItem>
        </Col>
        <Col span="12">
        <FormItem label="小板费用">
            <Col span="18">
            <Input v-model="formItem.lt_charge" disabled></Input>
            </Col>
            <Col span="5" offset="1" v-if="permission < 2">
            <Button type="primary" @click="updateLtCharge">修改</Button>
            </Col>
        </FormItem>
        </Col>
    </Row>

    <!--<Row>-->
        <!--<Col span="12">-->
        <!--<FormItem label="是否中转">-->
            <!--<i-switch v-model="formItem.is_transfer" disabled></i-switch>-->
        <!--</FormItem>-->
        <!--</Col>-->
    <!--</Row>-->


    <Row>
        <Col span="12">
        <FormItem label="业务员" >
            <Input v-model="formItem.salesmanName" disabled></Input>
        </FormItem>
        </Col>
    </Row>
</Form>
</template>

<script>
    import { mapState } from 'vuex'
    export default {
        props:["tpid"],
        data:function () {
            return{
                formItem:{},
                updatedCharge:0,
                updatedStCharge:0,
                updatedLtCharge:0
            }
        },
        computed:{
          isPayed:function () {
              if(this.formItem.payment_status == 0){
                  return true;
              }else{
                  return false;
              }
          },
            ...mapState(['permission'])
        },
        methods: {
            payment:function () {
                axios.post('/admin/transport_pay',{id:this.formItem.id})
                        .then(response =>{
                            if(response.data.status == 0){
                                this.refresh(this.formItem.id);
                                this.$Message.info(response.data.message);
                            }
                            else{
                                this.$Message.error(response.data.message);
                            }
                        })
            },
            refresh:function (id) {
                var self = this;
                axios.get('/admin/transport_get?id='+ id)
                        .then(response => {
                    self.formItem = response.data;
                console.log(response.data);
            })
                .catch(error => {
                    console.log(error);
            });
            },
            updateCharge(){
                this.updatedCharge = this.formItem.charge;
                this.$Modal.confirm({
                    render: (h) => {
                        return h('Input', {
                            props: {
                                value: this.updatedCharge,
                                autofocus: true,
                                placeholder: 'Please enter new Charge'
                            },
                            on: {
                                input: (val) => {
                                    this.updatedCharge = val;
                                },

                            },

                        })
                    },
                    onOk:() => {
                        axios.post('/admin/update_charge',{id:this.formItem.id, new_charge:this.updatedCharge})
                                .then(response =>{
                                    if(response.data.status == 0){
                                        this.refresh(this.formItem.id);
                                        this.$Message.info(response.data.message);
                                    }
                                    else{
                                        this.$Message.error(response.data.message);
                                    }
                                })
                    },
                })
            },
            updateStCharge(){
                this.updatedStCharge = this.formItem.st_charge;
                this.$Modal.confirm({
                    render: (h) => {
                        return h('Input', {
                            props: {
                                value: this.updatedStCharge,
                                autofocus: true,
                                placeholder: 'Please enter new Charge'
                            },
                            on: {
                                input: (val) => {
                                    this.updatedStCharge = val;
                                },

                            },

                        })
                    },
                    onOk:() => {
                        axios.post('/admin/update_st_charge',{id:this.formItem.id, new_charge:this.updatedStCharge})
                                .then(response =>{
                                    if(response.data.status == 0){
                                        this.refresh(this.formItem.id);
                                        this.$Message.info(response.data.message);
                                    }
                                    else{
                                        this.$Message.error(response.data.message);
                                    }
                                })
                    },
                })
            },
            updateLtCharge(){
                this.updatedLtCharge = this.formItem.lt_charge;
                this.$Modal.confirm({
                    render: (h) => {
                        return h('Input', {
                            props: {
                                value: this.updatedLtCharge,
                                autofocus: true,
                                placeholder: 'Please enter new Charge'
                            },
                            on: {
                                input: (val) => {
                                    this.updatedLtCharge = val;
                                },

                            },

                        })
                    },
                    onOk:() => {
                        axios.post('/admin/update_lt_charge',{id:this.formItem.id, new_charge:this.updatedLtCharge})
                                .then(response =>{
                                    if(response.data.status == 0){
                                        this.refresh(this.formItem.id);
                                        this.$Message.info(response.data.message);
                                    }
                                    else{
                                        this.$Message.error(response.data.message);
                                    }
                                })
                    },
                })
            }
        },
        watch:{
            tpid:function (val) {
                this.refresh(val);
            }
        }
    }
</script>