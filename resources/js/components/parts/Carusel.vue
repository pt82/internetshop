<template>
    <div>
    <carousel class="carusel card"  :autoplay="true" :autoplayTimeout="7000" :per-page="1" :navigationEnabled="true"
              :scrollPerPage="false" :loop="true" :mouseDrag="true">
        <slide v-for="item in EVENTS" v-if="item.active==='1'" class="wrapper exmp3" >
            <router-link :to="`${item.link}`"
            >
                <img :src="item.image" alt="" class="category_image">
            </router-link>

        </slide>

    </carousel>

    </div>
</template>

<script>

import {mapActions, mapGetters} from "vuex";
export default {
    name: "Carusel",

    data(){
      return{
          slickOptions: {
              dots: true,
              infinite: false,
              autoplay: false,
              arrows : false,
              draggable:true,
              speed: 1000,
              slidesToShow: 1,
              slidesToScroll: 1,
          },
      }
    },
    computed:{
        ...mapGetters([
            'EVENTS',
        ]),
    },
    mounted() {
        this.GET_EVENTS()

    },
    methods: {
        ...mapActions([
            'GET_EVENTS',
        ]),
    },
    reInit() {

        let currIndex = this.$refs.slick.currentSlide()
        this.$refs.slick.destroy()
        this.$nextTick(() => {
            this.$refs.slick.create()
            this.$refs.slick.goTo(currIndex, true)
        })
    }
}
</script>

<style scoped>
.example-slide {
    align-items: center;
    background-color: #666;
    color: #999;
    display: flex;
    font-size: 1.5rem;
    justify-content: center;
    min-height: 10rem;

}
.carusel {
margin-top: 2rem;

}
.wrapper {
    height: 100%;
    width: 100%;
}
.exmp3 img {
    object-fit: contain;
    width: 100%;
    height: 100%;
}

</style>
