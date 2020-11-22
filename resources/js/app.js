import state from "./store/state";

require('./bootstrap');


//import { Vuetify } from 'vuetify'
import { BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
import VueRouter from 'vue-router';
import router from './router';


import vuescroll from 'vuescroll';
Vue.use(vuescroll);

import Vue from 'vue';

import VueHtmlToPaper from 'vue-html-to-paper';
const options = {
    name: '_blank',
    specs: [
        'fullscreen=yes',
        'titlebar=yes',
        'scrollbars=yes'
    ],
    styles: [
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
        'https://unpkg.com/kidlat-css/css/kidlat.css'
    ]
}

Vue.use(VueHtmlToPaper, options);

import VueSimpleAlert from "vue-simple-alert";
Vue.use(VueSimpleAlert);


// import VueCarousel from '@chenfengyuan/vue-carousel';
// Vue.component(VueCarousel.name, VueCarousel);
import Slick from 'vue-slick';
Vue.use(Slick)
// import VueSlickCarousel from 'vue-slick-carousel'
// Vue.component('SlickCarousel', VueSlickCarousel)
// import 'vue-slick-carousel/dist/vue-slick-carousel.css'
// optional style for arrows & dots
// import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

import VueImageWall from 'vue-image-wall';
Vue.component('vue-image-wall', VueImageWall)


import VueCarousel from 'vue-carousel';
Vue.use(VueCarousel);

import InputMask from 'vue-input-mask';
Vue.component('input-mask', InputMask)

import 'hooper/dist/hooper.css';

import VueGoodTable from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css'
Vue.use(VueGoodTable);

// import { DataTables, DataTablesServer } from 'vue-data-tables'
// Vue.use(DataTables)
// Vue.use(DataTablesServer)



import VueAdsTableTree from 'vue-ads-table-tree';
import 'vue-ads-table-tree/dist/vue-ads-table-tree.css';
Vue.component('vue-ads-table-tree', VueAdsTableTree);

import '../../node_modules/@fortawesome/fontawesome-free/css/all.css';



// import ElementUI from 'element-ui';
// import 'element-ui/lib/theme-chalk/index.css';
// Vue.use(ElementUI)
//
// import lang from 'element-ui/lib/locale/lang/ru-RU'
// import locale from 'element-ui/lib/locale'
// locale.use(lang)


import Datetime from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
Vue.component('datetime', Datetime);
Vue.use (Datetime)




// import RangeSlider from 'vue-slider-component';
// import RangeSlider from 'vue-range-slider'

import 'vue-range-slider/dist/vue-range-slider.css'

import VueConfirmDialog from "vue-confirm-dialog";
Vue.use(VueConfirmDialog)

window.router = router;

import VModal from 'vue-js-modal'
Vue.use(VModal)

import vSelect from 'vue-select'
Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';

// import VueDragscroll from 'vue-dragscroll'
// Vue.use(VueDragscroll)

// import vuescroll from 'vuescroll';
// import 'vuescroll/dist/vuescroll.css';
// Vue.use(vuescroll);

import App from './components/App'
import Carusel from './components/parts/Carusel'
import Navbar from './components/parts/Navbar'
import Catalog from './components/parts/Catalog'
import Footer from './components/parts/Footer'
import Info from './components/parts/Info'
import MainMenu from './components/parts/MainMenu'
import Categories from './components/pages/categories/Index'
import Sub from './components/pages/sub/Index'
import Tovars from './components/pages/tovars/Index'
import Tovar from './components/pages/Onetovar/Index'
import Profile from './components/pages/Profile/Profile'
import Register from './components/pages/register/Index'
import Login from './components/pages/login/Index'
import Admin from './components/pages/admin/Index'
import Addcategory from './components/pages/admin/Addcategory/Index'
import Addsubcat from './components/pages/admin/Addcategory/Index'
import Sidebar from './components/parts/Sidebar'
import Addtovar from './components/pages/admin/Addtovar/Index'
import Orderadmin from './components/pages/admin/Orders/Index'
import Order_add from './components/pages/admin/Orders/Order_add'

import store from "./store/index";
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'

Vue.component('VueSlider', VueSlider)

Vue.config.productionTip = false



Vue.component('subcategories', Sub);
Vue.component('login', Login);
Vue.component('categories', Categories);
Vue.component('navbar', Navbar);
Vue.component('catalog', Catalog);
Vue.component ('tovars', Tovars);
Vue.component ('tovar', Tovar);
Vue.component ('profile', Profile);
Vue.component ('register', Register);
Vue.component ('profile', Profile);
Vue.component ('admin', Admin);
Vue.component ('addcategory', Addcategory);
Vue.component ('addsubcat', Addsubcat);
Vue.component ('addtovar', Addtovar);
Vue.component ('orderadmin', Orderadmin);
Vue.component ('sidebar', Sidebar);
Vue.component('carusel', Carusel)
Vue.component('mainmenu', MainMenu)
Vue.component('footer_menu', Footer)
Vue.component('info', Info)
Vue.use (VueRouter);
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
//Vue.use(Vuetify);


// Vue.config.productionTip = false;

export const bus = new Vue();

const app = new Vue({
    el: '#app',
    render: h => h(App),
    router,
    store,

});



