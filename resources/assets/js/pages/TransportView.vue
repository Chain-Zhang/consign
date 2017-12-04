<template>
<Form :model="formItem" :label-width="120">
    <Row>
        <Col span="12">
        <FormItem label="订单编号">
            <Input v-model="formItem.order_id" disabled></Input>
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
        <FormItem label="总收费">
            <Input v-model="formItem.charge" disabled></Input>
        </FormItem>
        </Col>
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
            <Input v-model="formItem.st_charge" placeholder="请输入"></Input>
        </FormItem>
        </Col>
        <Col span="12">
        <FormItem label="小板费用">
            <Input v-model="formItem.lt_charge" placeholder="请输入"></Input>
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

    <FormItem>
        <Button type="primary" @click="handleSubmit('formItem')">提交</Button>
    </FormItem>
</Form>
</template>

<script>
    export default {
        props:["tpid"],
        data:function () {
            return{
                formItem:{}
            }
        },
        computed:{
          isPayed:function () {
              if(this.formItem.payment_status == 0){
                  return true;
              }else{
                  return false;
              }
          }
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
            }
        },
        watch:{
            tpid:function (val) {
                this.refresh(val);
            }
        }
    }
</script>