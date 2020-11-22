<template>
<!--    редактирование заказа-->
<div class="order">
    <b-spinner class="order_spinner"  variant="danger" v-if="spinnner" label="Loading..."></b-spinner>

    <div v-show="false" id="order_print" class="order_print m-5" >
    <div v-for="i in ORDERONE" :key="i.id">
        <b-row>
            <b-col cols="12" class="text-center"><h4>Накладная № {{i.article}} от {{data_rep}}</h4></b-col>
            <b-col cols="12" style="">
                <div class="seller" >
                    Продавец: ООО "InternetShop"
                </div>
                <div class="seller" >
                    Адрес продавца: Россия, 630068, г. Новосибирск, ул. Селезнева, 25 оф. 365
                </div>
            </b-col>
            <b-col cols="12" class="mt-3">
                <div class="customer">
                Покупатель: {{i.name}}
                </div>
            </b-col>
            <b-col cols="12">
                Контактный телефон: {{i.phone}}
            </b-col>
            <b-col cols="12">
                Адрес доставки: {{form.adress}}
            </b-col>
            <hr>
        </b-row>
        <b-row class="mt-5">
            <b-col cols="12">
            <div class="text-center"><h4>Товары в заказе</h4></div>
            </b-col>
            <b-col cols="12">
                <table class="table">
                    <thead class="thead-dark">
                    <tr>

                        <th>Код товара</th>
                        <th>Наименование</th>
                        <th>Цена</th>
                        <th>Кол-во</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item_prod in ORDERONE[0].tovars" :key="item_prod.id">
                        <th >
                            {{ item_prod.article}}
                        </th>
                        <th >
                            {{ item_prod.name}}
                        </th>
                        <th >
                            {{ item_prod.pricein}}
                        </th>
                        <th >
                            {{ item_prod.pivot.quantity}}
                        </th>
                    </tr>
                    </tbody>
                </table>
            </b-col>
        </b-row>

        <b-row class="mt-5">
            <b-col cols="12">
               Товар опустил _________________________ / Иванов И И/
            </b-col>
            <b-col cols="12" class="mt-5">
                Товар получил _________________________ / {{i.name}}/
            </b-col>
        </b-row>



    </div>
