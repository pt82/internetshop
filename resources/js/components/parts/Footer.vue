<template>
<div class="footer_menu">
    <hr>
    <b-row>
        <b-col cols="3">
            <router-link :to="`/`"
            >
                <img src="../../../../public/images/logo/logo.png" alt="" class="category_image ">
            </router-link>

        </b-col>
        <b-col cols="9">
            <b-row>
                <b-col cols="8">
                    <b-row>
                        <b-col cols="12">
                            <h4>Покупателям</h4>
                        </b-col>
                        <b-col cols="12">
                            <h5>Покупателям</h5>
                        </b-col>
                        <b-col cols="12">
                        <h5>Покупателям</h5>
                    </b-col>
                    </b-row>
                </b-col>
                <b-col cols="4">
                    <b-row>
                        <b-col cols="12">
                            <h4>Контакты</h4>
                        </b-col>
                        <b-col cols="12">
                            <h5>Покупателям</h5>
                        </b-col>
                        <b-col cols="12">
                        <h5>Покупателям</h5>
                    </b-col>
                    </b-row>
                </b-col>
            </b-row>
        </b-col>
    </b-row>
</div>
</template>

<script>
export default {
    name: "Footer"
}
</script>

<style scoped>
.footer_menu {
    padding-left: 7rem;
    padding-right: 7rem;
    margin-bottom: 3rem;
}
</style>
