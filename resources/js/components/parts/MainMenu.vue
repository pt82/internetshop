<template>
<div class="header_menu">
<!--мод окно регистрация-->
    <div class="register modal fade" id="onRegister"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <b-spinner class="reg_spinner"  variant="danger" v-show="spinnner" label="Loading..."></b-spinner>

                    <div>Регистрация</div>
                    <hr>
                    <b-form-group>
                        <b-form-input
                            type="text"
                            v-model="form.name"
                            placeholder="Имя"
                            required
                            autocomplete="off"
                        ></b-form-input>
                        <hr>
                        <b-form-input
                            type="email"
                            v-model="form.email"
                            placeholder="Электронная почта"
                            required
                            autocomplete="off"
                        ></b-form-input>

                        <hr>
                        <b-form-input
                            type="text"
                            v-model="form.phone"
                            placeholder="Телефон"
                            required
                            autocomplete="off"
                        ></b-form-input>
                        <hr>
                        <b-form-input
                            type="password"
                            v-model="form.password"
                            placeholder="Пароль"
                            required
                            autocomplete="off"
                        ></b-form-input>
                        <hr>
                        <b-form-input
                            type="password"
                            v-model="form.password_confirmation"
                            placeholder="Повтор пароля"
                            required
                            autocomplete="off"
                        ></b-form-input>
                        <hr>
                    </b-form-group>
                    <b-form-checkbox
                        v-model="form.consent"
                        name="checkbox"
                        value=1
                        unchecked-value=0
                    >
                        <h6>Даю согласие на обработку моих персональных данных</h6>
                    </b-form-checkbox>

                    <b-alert v-if="error.login" variant="danger" show>Пользователь c почтой {{form.email}} уже зарегистрирован</b-alert>
                    <b-alert v-if="error.all_input_reg" variant="danger" show>Заполните все поля</b-alert>
                    <b-alert v-if="error.password" variant="danger" show>Пароли не совпадают</b-alert>
                    <div class="modal-footer">

                        <button type="button" @click="cancel_reg" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="button" @click="onRegister()"  class="btn btn-danger">Зарегистрироваться</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!--        Мод окно Login-->
    <div class="register modal fade" id="onLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div>Вход в личный кабинет </div>
                    <hr>
                    <b-form-input
                        type="email"
                        v-model="form.email"
                        placeholder="Электронная почта"


                    ></b-form-input>
                    <hr>
                    <b-form-input
                        type="password"
                        v-model="form.password"
                        placeholder="Пароль"

                    ></b-form-input>

                    <b-alert v-if="error.auth" variant="danger" show>Неверный имя пользователя или пароль</b-alert>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="button" @click="onLogin()"  class="btn btn-danger">Войти</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

