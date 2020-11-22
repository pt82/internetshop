<template>
    <div class="admin_product">
        <h2>Товары</h2>
        <b-button @click="show_modal" data-toggle="modal" data-target="#ProductModal">
            Добавить
        </b-button>
<!--мод окно добавление товара-->
        <div class="modal fade" id="ProductModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <b-form-group>
                            <b-row class="mt-2">
                                <b-col cols="6">
                            <h6>Выберите категорию</h6>
                            <b-form-select
                                v-model="selected_category"
                                required
                                @change="select_category"
                            >
                                <option v-for="item in CATEGORIES" v-bind:value="item.id" :key="item.id">
                                    {{item.category}}
                                </option>
                            </b-form-select>
                                </b-col>
                                <b-col cols="6">
                            <h6 >Выберите подкатегорию</h6>
                            <b-form-select
                                v-model="selected_subcategory"
                                @change="select_subcategory"

                            >
                                <option v-for="item in SUBCAT" v-bind:value="item.id" :key="item.id">
                                    {{item.subcategori}}
                                </option>
                            </b-form-select>
                                </b-col>
                            </b-row>
                            <b-row class="mt-2">
                                <b-col cols="2">
                            <h6>Код</h6>
                            <b-form-input
                                v-model="form.article"

                            ></b-form-input>
                                </b-col>
                             <b-col cols="10">
                            <h6>Наименование</h6>
                            <b-form-input
                                v-model="form.product"

                            ></b-form-input>
                             </b-col>
                            </b-row>
                            <b-row>
                                <b-col cols="4">
                            <h6>Цена</h6>
                            <b-form-input

                                v-model="form.pricein"

                            ></b-form-input>
                                </b-col>
                                <b-col cols="4">
                            <h6>Остаток</h6>
                            <b-form-input

                                v-model="form.balance"

                            ></b-form-input>
                                </b-col>
                                <b-col cols="4">
                                    <h6>Основное изображение</h6>
                                    <b-form-file
                                        v-model="file"
                                        @change="onAttachmentChange"
                                        ref="profileimage"
                                        placeholder="Выберите файл..."
                                        drop-placeholder="Файл выбран..."
                                        browse-text="Обзор..."

                                    ></b-form-file>
                                </b-col>
                            </b-row>
                            <h6 class="mt-2">Описание</h6>
                            <b-form-textarea
                                v-model="form.desc"
                                rows="2"
                                >
                            </b-form-textarea>
                        </b-form-group>
                        <hr>

                       <div v-if="!button_product_visible">

                        <h6>Изображения для галереи</h6>
                           <b-row class="ml-1">
                               <b-col cols="7" class="image_list d-inline-flex" >
                           <div  v-for="image in IMAGES" :key="image.id" class="mr-1 d-flex flex-column">
                            <img :src="image.path" alt="" class="product_image">
                            <b-button @click="delimage(image.id)" class="btn-danger"><i class="far fa-trash-alt"></i></b-button>
                          </div>
                               </b-col>
                               <b-col cols="5" class="d-flex flex-column">
                             <b-form-group>
                               <b-form-file
                                   v-model="file_gallery"
                                   @change="onAttachmentChange_gallery"
                                   ref="imagegallery"
                                   placeholder="Выберите файл..."
                                   drop-placeholder="Файл выбран..."
                                   browse-text="Обзор..."

                               ></b-form-file>
                           </b-form-group>
                           <b-button @click="add_image_gallery" class="btn-success"><i class="fas fa-image "></i> Добавить изображение</b-button>
                               </b-col>
                           </b-row>

                       </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                            <button  type="button" @click="add_product()" v-show="button_product_visible" class="btn btn-primary">Добавить</button>
                            <button  v-show="!button_product_visible" type="button" @click="save_product()"  class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
