<template>
    <div>
        <mainmenu></mainmenu>
        <navbar></navbar>


        <div class=" order">
            <b-spinner class="order_spinner"  variant="danger" v-show="spinnner" label="Loading..."></b-spinner>
        <b-row>
            <b-col cols="12">
        <div class="order_header">Оформление заказа</div>
            <hr>
            </b-col>
        </b-row>


        <b-row>
           <b-col cols="12">
            <div class="order_contact">Контактная информация</div>
            </b-col>
        </b-row>

            <b-row v-if="CART.length" class="cart ">
                <b-col cols="8" >
                    <b-row>
                        <b-col cols="4"><span>Ваше имя</span></b-col>
                        <b-col cols="4"><span>Телефон</span><span class="text-danger">*</span></b-col>
                        <b-col cols="4"><span>Email</span><span class="text-danger">*</span></b-col>
                    </b-row>

                    <b-row >
                      <b-col  cols="4">
                            <b-form-input
                                v-model="form.name"
                                placeholder="Иванов Иван"
                            >
                            </b-form-input>
                        </b-col>
                        <b-col cols="4">
                           <input-mask
                               required
                               class="form-control"
                               placeholder="+7(ХХХ)ХХX-ХХ-ХХ"
                               v-model="form.phone"
                               mask="+7(999)999-99-99"

                           />

                            <div>  <b-alert v-if="error.phone" variant="danger" show>Укажите телефон в правильном формате</b-alert></div>
                        </b-col>

                        <b-col  cols="4">
                            <b-form-input
                                type="email"
                                v-model="form.email"
                                placeholder="ivan@email.ru"
                                required

                            >
                             </b-form-input>
                            <div>  <b-alert v-if="error.email" variant="danger" show>Укажите почту</b-alert></div>
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
                                   <b-row>
                                       <b-col cols="4"><h6>Предпологаемая дата доставки</h6></b-col>
                                       <b-col cols="4"><h6>Предпологаемое время доставки с</h6></b-col>
                                       <b-col cols="4"><h6>Предпологаемое время доставки до</h6></b-col>
                                   </b-row>
                            <b-row>
                                   <b-col cols="4">
                                   <datetime   v-model="form.day_receive"  type="date"></datetime>
                                   </b-col>
                                <b-col cols="4">
                                <datetime type="time"  v-model="form.time_receiveon"></datetime>
                                   </b-col>
                                   <b-col cols="4">
                                <datetime type="time" v-model="form.time_receiveoff"></datetime>
                                   </b-col>
                               </b-row>
                      </b-form-group>
                      </b-col>


                    </b-row>

                    <div>  <b-alert v-if="error.datainterval" variant="danger" show>Указанный интервал времени должен быть не менее одного часа</b-alert></div>
                    <b-button class="buttton_order btn_hover" @click="orderadd">
                        Подтвердить заказ
                    </b-button>
                </b-col>

                <b-col cols="4" class="order_total">
                    <h4>Оформляем {{CARTCOUNT}} товара
                    </h4>
                    <h4>на сумму {{TOTALCART}}
                        &#8381;</h4>
                </b-col>
            </b-row>


        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import axios from "axios";
import { DateTime } from 'luxon';
import { Interval } from 'luxon';


import Auth from "../../../helpers/Auth";

export default {
    name: "Index",
    data() {
        return {
            spinnner:false,
            error:{
               phone:false,
               email:false,
               datainterval:false,
            },
            selected: '',
            visible:false,
            form: {
               name: '',
               phone: '',
               email: '',
               receive:"1",
               adress:'',
               day_receive:'',
               time_receiveon:'',
               time_receiveoff:'',
            }
        }
    },
    computed: {
        ...mapGetters([
            'CART',
            'CARTCOUNT',
            'TOTALCART'
        ]),
    },
    methods: {
        reloadComponentForce() {
            this.$forceUpdate();
        },
        orderadd() {
            console.log(this.form.phone)
            for (let i in this.error){
                this.error[i]=false;
            }
            let date1 = new Date(this.form.time_receiveon);
            let date2 = new Date(this.form.time_receiveoff);
            let dateinterval= Math.ceil((date2.getTime() - date1.getTime()) /60/1000);
            if (dateinterval<=60 && this.form.receive==="2"){
                this.error.datainterval=true;
                return false;
            }
            this.error.phone=false;
            this.error.email=false;
            if(this.form.phone.length<16){
                this.error.phone=true;
                return false
            }
            if(this.form.phone.includes('_')){
                this.error.phone=true;
                return false
            }

            if (this.form.email===''){
                this.error.email=true;
                return false
            }
            let obj = {};
            let data = [];
            console.log(this.form.receive)
            this.form.day_receive = DateTime.fromISO(this.form.day_receive).toFormat('yyyy-MM-dd')
            this.form.time_receiveon = DateTime.fromISO(this.form.time_receiveon).toFormat('TT')
            this.form.time_receiveoff = DateTime.fromISO(this.form.time_receiveoff).toFormat('TT')
            obj['adress'] = this.form.adress;
            obj['day_receive'] = this.form.day_receive;
            obj['time_receiveon'] = this.form.time_receiveon;
            obj['time_receiveoff'] = this.form.time_receiveoff;
            obj['email'] = this.form.email;
            obj['user'] = this.form.name;
            obj['phone'] = this.form.phone;
            if(this.form.receive==="1") {
                obj['receive'] = 'Самовывоз';
                obj['fullorder'] = "1";

            }
             if(this.form.receive==="2") {
                 obj['receive'] = 'Доставка';
                 obj['fullorder'] = "2";

            }
            console.log(obj['time_receiveon'])

            data.push(obj)
             for (let i in this.CART) {
                     data.push(this.CART[i])
               }
            this.spinnner=true;
            axios
                .post(`/api/order`, data)
                .then(response => {
                    if (response.data.success){
                    Auth.clear_cart()

                        this.spinnner=true;
                        this.$alert(
                            'Ваш заказ № '+response.data.article+ ' успешно оформлен!',)
                            .then(() => {
                            this.$router.push("/");

                        });


                       }
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });

            // this.form.name='dfs';

            // obj['name'] = "this.form.name";
            // data.push(obj)
          //  this.form.quantity='3';



        }
    }
}

</script>

<style lang="scss" scoped>
.order{
    //font-family: Gilroy, sans-serif;
    padding-top: 1rem;
    padding-bottom: 1rem;
    padding-left: 7rem;
    padding-right: 7rem;
    margin-top: 1rem;
    background-color: #f8f9fa;
    .order_spinner{
        z-index: 999;
        position: absolute;
        top: 50%;
        left: 50%;
    }
    .order_header{
        font-size: 30px;
        font-weight: bold;
      width: 100%;
        text-align: center;
    }
    .order_contact{
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 1rem;
    }
    .order_total{


    }
    .buttton_order{
        background: orangered;
    }
}
</style>
