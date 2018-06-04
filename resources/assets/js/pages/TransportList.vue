<template>
    <div>
        <div>
            <Row>
                <Col span="6">
                    <Input v-model="vin_no" placeholder="请输入车架号">
                    <span slot="prepend">车架号:</span>
                    <!--<Button slot="append" icon="ios-search" @click="vin_no_search"></Button>-->
                    </Input>
                </Col>
                <Col span="6">
                    <Input v-model="owner" placeholder="请输入客户来源">
                    <span slot="prepend">客户来源:</span>
                    </Input>
                </Col>
                <Col span="6">
                    <Input v-model="from" placeholder="请输入始发地">
                        <span slot="prepend">始发地:</span>
                    </Input>
                </Col>
                <Col span="6">
                    <Input v-model="to" placeholder="请输入目的地">
                        <span slot="prepend">目的地:</span>
                    </Input>
                </Col>

            </Row>
            <Row>
                <Col span="6">
                <Select v-model="payment_status" style="width:200px" placeholder="请选择付款状态">
                    <Option value="-1" key="">全部</Option>
                    <Option value="0" key="0">未付款</Option>
                    <Option value="1" key="1">已付款</Option>
                </Select>
                </Col>
                <!--<Col span="6">-->
                <!--<DatePicker v-model="daterange" type="daterange" placement="bottom-end" placeholder="Select date" style="width: 200px"></DatePicker>-->
                <!--</Col>-->
                <Col span="6">
                    <Button type="primary" shape="circle" icon="ios-search" @click="search">查询</Button>
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
                title="订单详情"
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
                        title: '订单日期',
                        key: 'ordered_date'
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
                        title: '客户来源',
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
                from:'',
                to:'',
                owner:'',
                daterange:[],
                totalCount:0,
                currentPage:1,
                isDetail : false,
                detailIndex:-1
            }
        },
        methods:{
            search:function () {
                console.log(this.daterange)
                console.log(this.daterange[0])
                console.log(this.daterange[1])
                this.currentPage = 1;
                this.getData();
            },
            changePage:function (current) {
                this.currentPage = current;
                //var url = '/admin/transport_list?page=' + current + '&vin_no=' + this.vin_no + '&payment_status=' + this.payment_status;
                this.getData();
            },
            getData:function () {
                let url = '/admin/transport_list?page=' + this.currentPage + '&payment_status='+this.payment_status +
                        '&vin_no='+ this.vin_no + '&from=' + this.from + '&to=' + this.to +'&owner=' + this.owner
                        //'&start=' + this.daterange[0] + '&end=' + this.daterang[1]
                console.log('url: ' + url)
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