<!--    мод окно звонок-->
    <div class="register modal fade" id="ring" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div>Если у Вас есть вопросы - закажите звонок, наши менеджеры обязательно с Вами свяжутся! </div>
                    <hr>
                    <b-row>
                        <b-col cols="12">
                           <div>Ваше имя</div>
                        </b-col>
                        <b-col cols="12">
                    <b-form-input
                        type="text"
                        v-model="form_ring.name"
                        placeholder="Иванов Иван"
                    ></b-form-input>

                    </b-col>
                        <b-col cols="12" class="mt-2">
                            <span>
                                Телефон
                            </span>
                            <span class="text-danger">*</span>
                        </b-col>
                    <b-col cols="12">
                    <input-mask required
                                class="form-control"
                                placeholder="+7(ХХХ)ХХX-ХХ-ХХ"
                                v-model="form_ring.phone"
                                mask="+7(999)999-99-99"

                    />
                        <b-alert v-if="error.phone" variant="danger" show>Укажите телефон в правильном формате</b-alert>


                     </b-col>
                    </b-row>
                    <div class="modal-footer">
                        <button type="button" @click="clearform_ring" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="button" @click="ring" class="btn btn-danger">Заказать звонок</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <b-row >
        <b-col cols="3">
            <router-link :to="`/`"
            >
                <img src="../../../../public/images/logo/logo.png" alt="" class="category_image ">
            </router-link>

        </b-col>
        <b-col cols="9">
            <b-row>
                <b-col cols="12" >
                    <div class="float-right mt-2 d-inline-flex align-items-center ring"  >
                        <i class="fas fa-phone-volume"></i>&nbsp;
                        <a href=" tel: 88000000000">
                        8-(800)-000-00-00
                        </a>&nbsp;
                        Время работы операторов с 9:00 до 18:00 по Новосибирску
                        <button @click="clearform_ring" class="header_menu_ring"  data-toggle="modal" data-target="#ring">Заказать звонок</button>
                    </div>
                </b-col>
                <b-col cols="12">
                    <hr>
                </b-col>
                <b-col cols="8" class="d-inline-flex  h-100 mt-1 mb-2 items_menu">
                    <router-link :to="`delivery`"
                     class=" ml-1 mr-4">
                      Доставка
                    </router-link>
                    <router-link :to="`services`"
                    class=" mr-4">
                       Услуги
                    </router-link>
                    <router-link :to="`sales`"
                    class=" mr-4">
                       Акции
                    </router-link>
                    <router-link :to="`news`"
                    class=" mr-4">
                        Новости
                    </router-link>
                    <router-link :to="`contacts`"
                    class=" mr-4">
                       Контакты
                    </router-link>
                </b-col>
                <b-col cols="4" class="d-inline-flex " >
                                <div v-if="authNav[1].auth === auth.login" class="account">
                                 <div class=" mr-1"><i class="fas fa-user-alt"></i> </div>
                               <div @click="showModal()" data-toggle="modal" data-target="#onLogin" class="login" >
                                    {{authNav[1].title}}
                               </div>
                               <div> или </div>
                               <div @click="showModal()" data-toggle="modal" data-target="#onRegister" class="register">
                                   {{authNav[0].title}}
                               </div>
                                </div>
                    <div >
                    <b-nav-item-dropdown right v-if="auth.login"class="menu_profil float-right">
                        <template   v-slot:button-content>
                            <em class="user_name">{{ auth.name }}</em>
                        </template>
                        <b-dropdown-item @click="profile">Профиль</b-dropdown-item>
                        <b-dropdown-item @click="logOut()">Выход</b-dropdown-item>
                    </b-nav-item-dropdown>
                        </div>


                </b-col>
            </b-row>
        </b-col>
    </b-row>
</div>
</template>

<script>
import Auth from "../../helpers/Auth";
import {mapActions, mapGetters, mapState} from "vuex";

