<template>
<div>
    <mainmenu></mainmenu>
    <navbar ></navbar>
    <div class="delivery">
        <b-row>
           <b-col cols="12">
        <div class="delivery_title">
            Как купить?
        </div>
           </b-col>
            <b-col cols="6">
                <div class="mt-4 delivery_title-block">
                    <i class="fas fa-boxes text-danger"></i> <span class=""> Заказать доставку:</span>
                </div>
                <div class="delivery_block-sub">Стоимость доставки из пункта выдачи: </div>
                <ul>
                    <li>
                      по г.Новосибирск 300 руб.
                    </li>
                    <li>
                        Академгородок 500 руб.
                    </li>
                    <li>
                        По области от 1500 до 2000 руб.
                    </li>
                </ul>
            </b-col>
            <b-col cols="6">
                <div class="mt-4 delivery_title-block">
                Забрать заказанный товар в одном из наших пунктов выдачи:
                </div>
                <ul>
                    <li>
                        г.Новосибирск ул. Советская, 5
                    </li>
                    <li>
                        г.Новосибирск ул. Ленина, 50
                    </li>
                    <li>
                        г.Новосибирск ул. Ленинградкая, 10
                    </li>
                </ul>
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
.delivery{
    padding-top: 1rem;
    padding-bottom: 1rem;
    padding-left: 7rem;
    padding-right: 7rem;
    margin-top: 1rem;
    background-color: #f8f9fa;
    .delivery_title{
        font-family: Gilroy, sans-serif;
        font-size: 50px;
        line-height: 1;
        font-weight: 800;

    }
    .delivery_title-block{
        font-family: "Noto Sans", sans-serif;
        font-size: 20px;
    }
    .delivery_block-sub{
        margin-bottom: 25px;
        margin-top: 25px;
        margin-left: 25px;
        //font-family: "Noto Sans", sans-serif;
        font-size: 16px;
    }

}
</style>