<!--таблица товаров-->
        <vue-ads-table-tree
            :columns="columns"
            :rows="LISTTOVARS"
            :page="page"
            :start = 0
            :end = 3
            :items-per-page="5"
            @page-change="pageChanged"
            @filter-change="filterChanged"

        >
            <template slot="id" slot-scope="props" >
                <b-button @click="edit(props.row.id)" class="w-25  btn-success" data-toggle="modal" data-target="#ProductModal"> <i class="fas fa-pencil-alt "></i> </b-button>
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
            file_gallery:null,
            file: null,
            button_product_visible:null,
            attachment: null,
            attachment_gallery: null,
            selected_category: null,
            selected_subcategory:null,

            visible: false,
            form: {
                id_categories:'',
                id_subcategories: '',
                subcategory:'',
                category: '',
                id_product: '',
                product: '',
                article:'',
                desc:'',
                pricein:0,
                balance:0,
                  },
            errors: {},
            formedit: false,
            tableshow: true,

            page:0,
            image_table:[
                {
                    property: 'path',
                    title: 'Код',
                },
            ],
            columns:[
                {
                    property: 'article',
                    title: 'Код',
                    filterable: true,

                    sortable: true,
                    collapseIcon: true,
                },
                {
                    property: 'name',
                    title: 'Наименование',
                    filterable: true,

                    sortable: true,
                    collapseIcon: true,
                },
                {
                    property: 'pricein',
                    title: 'Цена',

                },
                {
                    property: 'balance',
                    title: 'Остаток',

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
            'SUBCAT',
            'LISTTOVARS',
            'TOVAR',
            'CATEGORIES',
            'IMAGES'

        ]),


    },
    mounted() {
        this.GET_CATEGORIES()
        this.GET_LIST_TOVAR()

    },

    methods: {
        ...mapActions([
            'GET_SUBCAT',
            'GET_LIST_TOVAR',
            'UPDATE_TOVARONE',
            'DEL_TOVAR',
            'GET_CATEGORIES',
            'GET_LIST_IMAGE',
            'DEL_IMAGE'
            ]),
        show_modal(){
            this.clear_form()
            this.button_product_visible=true;
        },

        pageChanged (page) {
            this.page = page;
        },
        filterChanged (filter) {
            this.filter = filter;
        },
        clear_form(){
            for (let i in this.form) {
                this.form[i]=''
            }
            this.selected_category=null
            this.selected_subcategory=null
            this.file=null
        },
// добавление картинки к товару
        add_image_gallery () {
            if (this.attachment_gallery) {
                let file = this.attachment_gallery;
                let data = new FormData();
                console.log(this.form.id_product)
                data.append("id_product", this.form.id_product);
                 data.append("imagegallery", file);
                axios.post(`/api/files`, data)
                .then(response => {
                    this.GET_LIST_IMAGE(this.form.id_product)
                });
                this.file_gallery=null;
            }
        },
        onAttachmentChange (e) {
            this.attachment = e.target.files[0]
        },
        onAttachmentChange_gallery (e) {
            this.attachment_gallery = e.target.files[0]
        },


        delimage(index) {
            this.DEL_IMAGE(index);
            this.GET_LIST_IMAGE(this.form.id_product)
        },

        formaddtovatshow(){
            this.formtovarvisible=true;
            this.formaaddtovar=true;
            this.tabletovar=false;
        },
        onRowDoubleClickCAT(params){

            this.form.category=params.row.category
            this.form.id_categories=params.row.id

        },
        onRowDoubleClickSUB(params){
            this.form.subcategory=params.row.subcategori
            this.form.id_subcategories=params.row.id
        },


        select_category(){
          this.GET_SUBCAT(this.selected_category)
          this.form.id_categories=this.selected_category

        },
        select_subcategory(){
            this.form.id_subcategories=this.selected_subcategory
        },

        onChange(index){
           this.GET_LIST_TOVAR(index)
        },
       //загружаем данные в форму редактирование
       async edit(index){
           this.button_product_visible=false;
          await this.UPDATE_TOVARONE(index)
              .then(response => {
                  this.GET_LIST_IMAGE(index);
                  const cs = this.TOVAR;
                  cs.forEach(i => {
                      this.form.id_product=i.id;
                      this.form.article = i.article;
                      this.form.product = i.name;
                      this.form.id_categories=i.id_categories;
                      this.form.id_subcategories=i.id_subcategories;
                      this.form.balance=i.balance;
                      this.form.pricein=i.pricein;
                      this.form.desc=i.desc;
                      this.selected_category=i.id_categories
                      this.selected_subcategory=i.id_subcategories;
                  });

                  // console.log(this.selected_subcategory)


                  }
              )


           this.formaaddtovar=true;
           this.tabletovar=false;
           this.formtovarvisible=true;
        },
        savetovar(){

        },

        del(index){
            this.DEL_TOVAR(index)
            this.GET_LIST_TOVAR();
        },

        add_product() {
             let data = new FormData();
             for (let i in this.form) {
                data.append(i, this.form[i]);
            }
            if (this.attachment) {
                let file = this.attachment;
                data.append("fileimage", file);
            }
              axios
                    .post(`/api/tovars`, data)
                    .then(response => {
                        console.log(response.data)
                            this.GET_LIST_TOVAR()
                            Auth.closeModal()

                    }
                        )
                         .catch(error => {
                        this.errors = error.response.data.errors;
                    });

        },

        save_product(){
            let data = new FormData();
            for (let i in this.form) {
                data.append(i, this.form[i]);
            }
            if (this.attachment) {
                let file = this.attachment;
                data.append("fileimage", file);
            }
            axios
                .post(`/api/product/${this.form.id_product}`, data)
                .then(response => {
                   console.log(response.data)
                    this.GET_LIST_TOVAR();
                    Auth.closeModal();

                    }
                )
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
            },

        listcategory() {
            this.GET_CATEGORIES()
        },

      //не используется, имя файла и его размер
       onFileChange(event) {
            if (event.target.files && event.target.files.length) {
                let file = event.target.files[0];
                this.formData.file = file;
                this.formData.displayFileName =
                    event.target.files[0].name +
                    " (" +
                    this.calcSize(file.size) +
                    "Kb)";
                let reader = new FileReader();
                reader.onload = e => {
                    this.formData.uploadFileData = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

         calcSize(size) {
            return Math.round(size / 1024);
        },

        uploadImage() {
            let data = new FormData();
            data.append("fupload", this.formData.file);

            axios.post("/api/upload_file", data).then(response => {
                this.showInfo("File was successfuly uploaded!");
                this.formData = {
                    displayFileName: null,
                    uploadFileData: null,
                    file: null
                };
            });
        },

    },
    showInfo(message) {
        this.$store.commit("showInfo", message);
    },


}
</script>
<style lang="scss" scoped>
.admin_product{
    padding-top: 1rem;
    padding-left: 0.5rem;
    padding-right: 1rem;

.input-field-file {
    display: none;
}
.card_tovar {
    border: #1f6fb2;
    border-radius: 5%;
}
.vue-ads-text-sm{
    max-width:400px;
}
.tovar_image {
    width: 100px;
    height: 100px;
}
.image_list {
    border:  1px solid #ced4da;
    border-radius: 5px;
    .product_image {
        margin-bottom: 5px;
        width: 3rem;
        height: 5rem;
    }
}
}
</style>

