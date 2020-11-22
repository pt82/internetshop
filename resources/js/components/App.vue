<template>
    <div >

            <router-view :key="$route.fullPath"></router-view>

    </div>

</template>
<style lang="scss">
@import "public/css/variables";
.btn_hover:hover{

}

</style>

