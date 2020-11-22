<template >
        <div class="main_menu mt-2">
        <b-row >
            <b-col cols="3">
               <b-button  class="btn_catalog" @click="toggleCatalog"><i class="fas fa-book" ></i> КАТАЛОГ ТОВАРОВ</b-button>
                <div  v-show="CatalogVisible" class="mt-5">

                <router-link   @click="toggleCatalog" :to="`/subcategory/${item.id}`"  class="catalog d-flex align-items-center"  v-for="item in CATEGORIES " :key=item.id >
                      <img @click="toggleCatalog"  @mouseover="mouseOver(item.id)" :src="item.photo" alt="" class="catalog_category_image">
                      <div @click="toggleCatalog" @mouseover="mouseOver(item.id)">{{item.category}}</div>
                </router-link>

                </div>
            </b-col>
            <b-col cols="9">
                     <b-row >
                       <b-col cols="7" class="float-left">
                           <b-input type="text" v-model="keywords" placeholder="ПОИСК" class="search_input"></b-input>
                               <div v-if="results.length>0" class="search">
                                   <div v-for="item in results" :key="item.id" class="search_item mt-1 pl-2 pt-1 pr-2" >
                                       <div @click="in_product(item)" v-html="hightext(item.name)"  ></div>
                                  </div>

                               </div>
                       </b-col>
                       <b-col cols="2" class="cart d-flex align-items-center" >
                         <router-link  :to="`/cart/`" class="d-inline-flex">
                              <div v-if="countcart || countcart.length>0" class="count_product">{{$store.state.cartCount}}</div>
                             <div><i id="cart_icon" class="fas fa-dolly-flatbed fa-lg cart_icon mr-2"></i>Корзина</div>
                         </router-link>

                       </b-col>
                         <b-col cols="2">

                       </b-col>
                        </b-row>


                <b-row class="mt-3" v-show="CatalogVisible">

                   <b-col class="catalog_subcategory" v-for="item in filteredSubCatalog" :key="item.id" cols="4">
                       <router-link   :to="`/subcategory/${item.id}/tovars`">
                           <b-row class="catalog_subcategory_item">
                               <b-col cols="5" >
                       <img  @click="toggleCatalog" :src="item.photo" alt="" class="catalog_subcategory_image">
                               </b-col>
                   <b-col cols="7" class="catalog_subcategory_item ">
                       <span @click="toggleCatalog" >{{item.subcategori}}</span>
                   </b-col>
                           </b-row>
                       </router-link>
                   </b-col>
                </b-row>
            </b-col>
        </b-row>



    </div>

</template>

<script>
import {mapActions, mapState, mapGetters} from "vuex";
 import Auth from '../../helpers/Auth';


export default {

    data() {
        return {
            ops: {
                vuescroll: {},
                scrollPanel: {},
                rail: {},
                bar: {}
            },
            sortedSub:[],
            filterSubCatalog:false,
            CatalogVisible:false,
            active: null,
            keywords: null,
            results: [],
            form:{
                name:'',
                email:'',
                phone:'',
                password:'',
                password_confirmation:'',
                consent:null
            }
        };
    },


    computed: {
        ...mapState([
            "info",
            "nav",
            "authNav",
            "profileNav",

            ]),

        ...mapGetters([
            "LISTTOVARS",
            "CATEGORIES",
            "SUBCATS"

        ]),
        countcart(){
          return window.store.state.cartCount;
        },
        filteredSubCatalog() {
             return  this.sortedSub;
             },
        auth() {
            return this.$store.state.Auth;
        },

        profileImage() {
            return this.$store.state.Auth.photo;
        },

    },
    mounted() {
        Auth.init();
        this.GET_CATEGORIES();
        this.GET_LIST_TOVAR();
        this.GET_SUBCATS();
    },
    watch: {
        keywords(after, before) {
            this.fetch();
        },
      },


    methods: {
        ...mapActions([
            'GET_LIST_TOVAR',
            'GET_SUBCATS',
            'GET_CATEGORIES'
        ]),




        mouseOver(id){

            this.sortedSub = _.filter(this.SUBCATS, {id_categories: id});

        },

        toggleCatalog(){
            this.CatalogVisible=!this.CatalogVisible


        },

        clearform(){

        },

        logOut(){
            Auth.logout()
        },

        hightext(item) {
            return item.replace(new RegExp(this.keywords, 'gi'), '<span style="font-weight: bold; color: #ff4500">$&</span>');
        },

        fetch() {
            axios.get(`/api/search/${this.keywords}`)
                .then(response => {
                    if (this.keywords.length){
                        this.results = response.data
                    }
                    else
                    {this.results = []}

                       })
                .catch(error => {});
        },

        in_product(item){
           if(this.keywords==="")
           {
               this.results = []
           }

            this.$router.push({path:'/subcategory/'+item.id_subcategories+'/tovars/'+item.id});
            this.results = []
            this.keywords=""
        },
        onClick(item) {
            if (item.path !== "/logout") {
                this.$router.push(item.path);
                return true;
            }
            axios.post('/api/logout').then(response => {
                if (response.data.success) {
                    Auth.logout();
                    this.$router.push(" ");
                }
            });
        }
    },
   };

</script>

<style lang="scss" scoped>
@import "public/css/variables";
.catalog_subcategory {
    .catalog_subcategory_image {
        width: 5rem;
        height: 6rem;
        margin-top: 20px;

    }

    .catalog_subcategory_item {
       font-family: "Arial Black";
       color: grey;
        font-size: 16px;
        position: relative;
        left: -20px;
        margin-top: auto;
        margin-bottom: auto;
        }


}
.catalog_subcategory:hover{
    .catalog_subcategory_item {
        color: $main_color;
    }
}
.catalog {
    font-family: "Arial Black";
    padding-top: 1rem;
    overflow:auto;
    height: 70px;
    color: grey;

    a{
        text-decoration: none;

    }
 .catalog_item{
     font-size: 20px;

    }
    .catalog_category_image{
        height: 3rem;
        width: 3rem;
        margin-right: 5px;
    }
}
.catalog:hover {
    -webkit-transform: scale(1.1);
    -ms-transform: scale(1.1);
    transform: scale(1.1);
    -webkit-filter: saturate(350%);
    filter: saturate(350%);
    color: $main_color;
}
 .search {
    width: 100%;
    position:absolute;
    z-index: 9999;
    background-color: white ;
}

 .search_input {
     height: 3rem;
     font-size: 16px;

 }

.search .search_item {
    /*border: 1px  black!important;*/


}
.search .search_item:hover{
    cursor: pointer;
    color: orangered;
    /*font-size: 120%;*/
}
.main_menu{
    background-color: white;
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    padding-left: 7rem;
    padding-right: 7rem;
    z-index: 100 !important;
    .cart {
        height: 3rem;
        width: 100%;
        a:hover{
            color: $main_color !important;
        }
        a{
            color: grey !important;
        }
        .count_product {
            position: relative;
            display: inline-block;
            width: 15px;
            height: 15px;
            top:-5px;
            left: 30px;
            z-index: 100;
            color: white;
            background-color: orangered;
            border-radius: 50%;
            font-size: 10px;
            text-align: center;

        }
        .cart_icon{
            color: grey;
        }
    }
    .btn_catalog:hover{
     background: $btn_hover;

    }
}
 .main_menu .btn_catalog{
     width: 100%;
     height: 3rem;
     background-color: orangered;
     float: left !important;
     font-size: 14px !important;
     font-family: "Arial Black";
 }






</style>
