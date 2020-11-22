<template>
<!--корзина-->
   <div>
       <mainmenu></mainmenu>
      <navbar></navbar>

        <div class="cart">
       <b-row v-if="CART.length" class=" text-center">
           <b-col cols="9" class="item_cart">
            <div class="card pt-2 pb-2 ">
               <b-row v-for="(item, index) in CART" :key="item.id"  class="mt-2">
                    <b-col cols="1">
                       <img :src="item.photo" alt="" class="image_tovar_cart ml-2 ">
                   </b-col>
                   <b-col cols="4" class="mt-auto mb-auto">
                       {{item.name}}
                   </b-col>
                   <b-col cols="2" class=" mt-auto mb-auto">
                       <b-row>
                           <b-col cols="12">
                        <div class="picein">{{item.pricein}} &#8381;</div>
                           </b-col>
                           <b-col cols="12">
                       <div class="text-secondary">цена за ед.</div>
                           </b-col>
                       </b-row>
                   </b-col>
                       <b-col cols="2" class="mt-auto mb-auto">
                           <b-row>
                           <b-col cols="12" >
                           <span class="btn_action_cart mr-1" @click="decrement(index)"><i class="fas fa-minus"></i></span>
                           <span class="quantity_cart text-center" type="text" readonly>{{$store.state.cart[index].quantity}}</span>
                           <span class="btn_action_cart ml-1" @click="increment(index)"><i class="fas fa-plus"></i></span>
                           </b-col>
                               <b-col cols="12" class="text-secondary">
                                   шт.
                               </b-col>
                           </b-row>
                       </b-col>
                   <b-col cols="2" class="mt-auto mb-auto">
                       <b-row>
                           <b-col cols="12" >
                        <div class="picein"> {{item.totalPrice}} &#8381;</div>
                           </b-col>
                   <b-col cols="12" >
                          <div class="text-secondary">  сумма</div>
                   </b-col>
                       </b-row>
                   </b-col>
                   <b-col cols="1" class="mt-auto mb-auto">
                       <button  @click="deleteFromCart(index)" class="float-right h-100 w-100 mt-auto mb-auto btn btn-link" ><i class="far fa-trash-alt"></i></button>

                   </b-col>

                   </b-row>

            </div>
           </b-col>

           <b-col cols="3" >
               <b-row>
                 <b-col>
              <h3>Итого: {{CARTCOUNT}} товара на {{TOTALCART}}
                  &#8381;</h3>
               <router-link :to="`/order/`"> <b-button class="buttton_order btn_hover">
                Оформить
           </b-button>
               </router-link>
                 </b-col>
               </b-row>
           </b-col>
       </b-row>

       <div v-else><h3 >Корзина пуста</h3></div>
        </div>

   </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
export default {
    name: "Index",
    data() {
        return {

        }
    },
    computed: {
        ...mapGetters([
            'CART',
            'CARTCOUNT',
            'TOTALCART'
           ]),
            total_position(){

            }
        },

    methods: {
        ...mapActions([
            'DELETE_FROM_CART',
            'INCREMENT_CART_ITEM',
            'DECREMENT_CART_ITEM',

        ]),
        deleteFromCart(index) {
            this.DELETE_FROM_CART(index)
        },
        increment(index) {
            if (window.store.state.cart[index].quantity>=window.store.state.cart[index].balance){
                this.$alert('Данного количества нет на складе')}
            else{
                    this.INCREMENT_CART_ITEM(index)}
           },
        decrement(index) {
            this.DECREMENT_CART_ITEM(index)
        },

    }

}

</script>



<style scoped lang="scss">
.cart {
    padding-top: 1rem;
    padding-bottom: 1rem;
    padding-left: 7rem;
    padding-right: 7rem;
    margin-top: 1rem;
    background-color: #f8f9fa;
      .btn_action_cart{
        color: #a3a3a3;
        font-size: 18px;

    }
    .quantity_cart{
        font-weight: bold;
        font-size: 18px;
    }
    .picein{
        font-weight: bold;
        font-size: 18px;
    }
    .btn_action_cart:hover{
        color: orangered;
        cursor: pointer;
    }

}


.buttton_order {
    width: 100%;
    height: 50px;
    background: orangered;
}

.image_tovar_cart {
    width: 3rem;
    height: 4rem;
}
</style>