</div>

    <div class="modal fade" id="Addproduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <b-row>
                        <b-col cols="4">
                            <h6>Количество</h6>
                            <b-form-spinbutton v-model="quantity"></b-form-spinbutton>
                        </b-col>
                        <b-col cols="12">
                    <vue-ads-table-tree
                        :columns="columns_product"
                        :rows="LISTTOVARS"
                        :page="page"
                        :items-per-page="10"
                        @page-change="pageChanged"
                        @filter-change="filterChanged"
                    >

                        <template slot="id" slot-scope="props" >
                            <b-button :id=props.row.id @click="add_product_in_order(props.row)"  class="btn-success"><i class="far fa-plus-square w-100"></i></b-button>


                        </template>
                    </vue-ads-table-tree>
                        </b-col>

                    </b-row>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div v-for="item in ORDERONE" :key="item.id">
       <b-row>
           <b-col cols="12" class="title_item" >Информация о заказе</b-col>
          <b-col cols="3">
            <div> Заказ № </div>
            <b-form-input
                v-model="item.article"
                disabled
            ></b-form-input>


          </b-col>
           <b-col cols="4">
               <div class="order_title">
                  Дата заказа
               </div>
               <b-form-input
                   v-model="item.data_order"
                   disabled
               ></b-form-input>
           </b-col>
           <b-col cols="5">
               <div>Статус заказа</div>
    <b-form-select
      v-model="selected_status"
      required
     >
       <option v-for="item in STATUSORDER" v-bind:value="item.id" :key="item.id">
        {{item.status}}
       </option>
        </b-form-select>
           </b-col>

           </b-row>
        <b-row class="mt-3">
            <b-col cols="4">
                 <div> Имя</div>
                <b-form-input
                    v-model="form.name"

                ></b-form-input>
               </b-col>
            <b-col cols="3">
                <div>
                    <div> Email </div>
                    <b-form-input
                        v-model="form.email"

                    ></b-form-input>
                </div>
            </b-col>
            <b-col cols="3">
                <div>
                   <div> Телефон </div>
                    <b-form-input
                        v-model="form.phone"

                    ></b-form-input>

                </div>
            </b-col>
            <b-col cols="12">
                <hr>
            </b-col>
        </b-row>
        <b-row>
            <b-col cols="12"  class="title_item" >
                Доставка
            </b-col>
            <b-col cols="12">
                Адрес доставки
                <b-form-input
                    v-model="form.adress"

                ></b-form-input>
            </b-col>
            <b-col cols="4" class="mt-3">
              День доставки
                <datetime type="data" v-model="form.day"></datetime>
            </b-col>
            <b-col cols="4" class="mt-3">
            Время доставки с
                <datetime type="time" v-model="form.timeon"></datetime>
            </b-col>
            <b-col cols="4" class="mt-3">
                Время доставки до
                <datetime type="time" v-model="form.timeoff"></datetime>

            </b-col>
            <b-col cols="12"><hr></b-col>
            <b-col cols="12" class="mt-3  d-inline-flex">


            <b-button class="btn-success" @click="updatetovarinorder()">Сохранить</b-button>
            <b-button class="btn-info ml-3" @click="order_print"><i class="fas fa-print"></i> Печать</b-button>
                <b-form-checkbox
                    v-model="form.send_mail"
                     class="ml-3"
                >
                    Отправлять статус заказа клиенту
                </b-form-checkbox>
            </b-col>
        </b-row>
        <b-row>
            <b-col cols="12" class="mt-2">
                <hr>
            <div class="title_item">Товары в заказе</div>
            </b-col>
            <b-col cols="12">

            <b-button class="btn-success mt-2"  data-toggle="modal" data-target="#Addproduct"><i class="far fa-plus-square "></i> Добавить</b-button>


            </b-col>
            <b-col cols="12">
                <vue-ads-table-tree
                    :columns="columns"
                    :rows="ORDERONE[0].tovars"
                    :page="page_order"
                    :items-per-page="5"

                >
                    <template slot="pivot" slot-scope="props" class="w-50">
                        <b-form-spinbutton @change="change_quantity(props.row.pivot)" v-model="props.row.pivot.quantity"></b-form-spinbutton>
<!--                        <b-form-input @change="change_quantity(props.row.pivot)" v-model="props.row.pivot.quantity" type="number" style='width: 20%;'></b-form-input>-->
<!--                        <span>{{props.row.pivot.quantity}}</span>-->
<!--                        <b-button @click="edit(props.row.quantity)" class="w-25  btn-success" data-toggle="modal" data-target="#SubCategoryModal"> <i class="fas fa-pencil-alt "></i> </b-button>-->
<!--                        <b-button @click="del(props.row.id)"  class="w-25  btn-danger"> <i class="far fa-trash-alt"  ></i> </b-button>-->
                    </template>
                    <template slot="id" slot-scope="props" >
                        <b-button @click="deltovarinorder(props.row.id)" class="btn-danger"><i class="far fa-trash-alt"></i></b-button>
                    </template>
                </vue-ads-table-tree>
            </b-col>

        </b-row>

    </div>
</div>
</template>

