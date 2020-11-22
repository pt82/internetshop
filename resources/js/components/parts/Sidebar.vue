<template>
   <div>
       <router-link :to="'/admin/order'" class = "menu-left_card" >
           <button class="btn_left_menu">
               <i class="fas fa-box " ></i>
               <div>
                   Заказы <span v-if="COUNT_NEW_ORDER>0" class="text-success"> ({{COUNT_NEW_ORDER}})</span>
               </div>
           </button>
       </router-link>

       <router-link :to="'/admin/rings'" class = "menu-left_card" >
           <button class="btn_left_menu">
               <i class="fas fa-phone-volume "></i>

               <div>
                   Звонки
                   <span v-if="COUNT_NEW_RING>0" class="text-success">
                       ({{COUNT_NEW_RING}})
                   </span>
               </div>
           </button>
       </router-link>

    <router-link :to="'/admin/category'" class = "menu-left_card">
       <button class="btn_left_menu" id="cat" >
        <i class="fas fa-book-open "></i>
        <div>
            Категории
        </div>
       </button>
    </router-link>
       <router-link :to="'/admin/addsubcat'" class = "menu-left_card">
           <button class="btn_left_menu" >
               <i class="fas fa-boxes "></i>
               <div>
                  Подкатегории
               </div>
           </button>
       </router-link>
       <router-link :to="'/admin/addtovar'" class = "menu-left_card" >
           <button class="btn_left_menu" >
               <i class="far fa-list-alt  "></i>
               <div>
                  Товары
               </div>
           </button>
       </router-link>

             <router-link :to="'/admin/addevent'" class = "menu-left_card" >
                 <button class="btn_left_menu">
                     <i class="far fa-newspaper "></i>
                     <div>
                        Акции
                     </div>
                 </button>
       </router-link>

   </div>
</template>
<script>
import {mapActions, mapGetters} from "vuex";
export default {
name: "Index",
data() {
return {

    }
    },
    computed: {
        ...mapGetters([
            'COUNT_NEW_ORDER',
            'COUNT_NEW_RING'
        ]),

    },
    methods:{
        active_btn() {
            document.querySelector('.btn_left_menu').addEventListener('click', function () {
                this.classList.toggle("activated");

            })
        }
    }
}
</script>
<style lang="scss" scoped>
.menu-left_card {

    font-size: 18px;
    display: flex;

    flex-direction: column;
    justify-content: center;
    align-items: center;
    .btn_left_menu{
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
      border: none;
        margin-top: 0.5rem;
        border-radius: 10px;
        margin-left: 1rem;
        width: 80%;
        color: white;
    }
    .btn_left_menu:hover{
        background:  radial-gradient(farthest-side ellipse at top left, #A0B2BF, #8294A1);
        box-shadow: 2px 4px 4px rgba(0, 0, 0, 0.8);
    }
    .activated {  //background:  radial-gradient(farthest-side ellipse at top left, #738595, #8294A1);
        //-webkit-box-shadow: 2px 4px 2px rgba(0, 0, 0, 0.8);
    -moz-box-shadow: inset 1px 1px 1px 1px rgba(41, 38, 38, 1);
    box-shadow: inset 1px 1px 1px 1px rgba(41, 38, 38, 1);

    //box-shadow: -5px 5px 10px rgba(0,0,0,0.2);
    //box-shadow: inset 2px 2px 5px rgba(0,0,0,0.2), 1px 1px 5px rgba(0,0,0,0.2);

    /*Градиент*/

    background-image: -webkit-linear-gradient(bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.4));
    background-image: -moz-linear-gradient(bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.4));
    background-image: -o-linear-gradient(bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.4));
    background-image: -ms-linear-gradient(bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.4));
    background-image: linear-gradient(bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.4));
    outline: none;
}

    .btn_left_menu:focus{
        background:  radial-gradient(farthest-side ellipse at top left, #738595, #8294A1);
        -webkit-box-shadow: 2px 4px 2px rgba(0, 0, 0, 0.8);
        //-moz-box-shadow: inset 1px 1px 1px 1px rgba(41, 38, 38, 1);
        -moz-box-shadow: inset 1px 1px 1px 1px rgba(41, 38, 38, 1);
        box-shadow: inset 1px 1px 1px 1px rgba(41, 38, 38, 1);
        //box-shadow: inset 1px 1px 1px 1px rgba(41, 38, 38, 1);
        //box-shadow: -5px 5px 10px rgba(0,0,0,0.2);
        //box-shadow: inset 2px 2px 5px rgba(0,0,0,0.2), 1px 1px 5px rgba(0,0,0,0.2);

                /*Градиент*/

        background-image: -webkit-linear-gradient(bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.4));
        background-image: -moz-linear-gradient(bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.4));
        background-image: -o-linear-gradient(bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.4));
        background-image: -ms-linear-gradient(bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.4));
        background-image: linear-gradient(bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.4));
        outline: none;
    }
    .btn_left_menu:active{
        ////transform: rotate(360deg);
        //color: rebeccapurple;
    }
}
</style>
