<template>
   <div class="admin">
    <b-row class="admin_panel">
        <b-col cols="12" class="admin_header">
            <b-row>

                <b-col cols="2">
                    <router-link  :to="`/` " target= '_blank' >
                         На сайт
                    </router-link>

                </b-col>
                <b-col cols="8">
            <div >Панель управления</div>
                </b-col>
                <b-col cols="2">
                    <div><span>{{$store.state.Auth.name}} </span><span><b-button @click="logOut" class="btn_out"><i class="fas fa-sign-out-alt"></i></b-button></span></div>
                </b-col>
            </b-row>

        </b-col>

        <b-col cols="2" class="admin_left_menu">
        <sidebar></sidebar>
    </b-col>
        <b-col cols="10">
            <router-view></router-view>
        </b-col>
    </b-row>

   </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Auth from "../../../helpers/Auth";

export default {
    name: "Index",
    data() {
        return {}
    },
    beforeRouteEnter(to, from, next) {

        next(wm=> {
            if(window.store.state.Auth.role===1) {
                console.log('success');

            }
        })
    },
    methods: {
        ...mapActions([
            'GET_STATUSORDER'
        ]),
        logOut(){
            axios.post('/api/logout')
                .then(response => {
                    if (response.data.success) {
                        Auth.logout();
                        this.$router.push("/");
                    }
                });

        },
    },
   mounted() {
        this.GET_STATUSORDER
    }

}

</script>

<style lang="scss" scoped>
@import "public/css/variables";
.admin {
    //background: linear-gradient(to bottom, #669999 0%, #999966 100%);
    background: -webkit-linear-gradient(#E0E0E0 , #F8F8F8 ); /* Для Safari 5.1 - 6.0 */
    background: -o-linear-gradient(#E0E0E0 , #F8F8F8); /* Для Opera 11.1 - 12.0 */
    background: -moz-linear-gradient(#E0E0E0 , #F8F8F8 ); /* Для Firefox 3.6 - 15 */

    .admin_panel {
        a{
            text-decoration: none;
            color: white!important;
        }
        a:hover{
            color: $btn_hover!important;
        }
        .btn_out{
            background-color:transparent;

        }
        .admin_header {
            font-family: "Arial Black";
            font-size: 20px;
            background: linear-gradient(to bottom, #536878 0%, #738592 100%);
            color: white;
            padding-top: 1rem;
            padding-left: 3rem;
            padding-bottom: 1rem;

        }

        .admin_left_menu {
            padding-top: 1rem;
            padding-left: 1rem;

            height: 100vh;
            background: linear-gradient(to bottom, #91A3B0 0%, #738592 10%);
        }
    }
}
</style>