<script>
import {bus} from '../../../../app'
import {mapActions, mapGetters} from 'vuex';
import axios from "axios";
import {DateTime} from "luxon";
export default {

    data() {
        return {
            spinnner:false,
            disable_btn:false,
             id_order:'',
             quantity:1,
            selected_status:null,
            form: {
                name:'',
                email:'',
                phone:'',
                adress: '',
                day: null,
                timeon: null,
                timeoff: null,
                send_mail:true,
            },
            page:0,
            page_order:0,
            columns_product:[
                {
                    property: 'article',
                    title: 'Код',
                    filterable: true,
                },
                {
                    property: 'name',
                    title: 'Наименование',
                    filterable: true,
                },
                {
                    property: 'pricein',
                    title: 'Цена',
                },
                {
                    property: 'balance',
                    title: 'Остаток',
                },
                {
                    property: 'id',
                    title: '',
                }
                ],

            columns:[
                {
                    property: 'article',
                    title: 'Номер',
                    filterable: true,

                },
                {
                    property: 'name',
                    title: 'Наименование',
                    filterable: true,

                },
                {
                    property: 'pricein',
                    title: 'Цена',


                },
                {
                    property:'pivot',
                    title: 'Количество',


                },
                {
                    property:'id',
                    title: '',

                }

            ]
        }
    },
    created() {

      this.GET_STATUSORDER();
      this.GET_LIST_TOVAR()
      this.GET_ORDERONE(this.$store.state.id_order)
        .then(()=> {
                this.selected_status = this.ORDERONE[0].id_statusorders,
                this.form.adress = this.ORDERONE[0].adress,
                this.form.name = this.ORDERONE[0].name,
                this.form.email = this.ORDERONE[0].email,
                this.form.phone = this.ORDERONE[0].phone,
                this.form.day = this.ORDERONE[0].day_receive,
                this.form.timeon = this.ORDERONE[0].time_receiveon,
                this.form.timeoff = this.ORDERONE[0].time_receiveoff
        })


    },

    computed: {
        ...mapGetters([
            'ORDERONE',
            'STATUSORDER',
            'LISTTOVARS'

        ]),
        data_rep() {
            return (new Date()).toLocaleDateString()
        }
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
        pageChanged (page) {
            this.page = page;
        },
        filterChanged (filter) {
            this.filter = filter;
        },
        order_print(){
            this.$htmlToPaper('order_print');
        },
       // обновляем товары в заказе
       updatetovarinorder(){
           this.spinnner=true;
          let obj= {};
          this.form.day = DateTime.fromISO(this.form.day).toFormat('yyyy-MM-dd')
          this.form.timeon = DateTime.fromISO(this.form.timeon).toFormat('TT')
          this.form.timeoff = DateTime.fromISO(this.form.timeoff).toFormat('TT')
            obj['id']=this.ORDERONE[0].id;
            obj['article']=this.ORDERONE[0].article;
            obj['id_statusorders']=this.selected_status;
             obj['name']=this.form.name;
            obj['phone']=this.form.phone;
            obj['email']=this.form.email;
            obj['adress']=this.form.adress;
            // obj['receive']=this.ORDERONE[0].receive;
            obj['day_receive']=this.form.day;
            obj['time_receiveon']=this.form.timeon;
            obj['time_receiveoff']=this.form.timeoff;
            obj['send_mail']=this.form.send_mail;

           // data.push(obj);
            axios
                .post(`/api/uporder`, obj)
                .then(response => {
                this.spinnner=false;
                this.$router.push({path: '/admin/order/'})

                });

        },
        //добавляем товар в заказе
        add_product_in_order(index){
                let product_in_order=false;
               for (let product of this.ORDERONE[0].tovars) {
                   if (product.id === index.id) {
                       this.$alert(
                           document.getElementById(index.id).setAttribute('disabled', 'disabled'),
                           index.name + ' уже существует в заказе')
                       this.quantity=1;
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
                                    this.GET_ORDERONE(this.$store.state.id_order)
                                    this.quantity=1
                            })



        console.log(this.ORDERONE[0].tovars)
        },

        change_quantity(index){
        let obj={};
            obj['quantity']=index.quantity;
            axios
                .post(`/api/order/change_quantity`, index)
                .then(response => {
                   if(!response.data.success){

                       this.$alert('Данного количества нет на складе!')
                       return false;
                   }
                })


        },


        deltovarinorder(index){

            this.DEL_TOVAR_IN_ORDER(index)
            .then(this.GET_ORDERONE(this.$store.state.id_order))

        },
},

}
</script>

<style scoped lang="scss">
.order{

    padding: 1rem;
    .order_print{
        .seller{
            text-decoration: underline;
        }
    }
    .order_spinner{
        z-index: 999;
        position: absolute;
        top: 50%;
        left: 50%;
    }
    .title_item{
        font-family: "Arial Black";
        font-size: 14px;
        margin-bottom: 10px;
    }
}

</style>
