<template>
    <div class="rings">
        <h2>Звонки</h2>

        <vue-ads-table-tree
            :columns="columns"
            :rows="RINGS"
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
import {mapActions, mapGetters} from 'vuex';
import axios from "axios";

import Auth from "../../../../helpers/Auth";
export default {

    data() {
        return{
            page:0,
            columns:[
                {
                    property: 'status',
                    title: 'Статус',


                },
                {
                    property: 'name',
                    title: 'Имя',
                    filterable: true,

                },
                {
                    property: 'phone',
                    title: 'Телефон',

                },

                {
                    property: 'coment',
                    title: 'Коментарий',

                },

                {
                    property:'id',
                    title: ''
                }
            ],
        }
    },
    computed: {
        ...mapGetters([
            'RINGS',

        ]),
    },
        created(){
        this.GET_RINGS();
        },
        methods:{
            ...mapActions([
                'GET_RINGS',
            ]),
            pageChanged (page) {
                this.page = page;
            },
            filterChanged (filter) {
                this.filter = filter;
            },
            edit(index){
                this.$store.state.id_rings=index;
                this.$router.push({path:'/admin/ring/'+index});
            },
        },



}
</script>

<style lang="scss" scoped>
.rings {
    padding-top: 1rem;
    padding-left: 0.5rem;
    padding-right: 1rem;
}
</style>
