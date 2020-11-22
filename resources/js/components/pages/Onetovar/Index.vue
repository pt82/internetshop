<template>
   <div>
       <mainmenu></mainmenu>
       <navbar ></navbar>
       <div class="product">
        <div v-if="errored" class="alert alert-danger" role="alert">
            Товр не найден
        </div>
       <ol class="breadcrumb">
           <router-link  :to="`/`">
           <li > Главная </li>
           </router-link>
           <li > &#160; &#8212; &#160; </li>
           <router-link v-for="item in UPCATEGORY" :to="`/subcategory/${item.id}`" >
               <li >  {{item.category}} </li>
           </router-link>
           <li > 	&#160; &#8212; &#160;</li>
           <router-link v-for="item in UPSUBCATONE" :to="`/subcategory/${item.id}/tovars`" >
           <li >  {{item.subcategori}}</li>
           </router-link>
           <li >	&#160; &#8212; &#160; </li>
           <li v-for="item in product" class="font-weight-bold"> {{item.name}}</li>
       </ol>

       <b-row class="justify-content-md-center ">
<!--           изображение товара-->
                 <b-col cols="6 " >
               <b-row >
                   <b-col cols="3"  class="product_list ">
                       <div class="d-flex flex-column" v-for="item in IMAGESFORCLIENT" :key="item.id">
                       <img @click="active_image(item.path)" :src="item.path" alt="" class="image_product_list mt-2 ">
                       </div>
                   </b-col>
                   <b-col cols="9">
                       <div v-if="act===''" v-for="item in product">
                       <img :src="item.photo" alt="" class="image_tovar">
                       </div>
                       <img v-if="act!==''" :src="act" alt="" class="image_tovar">

                      </b-col>
<!--                <b-col cols="12" v-for="item in IMAGESFORCLIENT" :key="item.id">-->
<!--                <b-card img-alt="Card image" img-top >-->

<!--                    <img :src="item.path" alt="" class="image_tovar">-->
<!--                </b-card>-->
<!--             </b-col>-->

            </b-row>
           </b-col>

