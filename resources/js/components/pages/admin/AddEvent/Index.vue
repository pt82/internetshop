<template>
    <div class="admin_event">
        <h2>Акции</h2>


        <b-button @click="show_modal" data-toggle="modal" data-target="#myModal">
            Добавить
        </b-button>
<!--        мод окно акций-->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <b-form-group>
                            <b-form-input
                                v-model="form.event_name"
                                placeholder="Название акции"
                            ></b-form-input>
                            <hr>
                            <b-form-input
                                v-model="form.link"
                                placeholder="Ссылка"
                            ></b-form-input>
                            <hr>
                            <h6>Начало акции</h6>
                            <datetime class="border" v-model="form.data_begin" type="date"></datetime>

                            <hr>
                            <hr>
                            <h6>Окончание акции</h6>
                            <datetime class="border" v-model="form.data_end"  type="date"></datetime>
                            <hr>
                            <b-form-checkbox
                                id="checkbox-1"
                                v-model="form.active"
                                name="checkbox"
                                value=1
                                unchecked-value=0
                            >
                                <h6>Действующая</h6>
                            </b-form-checkbox>
                            <hr>
                            <b-form-file
                                v-model="file"
                                @change="onAttachmentChange"
                                ref="profileimage"
                                placeholder="Выберите файл..."
                                drop-placeholder="Файл выбран..."
                                browse-text="Обзор..."
                            ></b-form-file>
                            <hr>
                        </b-form-group>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                            <button  type="button" @click="add_event()" v-show="button_event_visible" class="btn btn-primary">Добавить</button>
                            <button v-show="!button_event_visible" type="button" @click="save_event()"  class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>


<!--таблица акций-->
        <vue-ads-table-tree
            :columns="columns"
            :rows="EVENTS"
            :page="page"
            :items-per-page="3"

            @page-change="pageChanged"
            @filter-change="filterChanged"
        >
            <template slot="link" slot-scope="props">
                <router-link :to="`${props.row.link}`" class="category" target= '_blank'
                >
                    <b-button class="btn-primary  " > <i class="fas fa-hand-point-up w-100 " ></i></b-button>
                </router-link>
            </template>
            <template slot="id" slot-scope="props" >
                <b-button @click="edit(props.row.id)" class="w-25 ml-3 btn-success" data-toggle="modal" data-target="#myModal"> <i class="fas fa-pencil-alt "></i> </b-button>
                <b-button @click="del(props.row.id)"  class="w-25 ml-3 btn-danger"> <i class="far fa-trash-alt"  ></i> </b-button>
            </template>
        </vue-ads-table-tree>




    </div>
</template>

<script>

import {mapActions, mapGetters} from "vuex";
import axios from "axios";
import Auth from "../../../../helpers/Auth";
import { DateTime } from 'luxon';
export default {

    name: "Index",


    data () {
        return {
            form:{
                event_name:'',
                link:'',
                data_begin: null,
                data_end: null,
                active:null,
                event_id:null

                },
            file:null,
            attachment: null,
            button_event_visible:null,
            page:0,
            columns:[
                {
                    property: 'event_name',
                    title: 'Наименование',
                    filterable: true,
                    sortable: true,
                    collapseIcon: true,
                },
                {
                    property: 'data_begin',
                    title: 'Начало',
                },
                {
                    property: 'data_end',
                    title: 'Конец',
                },


                {
                    property:'id',
                    title: ''
                }
            ]
        }
    },
    computed:{
        ...mapGetters([
            'EVENTS',
            'EVENT'
        ]),
    },
    mounted() {
       this.GET_EVENTS()
        console.log(this.EVENTS)
    },
    methods: {
        ...mapActions([
            'GET_EVENTS',
            'SHOW_EVENT',
            'DEL_EVENT'
        ]),
        pageChanged (page) {
            this.page = page;
         },
        filterChanged (filter) {
            this.filter = filter;
        },
        //редактирование
        async edit(item){
            this.button_event_visible=false;
            await this.SHOW_EVENT(item)
            const ev = this.EVENT;
            ev.forEach(i => {
                this.form.event_name=i.event_name;
                this.form.link=i.link;
                this.form.active=i.active;
                this.form.data_begin=i.data_begin;
                this.form.data_end=i.data_end;
                this.form.event_id=i.id;
                });
            },
        //сохранение
        save_event(){
            let data = new FormData();
            if (this.attachment) {
                let file = this.attachment;
                data.append("fileimage", file);
            }
            this.form.data_begin=DateTime.fromISO(this.form.data_begin).toFormat('yyyy-MM-dd')
            this.form.data_end=DateTime.fromISO(this.form.data_end).toFormat('yyyy-MM-dd')

            for (let i in this.form) {
                data.append(i, this.form[i]);
            }

            // console.log(DateTime.fromISO(this.form.data_begin).toFormat('hh::mm'))
            axios
                .post(`/api/event/${this.form.event_id}`, data)
                .then(response => {
                    this.GET_EVENTS()
                    this.clear_form()
                    Auth.closeModal()
                    this.button_event_visible=true
                    // if (response.data.success) {
                    //     console.log(response.data);
                    //     this.form.category = '';
                    //     this.$router.push("/");
                    // }

                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
          },

        del(item){
            this.DEL_EVENT(item)
            this.GET_EVENTS()
        },

        show_modal(){
            this.clear_form()
            this.button_event_visible=true;
        },

        add_event(){
            if (this.attachment) {
                let file = this.attachment;
                let data = new FormData();
                this.form.data_begin=DateTime.fromISO(this.form.data_begin).toFormat('yyyy-MM-dd')
                this.form.data_end=DateTime.fromISO(this.form.data_end).toFormat('yyyy-MM-dd')
                console.log(this.form.data_end)
                for (let i in this.form) {
                    data.append(i, this.form[i]);
                }
                data.append("fileimage", file);
                // console.log(DateTime.fromISO(this.form.data_begin).toFormat('hh::mm'))
                axios

                    .post(`/api/event`, data)
                    .then(response => {
                        this.GET_EVENTS()
                        this.clear_form()
                        Auth.closeModal()
                        if (response.data.success) {
                            console.log(response.data);
                            this.form.category = '';
                            this.$router.push("/");
                        }

                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    });
            }
        },
        onAttachmentChange (e) {
            this.attachment = e.target.files[0]

        },

        clear_form(){
            for (let i in this.form) {
                this.form[i]=''
            }
            this.file=null

        },

    },

}
</script>

<style scoped lang="scss">
    .admin_event{
        padding-top: 1rem;
        padding-left: 0.5rem;
        padding-right: 1rem;
    }
</style>
