<template>
<div>
    <div class="error_404">
     <b-row>
         <b-col class="3">
            <img src="/images/Error/error404.jpg">
         </b-col>
         <b-col cols="8">
      <div class="error_text ">УПС! Похоже мы не можем найти нужную Вам страницу</div>
         </b-col>
     </b-row>
    </div>
</div>
</template>

<script>
export default {
name: "Index"
}
</script>

<style scoped lang="scss">
.error_404{

    img {
        height: 500px;
        width: 400px;
    }
    .error_text{
        font-size: 3rem;
        font-family: Mistral;
        padding-top: 30px;
        width: 80%;
    }

}
</style>