<!--           товар-->
            <b-col cols="6" class="card">
             <b-row>
            <b-col cols="12">
                <div  v-for="item in product"
                     :key="item.id"
                >
                    <b-col cols="12"><h6 class="text-secondary mt-3">Код: {{item.article}}</h6></b-col>

                    <b-col cols="12" >
                            <h1 class="font-weight-bold mb-3 mt-4">{{item.name}}</h1>

                    </b-col>
                    <b-col cols="5" >
                   <b-form-rating class="rating_star mt-8" v-model="AVGRATING" readonly precision="2"></b-form-rating>
                    </b-col>
                    <b-row>
                    <b-col cols="5" >
                        <h1 class="font-weight-bold mb-3 mt-4 ml-4 ">{{item.price}} &#8381;</h1>

                    </b-col>
                        <b-col cols="7" class="d-flex flex-column" >

                            <b-button v-b-popover.hover.top="'Добавить в корзину'" id="btn_cart" class="mb-4 h-75 btn_cart" @click="addCart(item)">
                                <h2><span><i class="fas fa-dolly-flatbed"></i></span> В корзину</h2>
                            </b-button>

                        <b-button v-b-popover.hover.bottom="'Купить сейчас'" class="btn_oneclick  bg-transparent text-dark" data-toggle="modal" data-target="#OneClick">
                          <h4> <span><i class="far fa-hand-point-up"></i></span> В один клик</h4>
                        </b-button>

                        <div class="modal fade" id="OneClick" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div>
                                            <input-mask class="form-control" placeholder="Телефон" v-model="form.phone" mask="+7 (999) 999-99-99" />
                                        </div>

                                        <label>Количество</label>
                                        <b-form-spinbutton  v-model="form.quantity" min="1" ></b-form-spinbutton>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="" data-dismiss="modal">Отмена</button>
                                        <button type="button" @click=" addCartOneClick(item.id)"  class="btn btn-danger">Заказать</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </b-col>
                    </b-row>

                    <b-row class="mt-2">

                    <b-col cols="12" class="d-flex flex-column " >

                        <h6><span><i class="far fa-smile"></i></span><span> Оценка {{AVGRATING}} из 5</span></h6>
                        <h6><span><i class="far fa-comment"></i></span><span> Отзывов: {{item.count_review}}</span></h6>
                        <h6><span><i class="fas fa-warehouse"> </i></span><span> Остаток: {{item.balance}}</span></h6>
                    </b-col>
                    </b-row>
                </div>
                </b-col>
        </b-row>
                <div class="cart_footer mb-3">
                    <hr>
                    <div class="d-inline-flex ">
                       <h5 class="mr-3"> <i class="far fa-heart "></i> В избранное </h5>
                        <h5> <i class="fas fa-balance-scale"></i> Сравнить </h5>
                    </div>
                 </div>
            </b-col >

            </b-row>

       <b-row>
           <b-col cols="12" class="card mt-2">

                   <b-tabs pills card content-class class="mt-3">
                       <b-tab title="Описание" active  >
                           <div  v-for="item in product"
                                 :key="item.id"
                           >
                               <h4>Описание  {{item.name}}</h4>

                           <hr>
                           <div class="desc">
                              {{item.desc}}
                           </div>
                           </div>
                       </b-tab>

                       <b-tab title="Отзывы" >
                           <b-button   @click="clear_form" class="mb-2 btn-danger" data-toggle="modal" data-target="#myModal">
                               Добавить отзыв
                           </b-button>

                           <!--       мод окно добавления отзыва-->
                           <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                               <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                       <div class="modal-body">
                                           <div>
                                               <h4>Оценка</h4>
                                               <b-form-rating class="rating_star" v-model="form.rating"></b-form-rating>
                                           </div>
                                           <hr>
                                           <b-form-input v-model="form.user" placeholder="Ваше имя"></b-form-input>
                                           <hr>
                                           <b-form-group>
                                               <b-form-textarea
                                                   id="textarea"
                                                   v-model="form.review"
                                                   placeholder="Коментарий"
                                                   rows="3"
                                                   max-rows="6"
                                               ></b-form-textarea>
                                               <hr>
                                               <b-form-textarea
                                                   id="textarea"
                                                   v-model="form.reviewgood"
                                                   placeholder="Достоинства"
                                                   rows="3"
                                                   max-rows="6"
                                               ></b-form-textarea>
                                               <hr>
                                               <b-form-textarea
                                                   id="textarea"
                                                   v-model="form.reviewbad"
                                                   placeholder="Недостатки"
                                                   rows="3"
                                                   max-rows="6"
                                               ></b-form-textarea>
                                               <hr>
                                           </b-form-group>
                                           <div class="modal-footer">
                                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                               <button type="button" @click="addreview()"  class="btn btn-success">Добавить</button>
                                           </div>
                                       </div>
                                   </div>

                               </div>
                           </div>
                           <hr>
                           <div v-for="item in LISTREVIEW" :key="item.id">
                               <b-row class="align-items-center d-flex">
                                   <b-col cols="8">
                                       <h5 class="font-weight-bold">{{item.user}}</h5>
                                   </b-col>
                                   <b-col cols="4" >
                                       <b-form-rating class="rating_star" v-model="item.rating" readonly precision="1"></b-form-rating>
                                       <div class="float-right text-secondary">{{item.data}}</div>
                                   </b-col>
                               </b-row>
                               <div class="font-weight-bold">
                                   Коментарий:
                               </div>
                               <div class="mb-2">
                                   {{ item.review }}
                               </div>
                               <div class="font-weight-bold">
                                   Достоинства:
                               </div>
                               <div  class="mb-2">
                                   {{ item.reviewgood }}
                               </div>
                               <div class="font-weight-bold">
                                   Недостатки:
                               </div>
                               <div class="mb-2">
                                   {{ item.reviewbad }}
                               </div>
                               <hr>
                           </div>
                       </b-tab>
                   </b-tabs>
           </b-col>
       </b-row>

       </div>
       <footer_menu></footer_menu>
   </div>
</template>

<script >
import {mapActions, mapGetters} from 'vuex';
import axios from "axios";
import Auth from "../../../helpers/Auth";

