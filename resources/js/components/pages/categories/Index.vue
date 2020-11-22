<template>
<div>

    <mainmenu></mainmenu>
    <navbar ></navbar>
    <carusel ></carusel>

   <div class="category">

    <b-row >
   <b-col class="cart_category " cols="4" v-for="item in CATEGORIES"
             :categogy="item.id"
             :key="item.id">

            <router-link :to="`/subcategory/${item.id}`" class="category_link"
                           >
                    <img  :src="item.photo" alt="" class="category_image">
                    <div  class="category_name">{{item.category}}</div>
            </router-link>

    </b-col>
</b-row>
   </div>
    <info></info>
    <footer_menu></footer_menu>
</div>
</template>

<script>
import axios from "axios";
import {mapActions, mapGetters} from "vuex";
export default {
    data() {
        return {
            categories: [],
            category: {
                id: ''

            },
            sortedSub:[],
            pagination: {},
            loading: true,
            errored: false,
            validationErrors: '',
            form: {
                category: null,

            }
        }
    },
    computed: {
        ...mapGetters([
            'CATEGORIES',
            'SUBCATS'
        ]),
        filteredSubCatalog() {
            return  this.sortedSub;
        },
    },
    mounted() {

    },
    methods: {
        ...mapActions([
            'GET_CATEGORIES',
            'GET_SUBCATS',
        ]),
        mouseOver(id){
            this.sortedSub = _.filter(this.SUBCATS, {id_categories: id});
            console.log(this.sortedSub)
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

        showCat(id) {
            axios
                .get(`/api/category/${id}`)
                .then(response => {
                    this.getCategories()
                    console.log(response)
                })
                .catch(error => console.log(error))
        },
        addcategory() {
            this.errors = {};

            // const str = JSON.stringify(this.form);
            axios
                .post(`api/addcategory`, this.form)
                .then(response => {

                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        }

    }
}



</script>

<style scoped lang="scss">
@import "public/css/variables";
.category {
    padding-left: 7rem;
    padding-right: 7rem;
}
.cart_category{
    width: 100%;
    background-color: #ffffff;
    text-decoration: none;
    height: 100%;
}
.category_link {
    display: flex;
    flex-flow: row nowrap;
    height: 100%;
    font-size: 14px;
    justify-content: left;
    align-items: center;
    text-decoration: none !important;
    margin-top: 3rem;
    margin-bottom: 3rem;

}
.category_image {
    margin-left: 10px;
    height: 130px;
    width: 150px;
}
.category_image:hover{
    -webkit-transform: scale(1.2);
    -ms-transform: scale(1.2);
    transform: scale(1.2);
    -webkit-filter: saturate(350%);
    filter: saturate(350%);
}
.category_name{
    margin-left: 30px;

    font-family: "Arial Black";
    color: grey;
    font-size: 20px;


}
.category_name:hover {
    color: orangered;
    -webkit-transform: scale(1.08);
    -ms-transform: scale(1.08);
    transform: scale(1.08);
}
.menu_header{
    box-sizing: border-box;
}

</style>
