<template>
    <div>
        <div>
            <Row>
                <Col span="12">
                    <Input v-model="vin_no" placeholder="请输入车架号">
                    <span slot="prepend">车架号:</span>
                    <Button slot="append" icon="ios-search" @click="vin_no_search"></Button>
                    </Input>
                </Col>
                <Col span="12">
                    <Select v-model="payment_status" style="width:200px" placeholder="请选择付款状态"
                    @on-change="peyment_status_chenged">
                        <Option value="-1" key="">全部</Option>
                        <Option value="0" key="0">未付款</Option>
                        <Option value="1" key="1">已付款</Option>
                    </Select>
                </Col>
            </Row>
        </div>
        <Table stripe :columns="columns1" :data="data1"></Table>
        <div style="margin: 10px;overflow: hidden">
            <div style="float: right;">
                <Page :total="totalCount" :current="currentPage" :page-size="10" @on-change="changePage" simple></Page>
            </div>
        </div>

        <Modal
                width="800"
                v-model="isDetail"
                title="Title"
                @on-cancel="close">
            <transport-view :tpid="detailIndex"></transport-view>
            <div slot="footer"></div>
        </Modal>
    </div>
</template>

<script>
    import PostList from './PostList.vue'
    import TransportView from './TransportView.vue'
    export default {
        components:{
            TransportView
        },
        data () {
            return {
                columns1: [
                    {
                        title: '订单号',
                        key: 'order_id'
                    },
                    {
                        title: '车型',
                        key: 'car_model'
                    },
                    {
                        title: '车架号',
                        key: 'vin_no'
                    },
                    {
                        title: '出车方',
                        key: 'owner'
                    },
                    {
                        title: '始发地',
                        key: 'from'
                    },
                    {
                        title: '目的地',
                        key: 'to'
                    },
                    {
                        title: '付款方式',
                        key: 'payment_method_desc'
                    },
                    {
                        title:'付款状态',
                        key:'payment_status_desc'
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
                                        this.showDetail(params.index)
                                    }
                                }
                            }, '查看')
                        ]);}
                    }
                ],
                data1: [],
                vin_no:'',
                payment_status:'',
                totalCount:0,
                currentPage:1,
                 isDetail : false,
                detailIndex:-1
            }
        },
        methods:{
            vin_no_search:function () {
                this.currentPage = 1;
                this.payment_status = '';
                var url = '/admin/transport_list?vin_no=' + this.vin_no;
                this.getData(url);
            },
            changePage:function (current) {
                var url = '/admin/transport_list?page=' + current + '&vin_no=' + this.vin_no + '&payment_status=' + this.payment_status;
                this.getData(url);
            },
            peyment_status_chenged:function (val) {
                if (val == '-1') {
                    this.vin_no = '';
                    this.currentPage = 1;
                    var url = '/admin/transport_list';
                    this.getData(url);
                }
                if(val == '0' || val == 1){
                    this.vin_no = '';
                    this.currentPage = 1;
                    var url = '/admin/transport_list?payment_status=' + val;
                    this.getData(url);
                }
            },
            getData:function (url) {
                axios.get(url)
                        .then(response => {
                            this.data1 = response.data.data;
                            this.totalCount = response.data.total;
                            this.currentPage = response.data.current_page;
                        })
                        .catch(error => {
                            console.log(error);
                        });
            },
            showDetail (index) {
                this.detailIndex = this.data1[index].id
                console.log("this.data1[index].id: " + this.data1[index].id)
                console.log(this.detailIndex)
                this.isDetail = true;
            },
            close:function () {
                var url = '/admin/transport_list?page=' + this.currentPage + '&vin_no=' + this.vin_no + '&payment_status=' + this.payment_status;
                this.getData(url);
            },
        },
        mounted:function () {
            this.currentPage = 1;
            var url = '/admin/transport_list?&payment_status=&vin_no='
            this.getData(url);
        }
    }
</script>