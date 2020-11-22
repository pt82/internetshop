<template>
<div class="catalog">
    <div v-for="item in LISTTOVARS" v-if="CatalogVisible">
        <h1>123</h1>
        {{item.id}}
    </div>
</div>

</template>

<script>
import {mapActions, mapState, mapGetters} from "vuex";
import Auth from '../../helpers/Auth';
export default {
    name: "Catalog",
    data() {
        return {
            CatalogVisible:false,
        }
    },
    computed: {
        ...mapState([
            ,

        ]),
        ...mapGetters([
            "LISTTOVARS",

        ]),

    },
}
</script>

<style lang="scss" scoped>
.catalog{
    z-index: 100;

}
</style>
