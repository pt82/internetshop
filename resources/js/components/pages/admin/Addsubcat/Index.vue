<template>
    <div class="admin_subcat">
        <h2>Подкатегории</h2>
        <b-button @click="show_modal" data-toggle="modal" data-target="#SubCategoryModal">
            Добавить
        </b-button>
<!--        мод окно подкатегорий-->
        <div class="modal fade" id="SubCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <b-form-group>
                            <h6>Выберите категорию</h6>
                                    <b-form-select
                                        v-model="selected"
                                       required
                                    >
                                        <option v-for="item in CATEGORIES" v-bind:value="item.id" :key="item.id">
                                            {{item.category}}
                                        </option>
                                    </b-form-select>
                            <hr>

                            <h6>Наименование</h6>
                            <b-form-input
                                v-model="form.subcategory"
                                required
                            ></b-form-input>
                            <hr>
                            <b-form-file
                                v-model="file"
                                @change="onAttachmentChange"
                                ref="profileimage"
                                placeholder="Выберите файл..."
                                drop-placeholder="Файл выбран..."
                                browse-text="Обзор..."
                                required
                            ></b-form-file>
                            <hr>
                        </b-form-group>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                            <button  type="button" @click="add_subcategory()" v-show="button_subcategory_visible" class="btn btn-primary">Добавить</button>
                            <button v-show="!button_subcategory_visible" type="button" @click="save_subcategory()"  class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
<!--таблица подкатегорий-->
        <vue-ads-table-tree
            :columns="columns"
            :rows="SUBCATS"
            :page="page"
            :items-per-page="5"
            @page-change="pageChanged"
            @filter-change="filterChanged"
        >
            <template slot="id" slot-scope="props" >
                <b-button @click="edit(props.row.id)" class="w-25  btn-success" data-toggle="modal" data-target="#SubCategoryModal"> <i class="fas fa-pencil-alt "></i> </b-button>
                <b-button @click="del(props.row.id)"  class="w-25  btn-danger"> <i class="far fa-trash-alt"  ></i> </b-button>
            </template>
        </vue-ads-table-tree>
    </div>


</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import axios from "axios";
import Auth from "../../../../helpers/Auth";

export default {
    data ()  {
        return {
            file: null,
            button_subcategory_visible:true,
            attachment: null,
            selected: null,
            subcategories: [],
            formedit: false,
            tableshow: true,

            page:0,
            columns:[
                {
                    property: 'subcategori',
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

            form: {
                id_categories: '',
                id_subcategories: '',
                subcategory: '',
            }
        }
    },
    computed: {
        ...mapGetters([
            'CATEGORIES',
            'UPSUBCAT',
            'UPSUBCATONE',
            'SUBCATS'
        ]),
    },
    mounted() {
        this.GET_CATEGORIES()
        this.GET_SUBCATS()

    },
    methods: {
        ...mapActions([
            'GET_CATEGORIES',
            'UPDATE_SUBCAT',
            'DEL_SUBCAT',
            'UPDATE_SUBCATONE',
            'GET_SUBCATS',

        ]),
        pageChanged (page) {
            this.page = page;
        },
        filterChanged (filter) {
            this.filter = filter;
        },

        show_modal(){
            this.clear_form()
            this.button_subcategory_visible=true;
        },

        clear_form(){
            for (let i in this.form) {
                this.form[i]=''
            }
            this.selected=null
            this.file=null
        },

        //удалаяем подкат
        del(index) {
            this.DEL_SUBCAT(index)
            this.GET_SUBCATS()
           },

        //показывем список подкат от выбора в селекте катигории
        onChange(index){
            this.UPDATE_SUBCAT(index)

        },
        async  edit(index){
            this.button_subcategory_visible=false;
            await this.UPDATE_SUBCATONE(index)
            const cs = this.UPSUBCATONE;
            cs.forEach(i => {
                this.selected=i.id_categories
                this.form.subcategory = i.subcategori;
                this.form.id_categories=i.id_categories;
                this.form.id_subcategories=i.id;
            });
        },
        //сохранить подкатегории
        save_subcategory(){
            let data = new FormData();
            if (this.attachment) {
                let file = this.attachment;
                data.append("fileimage", file);
            }
            for (let i in this.form) {
                data.append(i, this.form[i]);
            }

            axios
                .post(`/api/subcategory/${this.form.id_subcategories}`, data)
                .then(response => {
                    this.GET_SUBCATS()
                    this.clear_form()
                    Auth.closeModal()
                    this.button_subcategory_visible=true
                    // if (response.data.success) {
                    //     console.log(response.data);
                    //     this.form.category = '';
                    //     this.$router.push("/");
                    // }

                })
        },

    //добавление подкатегории
        add_subcategory() {
        this.errors = {};
         this.form.id_categories=this.selected

            let data = new FormData();

            for (let i in this.form) {
                data.append(i, this.form[i]);
            }
            if (this.attachment) {
                let file = this.attachment;
                data.append("fileimage", file);
            }
        axios
            .post('/api/subcategory', data)
            .then(response => {
                Auth.closeModal()
                this.GET_SUBCATS()

            })
            .catch(error => {
                this.errors = error.response.data.errors;
            });
    },
        //оновляем категорию
        upcatsub(){
            this.form.id_categories=this.selected
            let index = this.UPSUBCATONE[0].id;

            let data = new FormData();

            for (let i in this.form) {
                data.append(i, this.form[i]);
            }
            if (this.attachment) {
                let file = this.attachment;
                data.append("fileimage", file);
            }
                axios
                    .post(`/api/subcategory/${index}`, data)
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

        },

        onAttachmentChange (e) {
            this.attachment = e.target.files[0]
         },


    },






}
</script>
<style scoped lang="scss">
.admin_subcat {
    padding-top: 1rem;
    padding-left: 0.5rem;
    padding-right: 1rem;
}
</style>
