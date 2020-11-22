<template>
<!--    подкатегории-->
    <div ref="subcategory">
        <mainmenu></mainmenu>
        <navbar></navbar>
        <div class="list_categories">
        <ol class="breadcrumb">
            <router-link  :to="`/`">
                <li > Главная </li>
            </router-link>
            <li >&#160; &#8212; &#160; </li>
          <li v-for="item in UPCATEGORY" :key="$route.fullPath">  {{item.category}}  </li>


        </ol>


        <b-row >
            <b-col v-for="item in UPCATEGORY" >
                <h3 >  {{item.category}} </h3>
            </b-col>
        </b-row>
        <b-row>

        <div v-if="errored" class="alert alert-danger" role="alert">
            Записи не загрузились, попробуйте позже:(
        </div>
            </b-row>
            <b-row>
            <b-col v-for="sub in SUBCAT"
                 :key="sub.id"
                 cols="4"
                 :category="sub"
                 class="subcat"
            >
                <router-link :to="`/subcategory/${sub.id}/tovars`"  >
                       <b-card
                         overlay
                         text-variant="white"
                         :category="sub"
                         :img-src="sub.photo"

                    >

                       <b-card-text >
                            {{sub.subcategori}}
                        </b-card-text>
                    </b-card>
                </router-link>
                </b-col>
            </b-row>


        </div>
        <footer_menu></footer_menu>
    </div>

</template>

<script>
import axios from "axios";
import {mapActions, mapGetters} from "vuex";
export default {
    name:"subcategory",
    data() {
        return {
            subcategories: [],
            id_sub: this.$route.params['id'],
            sub: {
                id: ''
            },
            pagination: {},
         loading: true,
            errored: false,
            validationErrors: ''
        }
    },
    created() {

    },
    mounted() {
        this.UPDATE_CATEGORIES(this.id_sub)
        this.GET_SUBCAT(this.id_sub)
        this.UPDATE_SUBCATONE(this.id_sub)

    },
    computed: {
        ...mapGetters([
            'SUBCAT',
            'UPCATEGORY',
            'UPSUBCATONE'
        ]),

},
    methods: {
        ...mapActions([
            'GET_SUBCAT',
            'UPDATE_CATEGORIES'
        ]),
        upcomponent(){
            this.$forceUpdate();
        },

        makePagination(response) {
            let pagination = {
                current_page: response.current_page,
                last_page: response.last_page,
                prev_page_url: response.prev_page_url,
                next_page_url: response.next_page_url
            }
            this.pagination = pagination
        }
    },
}


</script>

<style scoped  lang="scss">
@import "public/css/variables";
.list_categories{
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
    a:hover {
        color: $main_color !important;
    }
}

.subcat {
    margin-bottom: 20px;

    .card {
        width: 300px!important;
        height:320px!important;
        min-height:300px!important;
        .cart-img{
            width: 100% !important;
            height: 100% !important;
            padding: 10px;
        }
        .card-body:hover{
        opacity: 0.5!important;

        }
        .card-img{
            width: 100% !important;
            height: 100% !important;
        }
        .card-text{
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            width: 100%;
            background: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0)), to(#A0A0A0 ));
             position: absolute;
            bottom: 0;
            height: 50px;
            text-shadow: 1px 1px 4px #000;
            font-family: "Noto Sans", sans-serif;
        }
        .card-body{
            padding: 0!important;
            margin: 0!important;

        }


    }


    //.card_link {
    //    text-align: center;
    //    color: black;
    //    font-size: 16px;
    //    font-family: "Arial Black";
    //    position: relative;
    //    top: -40px;
    //    background: blue;
    //    height: 50px;
    //    width: 100%!important;
    //}

}
</style>
