<template>
    <div>
        <mainmenu></mainmenu>
        <navbar ></navbar>
        <div class="services">
           <b-row>
               <b-col cols="12">
              <div class="services_title">
                  Услуги
              </div>
               </b-col>
               <b-col cols="12">
                   <div class="services_title-block">
                       Сеть магазинов "InternetShop" заботится о создании максимального комфорта для своих клиентов и предлагает качественный сервис.
                       Мы предоставляем нашим покупателям следующие услуги:
                   </div>
               </b-col>
           </b-row>
            <b-row class="mb-3">
                <b-col cols="3" class="mb-3">
                    <img v-bind:src="'images/service/service1.jpg'" alt="" class="services_img">
                </b-col>

                <b-col cols="7">
                    <div class="services_item">
                    1. Консультации персонала - наши клиенты могут не только выбрать товар, но и получить квалифицированные консультации по применению и характеристикам товара.
                    </div>
                </b-col>
            </b-row>

            <b-row class="mb-3">
                <b-col cols="3">
                    <img v-bind:src="'images/service/service2.png'" alt="" class="services_img">
                </b-col>

                <b-col cols="7">
                    <div class="services_item">
                        2. Доставка - в магазине "InternetShop" осуществляется платная и бесплатная доставка. Подробнее о стоимости доставки уточняйте у менеджера, оформляющего Ваш заказ.
                    </div>
                </b-col>
            </b-row>





        </div>
        <footer_menu></footer_menu>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped lang="scss">
.services{
    padding-top: 1rem;
    padding-bottom: 1rem;
    padding-left: 7rem;
    padding-right: 7rem;
    margin-top: 1rem;
    background-color: #f8f9fa;
    .services_title{
        font-family: Gilroy, sans-serif;
        font-size: 50px;
        line-height: 1;
        font-weight: 800;

    }
    .services_title-block{
        margin-top: 2rem;
        margin-bottom: 2rem;
        font-family: "Noto Sans", sans-serif;
        font-size: 20px;
    }
    .services_img{
        width: 300px;
        height: 200px;
    }
    .services_item{
        font-family: "Noto Sans", sans-serif;
        font-size: 20px;
    }
}
</style>
