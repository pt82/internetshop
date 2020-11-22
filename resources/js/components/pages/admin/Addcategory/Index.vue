<template>
    <div class="admin_category">
        <h2>Категории</h2>
        <b-button @click="show_modal" data-toggle="modal" data-target="#CategoryModal">
            Добавить
        </b-button>
<!--        мод окно добавление категории-->
        <div class="modal fade" id="CategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <b-form-group>
                            <h6>Наименование</h6>
                            <b-form-input
                                v-model="form.subcategory"
                              ></b-form-input>
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
                            <button  type="button" @click="add_category()" v-show="button_category_visible" class="btn btn-primary">Добавить</button>
                            <button v-show="!button_category_visible" type="button" @click="save_category()"  class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
<!--таблица категорий-->
        <vue-ads-table-tree
            :columns="columns"
            :rows="CATEGORIES"
            :page="page"
            :items-per-page="5"
            @page-change="pageChanged"
            @filter-change="filterChanged"
        >
            <template slot="id" slot-scope="props" >
                <b-button @click="edit(props.row.id)" class="w-25  btn-success" data-toggle="modal" data-target="#CategoryModal"> <i class="fas fa-pencil-alt "></i> </b-button>
                <b-button @click="delcat(props.row.id)"  class="w-25  btn-danger"> <i class="far fa-trash-alt"  ></i> </b-button>
            </template>
        </vue-ads-table-tree>



      </div>

</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import axios from "axios";
import {DateTime} from "luxon";
import Auth from "../../../../helpers/Auth";

export default {
    data ()  {
        return {
            button_category_visible:true,
            file:null,
            attachment: null,
            filter: '',

            form: {
                subcategory:'',
                id_category:'',
            },
            formedit: false,
            tableshow: true,

            page:0,
            columns:[
                {
                    property: 'category',
                    title: 'Наименование',
                    filterable: true,
                    direction: null,
                    sortable: true,
                    collapseIcon: true,
                },

                {
                    property:'id',
                    title: ''
                }
            ],
            categorione:[]
        }
    },

    computed: {
      ...mapGetters([
          'CATEGORIES',
          'UPCATEGORY'
      ]),

    },
    mounted() {
        this.GET_CATEGORIES()

    },

    methods: {
        ...mapActions([
            'GET_CATEGORIES',
            'DEL_CAT',
            'POST_CATEGORIES',
            'UPDATE_CATEGORIES',
            'SAVE_CATEGORY'
           ]),

        pageChanged (page) {
            this.page = page;
        },
        filterChanged (filter) {
            this.filter = filter;
        },

        show_modal(){
            this.clear_form()
            this.button_category_visible=true;
        },
        add_category(){
            if (this.attachment) {
                let file = this.attachment;
                let data = new FormData();
                  for (let i in this.form) {
                    data.append(i, this.form[i]);
                }
                data.append("fileimage", file);
                axios
                    .post(`/api/category`, data)
                    .then(response => {
                        this.GET_CATEGORIES();
                        this.clear_form()
                        Auth.closeModal()

                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    });
            }
        },

        async edit(item){
            this.button_category_visible=false;
            await this.UPDATE_CATEGORIES(item)
            const cs = this.UPCATEGORY;
            cs.forEach(i => {
                this.form.category = i.category;
                this.form.id_category=i.id;
            });

        },

//сохранить категорию
        save_category(){
            let data = new FormData();
            if (this.attachment) {
                let file = this.attachment;
                data.append("fileimage", file);
            }
            for (let i in this.form) {
                data.append(i, this.form[i]);
            }
            axios
                .post(`/api/category/${this.form.id_category}`, data)
                .then(response => {
                    this.GET_CATEGORIES();
                    this.clear_form()
                    Auth.closeModal()
                    this.button_event_visible=true

                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },


        onAttachmentChange (e) {
            this.attachment = e.target.files[0]

        },
        //очистка формы
        clear_form(){
            for (let i in this.form) {
                this.form[i]=''
            }
            this.file=null
       },
        //удалит категорию
        delcat(index){
            this.DEL_CAT(index)
            this.GET_CATEGORIES()

        },

      async  showcat(index){
           //  console.log('1')
            await this.UPDATE_CATEGORIES(index)
          const cs = this.UPCATEGORY;
          cs.forEach(i => {
              this.form.category = i.category;
              });

        },

            savecategory(index){
            if (this.attachment) {
                let file = this.attachment;
                let data = new FormData();
                for (let i in this.form) {
                    data.append(i, this.form[i]);
                }
                data.append("fileimage", file);
                console.log(data)
                axios
                    .post(`/api/category/${index}`, data)
                    .then(response => {
                        this.GET_CATEGORIES()
                        this.clearform();
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

       },


}
</script>
<style scoped lang="scss">
.admin_category
{
    padding-top: 1rem;
    padding-left: 0.5rem;
    padding-right: 1rem;
}
</style>
