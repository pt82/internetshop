<template>
    <div>
        <mainmenu></mainmenu>
        <navbar ></navbar>
        <div class="product_list ">
        <ol class="breadcrumb ">
            <router-link  :to="`/`">
                <li > Главная </li>
            </router-link>
            <li >&#160; &#8212; &#160; </li>
            <router-link v-for="item in UPCATEGORY" :key="item.id" :to="`/subcategory/${item.id}`" >
                <li >  {{item.category}}</li>
            </router-link>
            <li > &#160; &#8212; &#160; </li>
            <li v-for="item in UPSUBCATONE" :key="item.id" class="font-weight-bold">  {{item.subcategori}}</li>
        </ol>
        <h1 v-for="item in UPSUBCATONE" :key="id_sub" >{{item.subcategori}}</h1>
        <b-row>
            <b-col cols="3">
                <hr>
                <div class="filters card p-3">
                    <h3 class="mb-2">
                       Фильтр
                    </h3>
                    <hr>
                    <h5 class="mb-2">
                       Цена
                    </h5>
                    <div class="range-slider w-100  mt-4 mb-2"  >

                        <vue-slider
                            v-model="range"
                            :height="height"
                            :width="width"
                            :min="minPrice"
                            :max="maxPrice"
                            :useKeyboard="useKeyboard"
                            :tooltip="tooltip"
                            :bgStyle="bgStyle"
                            :processStyle="processStyle"
                            :tooltipStyle="tooltipStyle"
                            :formatter="formatter"
                            :dot-size="dotSize"
                            :merge-formatter="overlapFormatter"
                        ></vue-slider>



                    </div>
                    <b-button
                        class="mb-2 mt-5 w-75 ml-auto mr-auto"
                        @click="setRangeSlider"
                    >
                        Показать
                    </b-button>
                </div>
            </b-col>

            <b-col cols="9">
                <div v-for="cat in cats" :key="item.id">{{cat}}</div>
                <div v-if="errored" class="alert alert-danger" role="alert">
                    Товары отсутсвуют.

                </div>
                <hr>

                <h5>сортировать:</h5>
                <b-button v-show="sort_up" @click="sortedList_Up"> цена <i class="fas fa-sort-amount-up"></i></b-button>
                <b-button v-show="sort_down" @click="sortedList_Down">цена <i class="fas fa-sort-amount-down"></i></b-button>

                <b-button v-show="sort_name_up" @click="sorted_Name_List_UP"> товар <i class="fas fa-sort-alpha-down"></i> </b-button>
                <b-button v-show="sort_name_down" @click="sorted_Name_List_Down"> товар <i class="fas fa-sort-alpha-up"></i></b-button>
<!--                <div  v-if="!filter_product">-->
                <b-row v-for="sub in filteredProducts"
                       :key="sub.id"
                >
                    <b-col cols="12" class="card mt-3">
                        <b-row >

                            <b-col cols="3">
                                <b-row >
                                    <b-col cols="12">
                                        <router-link :to="`/subcategory/${sub.id_subcategories}/tovars/${sub.id}`" >
                                            <img :src="sub.photo" alt="" class="image_tovar m-2">
                                        </router-link>
                                    </b-col>
                                </b-row>


                            </b-col>
                            <b-col cols="6" class="mt-3">
                                <div class="text-secondary mb-2" >Код: {{sub.article}}</div>
                                <router-link :to="`/subcategory/${sub.id_subcategories}/tovars/${sub.id}`" >
                                   <h5> {{sub.name}}</h5>
                                </router-link>
                            </b-col>
                            <b-col cols="3" class=" d-flex align-items-center justify-content-end ">
                               <h2 class=""> {{sub.pricein}} &#8381;</h2>
                            </b-col>

                        </b-row>
                        <b-row>
                            <b-col cols="3" class="align-items-center d-flex ">
                                <b-form-rating   v-model="sub.avg_rating" class="rating_star" readonly></b-form-rating>
                                <span><i class="far fa-comment"></i></span> &nbsp;<span>{{sub.count_review}} </span>

                            </b-col>
                            <b-col cols="9"  >
                                    <span id="btn_cart" ><b-button class="float-right ml-2 mb-3"  @click="addCart(sub)">
                                    В корзину
                            </b-button>
                                    </span>

                                <b-button @click="clearform" class="float-right" data-toggle="modal" data-target="#OneClick">
                                    В один клик
                                </b-button>
                                     <div class="modal fade" id="OneClick" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                           <div>
                                            <input-mask class="form-control" placeholder="Телефон" v-model="form.phone" mask="+7 (999) 999-99-99" />
                                               <b-alert v-if="error.phone" variant="danger" show>Укажите телефон в правильном формате</b-alert>
                                           </div>

                                          <label>Количество</label>
                                           <b-form-spinbutton  v-model="form.quantity" min="1" ></b-form-spinbutton>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                            <button type="button" @click=" addCartOneClick(sub.id)"  class="btn btn-danger">Заказать</button>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>

            </b-col>
        </b-row>


        </div>
        <footer_menu></footer_menu>
    </div>
