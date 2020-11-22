<template>
<!--    список заказов-->
      <div class="orders">
          <h2>Заказы</h2>
          <b-button  @click="order_add">
              Добавить
          </b-button>
          <vue-ads-table-tree
              :columns="columns"
              :rows="ORDERS"
              :page="page"
              :items-per-page="8"
              @page-change="pageChanged"
              @filter-change="filterChanged"
          >
              <template slot="id" slot-scope="props" >
                  <b-button @click="edit(props.row.id)" class="w-25  btn-info" > <i class="fas fa-pencil-alt "></i> </b-button>
<!--                  <b-button @click="del(props.row.id)"  class="w-25  btn-danger"> <i class="far fa-trash-alt"  ></i> </b-button>-->
              </template>
          </vue-ads-table-tree>


      </div>
</template>

<script>
import { bus } from '../../../../app'
import {mapActions, mapGetters} from 'vuex';
import axios from "axios";
export default {

    data() {
        return {
            title:'sdfsdfsd',
            page:0,
            columns:[
                {
                    property: 'article',
                    title: 'Номер',
                    filterable: true,

                },
                {
                    property: 'status',
                    title: 'Статус',

                },

                {
                    property: 'phone',
                    title: 'Телефон',

                    filterable: true,
                },
                {
                    property: 'receive',
                    title: 'Доставка',

                },

                {
                    property:'id',
                    title: ''
                }
            ],
            value: null,
             visible_table_order: true,
            visible_order: false,
            arr_otvar: [],
            orderid: null,
            i:null,
            form: {
                article:'',
                name: '',
                phone: '',
                email: '',
                receive:'',
                adress:'',
                day_receive:'',
                time_receiveon:'',
                time_receiveoff:'',
                statusorderid:'',
            },

            columns1: [
                {
                    label: 'Номер',
                    field: 'article',
                    //   filtertable: true,
                }
            ],
            tovar: [
                {
                    label: 'Товар',
                    field: 'name',


                },

            ],
        }
    },
    computed: {
        ...mapGetters([
            'ORDERS',
            'ORDERONE',
            'STATUSORDER'
        ]),
    },
    created() {
        this.GET_ORDERS();
          },
    methods: {
        ...mapActions([
            'GET_ORDERS',
            'GET_ORDERONE',
            'DEL_TOVAR_IN_ORDER',
            'POST_UPORDERONE',
            'GET_STATUSORDER',
        ]),
        pageChanged (page) {
            this.page = page;
        },
        filterChanged (filter) {
            this.filter = filter;
        },
        order_add(){
            this.$router.push({path:'/admin/order_add'});
        },

        edit(index) {
            this.$store.state.id_order=index;
            this.$router.push({path:'/admin/order/'+index});
        },

        deltovarinorder(index){

        this.DEL_TOVAR_IN_ORDER(index);
        },


    },

}
</script>





<style scoped lang="scss">
.orders{
    padding-top: 1rem;
    padding-left: 0.5rem;
    padding-right: 1rem;

.pagination {
    display: flex;
    margin: .25rem .25rem 0;
}
.pagination button {
    flex-grow: 1;
}
.pagination button:hover {
    cursor: pointer;
}
}
</style>

