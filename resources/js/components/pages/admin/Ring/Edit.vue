<template>
<div class="admin_ring_edit">
    <h2>Информация о звонке</h2>


        <b-row>
        <b-col cols="4">
            <div>Имя</div>
        </b-col>
            <b-col cols="4">
                <div>Телефон</div>
            </b-col>
            <b-col cols="4">
                <div>Статус</div>
            </b-col>
        <b-col cols="4">
            <b-form-input
                v-model="form.name"

            ></b-form-input>
        </b-col>
            <b-col cols="4">
                <b-form-input
                    v-model="form.phone"

                ></b-form-input>
            </b-col>
            <b-col cols="4">
                <b-form-select
                    v-model="selected_status"
                    required
                >
                    <option v-for="item in STATUSRING" v-bind:value="item.id" :key="item.id">
                        {{item.status}}
                    </option>
                </b-form-select>
            </b-col>
            <b-col cols="12" class="mt-2">
                <div>
                    Коментарий
                </div>
            </b-col>
            <b-col cols="12">
                <div>
                    <b-form-textarea

                        v-model="form.coment"
                        rows="3"
                        max-rows="6"
                    ></b-form-textarea>
                </div>
            </b-col>

          </b-row>
    <b-button @click="save_ring" class="btn-success mt-4">Сохранить</b-button>

</div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import axios from "axios";
export default {
    data() {
        return{
            selected_status:null,
            form:{
                name:'',
                phone:'',
                status_ring:'',
                coment:'',

            }
        }
    },
    computed: {
        ...mapGetters([
            'RING',
            'STATUSRING',
        ]),
    },
    created() {
        this.GET_RING(this.$store.state.id_rings)
            .then(()=> {
                     this.selected_status = this.RING[0].id_status_rings,
                    this.form.name = this.RING[0].name,
                    this.form.phone = this.RING[0].phone
                     this.form.coment = this.RING[0].coment
            })
        this.GET_STATUSRING()

    },
    methods: {
        ...mapActions([
            'GET_RING',
            'GET_STATUSRING'
        ]),
        save_ring(){
            let obj={};
            obj['id']=this.$store.state.id_rings;
            obj['id_status_rings']=this.selected_status;
            obj['name']=this.form.name;
            obj['phone']=this.form.phone;
            obj['coment']=this.form.coment;
            axios
                .post(`/api/upring`, obj)
                .then(response => {
                    this.$router.push({path: '/admin/rings/'})
                });
        }
    }
}
</script>


<style lang="scss" scoped>
.admin_ring_edit{
    padding-top: 1rem;
    padding-left: 0.5rem;
    padding-right: 1rem;
}
</style>