export default {
    data() {
        return {
            active_img: '',
            form: {
                quantity:1,
                rating:null,
                review:'',
                reviewgood:'',
                reviewbad:'',
                id_tovars:this.$route.params['id_tovars'],
                user:this.$store.state.Auth.name,
            },
            view_visible: false,
            tovar_visible: true,
            load: '',
            sel_btn:null,

            rating:null,
            carts:[],
            cartadd: {
                id:'',
                tovarcount:0,
            },
            badge: '',
            cartsadd: {},
            product: '',
            id_sub: this.$route.params['id'],
            sub: {
                id: ''
            },
            loading: true,
            errored: false,
            validationErrors: ''
        }
    },
    computed: {
        ...mapGetters([
            'IMAGESFORCLIENT',
            'LISTREVIEW',
            'AVGRATING',
            'UPSUBCATONE',
            'UPCATEGORY'
        ]),
        act(){
            return this.active_img
        }
    },
    created() {


    },

    mounted() {
        this.getSub()
        this.GET_LIST_IMAGE_FOR_CLIENT(this.$route.params['id_tovars']);
        this.GET_LIST_REVIEW(this.$route.params['id_tovars']);
    },

    watch: {
        '$route' (to, from) {
            this.getSub()
            this.GET_LIST_IMAGE_FOR_CLIENT(this.$route.params['id_tovars']);
            this.GET_LIST_REVIEW(this.$route.params['id_tovars']);
           }

        },

    methods: {
        ...mapActions([
         'GET_LIST_IMAGE_FOR_CLIENT',
          'GET_LIST_REVIEW',
          'UPDATE_SUBCATONE',
          'UPDATE_CATEGORIES'
        ]),

        clear_form(){
            this.form.rating=null;
            this.form.user='';
            this.form.review='';
            this.form.reviewgood='';
            this.form.reviewbad='';
        },

        form_review(){
            this.view_visible=true;
            this.tovar_visible=false;
        },
        active_image(index){
           let vm=this;
            vm.active_img=index;
        },
         async addreview(){

         if(this.form.user === null ||  this.form.user==='')
         {
             this.form.user ='Гость'
         }
            await axios
            .post(`/api/review`, this.form)
            .then(response => {
            this.GET_LIST_REVIEW(this.$route.params['id_tovars'])

            }

            )
            Auth.closeModal()
        },

        addCart(item) {
          Auth.animatetocart()
            this.$store.commit('ADD_TO_CART', item);
        },

        addCartOneClick(item) {
            let obj = {};


            obj['phone'] = this.form.phone;
            obj['id_tovars'] = item;
            obj['quantity'] = this.form.quantity;
            axios
                .post(`/api/add_order_oneclick`, obj)
                .then(response => {
                       if (response.data.success){
                        Auth.closeModal();
                        this.$alert(
                            'Ваш заказ № '+response.data.article+ ' успешно оформлен!',)
                        }
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });

        },

       async getSub() {
           await  axios
                .get(`/api/subcategory/${this.$route.params['id']}/tovars/${this.$route.params['id_tovars']}`)
                .then(response => {
                    this.product = response.data
                    this.UPDATE_CATEGORIES(this.product[0].id_categories)
                    this.UPDATE_SUBCATONE(this.product[0].id_subcategories)
                     this.product[0].price = Auth.numberWithSpaces(this.product[0].pricein)
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true;
                })
                .finally(() => this.loading = false)
        }


    }
}

</script>
<style lang="scss" scoped>
@import "public/css/variables";
.product{
    padding-top: 1rem;
    padding-bottom: 1rem;
    padding-left: 7rem;
    padding-right: 7rem;
    margin-top: 1rem;
    background-color: #f8f9fa;
    a {
        text-decoration: none !important;
        color: black !important;
    }
    .breadcrumb {
        a:hover {
            color: $main_color !important;
        }
    }
    .rating_star{
        color: $main_color;
    }
}
.desc{
    line-height: 2;
    font-size: 18px;
}
.image_tovar{
    width: 100%;
    height: 450px;
}
.product_list {

}
.image_product_list{

    width: 50px;
    height: 70px;
}
.card{
  min-height:500px ;
}
.rating_star {
    border-color: transparent !important;
    box-shadow: none !important;
    color: orangered ;
}
.btn_cart{
   background-color: orangered !important;
    height: 4rem !important;

}
.btn_oneclick:hover{
    background-color: orangered !important;
    color: white !important;

}
.cart_footer{
    position:absolute;
    bottom:0;
    width: 95%;
}
.vdatetime-input{
    border-radius: 5px;
    border: 1px solid black !important;
}
.nav-pills .nav-link.active, .nav-pills .show > .nav-link {
    color: white!important;
    background-color: $main_color!important;
}



/*.addToCart{*/
/*    position: relative;*/
/*    display: table;*/
/*    width: auto;*/
/*    height: auto;*/
/*    box-sizing: border-box;*/
/*    background: #FF0000;*/
/*    border-radius: 5px;*/
/*    padding: 8px 14px;*/
/*    font-size: 15px;*/
/*    color: #fff;*/
/*    margin: auto;*/
/*    cursor: pointer;*/
/*}*/

</style>