export default {
    name: "MainMenu",
    data() {
        return {
            error:{
             password: false,
             all_input_reg:false,
             login:false,
             phone:false,
             reg:false,
             auth:false,
            },
            spinnner:false,
            form_ring:{
                name:'',
                phone:''
            },
            form:{
                name:'',
                email:'',
                phone:'',
                password:'',
                password_confirmation:'',
                consent:null
            },
            errors:[],
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
            "",

        ]),
        auth() {
            return this.$store.state.Auth;
        },

        profileImage() {
            return this.$store.state.Auth.photo;
        },

    },
    created() {

    },

    methods: {

        clearform_ring(){
            for (let f in this.form_ring){
               this.form_ring[f]='';
            }
            for (let er in this.error){
                this.error[er]=false;
            }

        },
        onLogin() {
            this.error.reg=false;
            this.error.auth=false;
            if (this.form.email==='' || this.form.password===''){
                this.error.reg=true;
            }
            this.errors = {};
            axios
                .post("/api/login", this.form)
                .then(response => {
                    if (response.data.success) {
                        Auth.login(response.data.user);
                        Auth.closeModal();
                        if (response.data.user.role === 1) {
                            // this.$router.push("/");
                              this.$router.push("/admin/order");
                        }
                    }
                })
                .catch(error => {
                    if (error.response.status==422) {
                       this.error.auth=true;
                       return false;
                    }
                    this.errors = error.response.data.errors;
                });
        },

        ring(){

        for (let er in this.error){
            this.error[er]=false;
        }
            if(this.form_ring.phone<10 || this.form_ring.phone.includes('_')){
                this.error.phone=true;
                return false
            }

             axios
                .post(`/api/ring`, this.form_ring)
                 .then(response => {
                       Auth.closeModal();
                     if (response.data.success) {
                         this.$alert('Спасибо! С вами обязательно свяжутся.')
                     }
                 })
            .catch(error=>{
                if (error.response.status===422) {
                    this.error.phone=true;
                }
            })

        },
        cancel_reg(){
            this.error.password=false;
            this.error.all_input_reg=false;
            this.error.login=false;
        },
        showModal(){
            for (let i in this.error){
                this.error[i]=false;
                }
            this.form.password_confirmation=null
            this.form.password=null
            this.form.name=null
            this.form.email=''
            this.form.phone=''
            this.form.consent=null

        },
        onRegister() {
            for(let er in this.error){
                this.error[er]=false;
            }

            this.errors = {};

            if(this.form.name==='' || this.form.password==='' ||this.form.email==='' || this.form.phone==='' || this.form.password_confirmation==='' || this.form.consent===''){
                this.error.all_input_reg=true;
                return false;
            }
            if(this.form.password!==this.form.password_confirmation){
                this.error.password=true;
                return false;
            }
            this.spinnner=true;
            axios
                .post(`/api/register`, this.form)
                .then(response => {
                    this.spinnner=false;
                    Auth.closeModal();
                    if (response.data.success) {
                        this.form.password_confirmation=null
                        this.form.password=null
                        this.form.name=null
                        this.form.email=''
                        this.form.phone=''
                        this.form.consent=null
                        this.$alert('Спасибо за регистрацию! На почту ' +response.data.email+ ' отправлено письмо.')
                        for (let i in this.error){
                            this.error[i]=false;
                        }
                    }
                })
                .catch(error => {
                    if (error.response.status==422) {
                        this.spinnner=false;
                        this.error.login = true
                        return false;
                    }
                });
        },
        logOut(){
            axios.post('/api/logout')
                .then(response => {
                if (response.data.success) {
                    Auth.logout();
                    // this.$router.push(" ");
                }
            });
        },

    },

};
</script>

<style lang="scss" scoped>
@import "public/css/variables";
.user_name{
    color: black;
}
.reg_spinner{
    z-index: 999;
    position: absolute;
    top: 50%;
    left: 50%;
}
.account {
    display: flex;
    justify-content: center;
    align-items: center;
    .register {
        color: orangered;
        margin-left: 10px;
    }

    .login {
        margin-right: 10px;
    }

    .register:hover, .login:hover{
        cursor: pointer;
        color: orangered;
    }
}
.menu_profil{
    z-index: 10000;
    list-style-type: none;


}
.header_menu {
    padding-left: 7rem;
    padding-right: 7rem;
}
.header_menu .ring {
    font-size: 14px;

}
.header_menu .items_menu a{
    font-size: 18px;
    font-family: "Palatino Linotype";
    font-weight: bold;
    font-variant: small-caps;
    text-rendering: optimizeLegibility;
}
.header_menu .ring button{
    width: 90px;
    height: 23px;
    color: white;
    font-size: 10px;
    background-color: $main_color;
    border-radius: 10px;
    margin-left: 10px;
}
.header_menu .ring button:hover{
    animation:hide .5s ease-in-out 0s infinite alternate both;
}
@keyframes hide {
    0% {
        top:0; box-shadow:-1px -1px 3px red;
    }
    50% {
        top:-2px; box-shadow:1px 1px 3px red;
    }
    100% {
        top:2px; box-shadow:3px 3px 15px red;
    }
}
a {
    text-decoration: none;

    color: grey;
}
a:hover{
   color: orangered;
}
</style>
