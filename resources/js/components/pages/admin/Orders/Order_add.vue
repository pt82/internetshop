<template>
<!--    добавляем заказ-->
    <div class="order_add">
        <h2>Новый заказ</h2>

        <div>

            <b-row>

            </b-row>
            <b-row>
                <b-col cols="4">
                    Имя:
                    <b-form-input
                        v-model="form.name"
                        required
                    ></b-form-input>
                </b-col>
                <b-col cols="3">
                    Email:
                    <b-form-input
                        v-model="form.email"
                        required
                    ></b-form-input>
                </b-col>
                <b-col cols="3">
                    Контактный телефон:
                    <b-form-input
                        v-model="form.phone"
                        required
                    ></b-form-input>
                </b-col>
                <b-col cols="12">
                    <hr>
                </b-col>
            </b-row>
            <b-row>

                <b-col cols="12">
                    <hr>
                    <div> <h4>Выберите способ получения </h4></div>
                    <b-form-group >
                        <b-form-radio v-model="form.receive"  value="1">Самовывоз</b-form-radio>
                        <b-form-radio v-model="form.receive"  value="2">Доставка курьером</b-form-radio>
                    </b-form-group>
                </b-col >
                <b-col cols="12">
                    <b-form-group
                        v-show="form.receive==2">
                        <b-row>
                            <b-col cols="12">
                                <h6>Адрес доставки</h6>
                                <b-form-input  v-model="form.adress" ></b-form-input>
                                <hr>
                            </b-col>
                        </b-row>
                        <b-row >
                            <b-col cols="4"><h6>Предпологаемая дата доставки</h6></b-col>
                            <b-col cols="4"><h6>Предпологаемая время доставки с</h6></b-col>
                            <b-col cols="4"><h6>Предпологаемая время доставки до</h6></b-col>
                        </b-row>
                        <b-row>
                            <b-col cols="4">
                                <datetime   v-model="form.dayf"  type="date"></datetime>
                            </b-col>
                            <b-col cols="4">
                                <datetime type="time"  v-model="form.timeon"></datetime>
                            </b-col>
                            <b-col cols="4">
                                <datetime type="time" v-model="form.timeoff"></datetime>
                            </b-col>
                        </b-row>
                    </b-form-group>
                </b-col>
            </b-row>
       <b-button class="btn-success" @click="order_add()">Сохранить</b-button>
        </div>
    </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex';
import axios from "axios";
import {DateTime} from "luxon";
export default {

    data() {
        return {
            product_in_order:false,
            disable_btn:false,
            id_order:'',
            quantity:1,
            selected_status:null,
            form: {
                name:'',
                email:'',
                phone:'',
                adress: '',
                dayf: null,
                timeon: null,
                timeoff: null,
                receive:"1"
            },

        }
    },

    computed: {
        ...mapGetters([
            'ORDERONE',
            'STATUSORDER',
            'LISTTOVARS'

        ]),

    },

    methods:{
        ...mapActions([
            'GET_ORDERS',
            'GET_ORDERONE',
            'DEL_TOVAR_IN_ORDER',
            'POST_UPORDERONE',
            'GET_STATUSORDER',
            'GET_LIST_TOVAR'
        ]),

        order_add(){
            let obj= {};
            this.form.dayf = DateTime.fromISO(this.form.dayf).toFormat('yyyy-MM-dd')
            this.form.timeon = DateTime.fromISO(this.form.timeon).toFormat('TT')
            this.form.timeoff = DateTime.fromISO(this.form.timeoff).toFormat('TT')
            obj['name']=this.form.name;
            obj['email']=this.form.email;
            obj['phone']=this.form.phone;
            obj['adress']=this.form.adress;
            obj['day_receive']=this.form.dayf;
            obj['time_receiveon']=this.form.timeon;
            obj['time_receiveoff']=this.form.timeoff;

            if(this.form.receive==="1") {
                obj['receive'] = 'Самовывоз';
                obj['fullorder'] = 1;
            }
            if(this.form.receive==="2") {
                obj['receive'] = 'Доставка';
                obj['fullorder'] = 2;
            }
            axios
                .post(`/api/order_add`, obj)
                .then(response => {
                    if (response.data.success)
                    {
                        this.$store.state.id_order=response.data.id_order;
                        this.$router.push({path:`/admin/order/`+response.data.id_order});
                    }
                        });

        },

        add_product_in_order(index){
            let product_in_order=false;
            for (let product of this.ORDERONE[0].tovars) {
                if (product.id === index.id) {
                    this.$alert(
                        document.getElementById(index.id).setAttribute('disabled', 'disabled'),
                        index.name + ' уже существует в заказе')
                    return false

                }
            }
            let obj = {};
            obj['id_orders'] = this.ORDERONE[0].id;
            obj['id_tovars'] = index.id;
            obj['quantity'] = this.quantity;
            axios
                .post(`/api/order/product_in_order`, obj)
                .then(response => {
                    document.getElementById(index.id).setAttribute('disabled', 'disabled'),
                        this.GET_ORDERONE(this.$store.state.id_order);
                })


            // axios
            //      .post(`/api/order/product_in_order`, obj)
            //      .then(response => {
            //
            //      })
            console.log(this.ORDERONE[0].tovars)
        },

        change_quantity(index){
            let obj={};
            obj['quantity']=index.quantity;
            axios
                .post(`/api/order/change_quantity`, index)
                .then(response => {
                })

        },

        deltovarinorder(index){
            console.log(index)
            this.DEL_TOVAR_IN_ORDER(index)
                .then(response => {
                this.GET_ORDERONE(this.$store.state.id_order)
                })

        },
    },

}
</script>

<style scoped lang="scss">
.order_add{
    padding: 1rem;
    .order_print{
        .seller{
            text-decoration: underline;
        }
    }
}

</style>