</template>

<script>
import axios from "axios";
import {mapActions, mapGetters} from "vuex";
import Auth from "../../../helpers/Auth";

export default {


    data() {
        return {
            error:{
                phone:false,
            },
            form:{
                quantity:1,
                phone:''
            },
            filter_product:false,
            range: [],
            width: "100%",
            height: 4,
            dotSize: 25,
            minPrice: 0,
            maxPrice: 100000,
            disabled: false,
            show: true,
            useKeyboard: true,
            tooltip: "always",
            formatter: "{value}",
            overlapFormatter: "¥{value1} ~ ¥{value2}",
            bgStyle: {
                "backgroundColor": "#fff",
                "boxShadow": "inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)"
            },
            tooltipStyle: {
                "backgroundColor": "#666",
                "borderColor": "#666"
            },
            processStyle: {
                "backgroundColor": "#fc8507"
            },

            sort_down:true,
            sort_up:false,
            sort_name_down:true,
            sort_name_up:false,
            cats: [],
            tovars: [],
            sortedProducts: [],
            id_sub: this.$route.params['id'],
            sub: {
                id: '',
                id_subcategories:'',
                name:''
            },
            pagination: {},
            loading: true,
            errored: false,
            validationErrors: ''
        }
    },
    mounted() {

        this.getSub()
        this.UPDATE_SUBCATONE(this.id_sub)
        this.sortByCategories();

    },
    created() {
        this.$on('sendcat', cat => {
            this.cats.push(cat)
        })

    },
    computed: {
        ...mapGetters([
            'UPSUBCATONE',
            'UPCATEGORY'

        ]),

        filteredProducts() {
            if (this.sortedProducts.length>0) {

                return this.sortedProducts;
            }
            if (this.sortedProducts.length<1){

                return this.tovars;
            }

        },

    },
    methods: {
        ...mapActions([
            'UPDATE_SUBCATONE',
            'UPDATE_CATEGORIES'
        ]),

        addCart(item) {

            this.$store.commit('ADD_TO_CART', item);

        },
        clearform(){
            this.form.phone=''
            for (let er in this.error){
                this.error[er]=false;
            }

        },
        addCartOneClick(item) {
            for (let er in this.error){
                this.error[er]=false;
            }
            if(this.form.phone<10 || this.form.phone.includes('_')){
                this.error.phone=true;
                return false
            }
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
        setRangeSlider() {
            // this.filter_product=true;
            this.sortByCategories()
        },
        sortedList_Up() {
            if (!this.sortedProducts.length) {
                this.sortedProducts = this.tovars
                this.sortedProducts = _.sortBy(this.sortedProducts, 'pricein').reverse()

            } else {
                this.sortedProducts = _.sortBy(this.sortedProducts, 'pricein').reverse()
            }
            this.sort_up = false;
            this.sort_down = true;
        },
        sortedList_Down() {
            if (!this.sortedProducts.length) {
                this.sortedProducts = this.tovars
                this.sortedProducts = _.sortBy(this.sortedProducts, 'pricein')
            } else {
                this.sortedProducts = _.sortBy(this.sortedProducts, 'pricein')
            }
            this.sort_up = true;
            this.sort_down = false;

        },
        sorted_Name_List_Down() {
            if (!this.sortedProducts.length) {
                this.sortedProducts = this.tovars
                this.sortedProducts = _.sortBy(this.sortedProducts, 'name')
            } else {
                this.sortedProducts = _.sortBy(this.sortedProducts, 'name')
            }
            this.sort_name_up = true;
            this.sort_name_down = false;

        },
        sorted_Name_List_UP() {
            if (!this.sortedProducts.length) {
                this.sortedProducts = this.tovars
                this.sortedProducts = _.sortBy(this.sortedProducts, 'name').reverse()
            } else {
                this.sortedProducts = _.sortBy(this.sortedProducts, 'name').reverse()
            }
            this.sort_name_up = false;
            this.sort_name_down = true;

        },
        sortByCategories() {
            let vm = this;
            let result = false;
                this.sortedProducts = this.tovars
                this.sortedProducts = this.sortedProducts.filter(function (item) {
                    result = (item.pricein >= vm.range[0] && item.pricein <= vm.range[1])
                    return result
                   })
        },
        min_Price(){
            let min = {}
            min =_.minBy(this.tovars, 'pricein')
            return min.pricein
        },
        max_Price(){
            let max = {}
            max =_.maxBy(this.tovars, 'pricein')
            return max.pricein
        },
      getSub() {
           axios
                .get(`/api/subcategory/${this.$route.params['id']}/tovars`)
                .then(response => {
                    this.tovars = response.data
                    this.UPDATE_CATEGORIES(this.tovars[0].id_categories)
                    this.max_Price()
                    this.maxPrice=this.max_Price()
                    this.min_Price()
                    this.minPrice=this.min_Price()
                    this.range.push(this.min_Price())
                    this.range.push(this.max_Price())
                    console.log(this.range)
                    // this.value[1]=this.max_Price()
                    this.makePagination(response.data)

                })
                .catch(error => {
                    console.log(error)
                    this.errored = true;
                })
                .finally(() => this.loading = false)
        },
        makePagination(response) {
            let pagination = {
                current_page: response.current_page,
                last_page: response.last_page,
                prev_page_url: response.prev_page_url,
                next_page_url: response.next_page_url
            }

            this.pagination = pagination
        },



    }
}



</script>

<style scoped lang="scss">
@import "public/css/variables";
.product_list{
    padding-top: 1rem;
    padding-bottom: 1rem;
    padding-left: 7rem;
    padding-right: 7rem;
    margin-top: 1rem;
    background: $main_backgraund;
    button:hover{
        background: $btn_hover !important;
        //background: linear-gradient(315deg, #ff4e00 0%, #ec9f05 74%) !important;
    }
}
button {
    background: $main_color;
    width: 9rem;
}
a {
    text-decoration: none !important;
    color: black !important;
}
a:hover {
    color: $main_color !important;
}
.image_tovar {
    width: 8rem;
    height: 10rem;
}
/*.form-control {*/
/*    border-color: transparent;*/
/*    box-shadow: none;*/
/*    color: #c40000;*/
/*}*/

.modal {
    text-align: center;
}

@media screen and (min-width: 1000px) {
    .modal:before {
        display: inline-block;
        vertical-align: middle;
        content: " ";
        height: 50%;
    }
}

.modal-dialog {
    display: inline-block;
    text-align: left;
    vertical-align: middle;
}
.rating_star {
    border-color: transparent !important;
    box-shadow: none !important;
    color: $main_color ;
}


/*.range-slider {*/
/*    width: 200px;*/
/*    margin: auto 16px;*/
/*    text-align: center;*/
/*    position: relative;*/
/*}*/

/*.range-slider svg, .range-slider input[type=range] {*/
/*    position: absolute;*/
/*    left: 0;*/
/*    bottom: 0;*/
/*}*/

/*input[type=range]::-webkit-slider-thumb {*/
/*    !*-webkit-appearance: none;*!*/
/*    z-index: 0;*/
/*    width: 100%;*/
/*    position: relative;*/
/*    top: 2px;*/
/*    margin-top: -7px;*/
/*}*/

/*input[type=range] {*/
/*    !*-webkit-appearance: none; !* Скрывает слайдер, чтобы можно было создать свой *!*!*/
/*    width: 100%; !* Указание параметра ширины требуется для Firefox. *!*/
/*}*/

.vue-slider
{
    /*margin-top: 100px;*/
    /*background-color: #1b4b72 !important;*/
}







</style>
