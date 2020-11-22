export default {
    CATEGORIES(state) {
        return state.categories;
    },
    UPCATEGORY(state) {
        return state.categor;
    },
    UPSUBCAT(state) {
        return state.subcategor;
    },
    UPSUBCATONE(state) {
        return state.subcategorone;
    },
    SUBCAT(state) {
        return state.subcategory;
    },
    SUBCATS(state) {
        return state.subcategories;
    },
    DELCAT(state) {
        console.log(store.state.categories)
        return state.categories;
    },
    ADDCATEGORY(state) {
        return state.categories;
    },
    LISTTOVARS(state) {
        return state.tovars;
    },
    TOVAR(state) {
        return state.tovar;
    },
    IMAGES(state) {
        return state.images;
    },
    IMAGESFORCLIENT(state) {
        return state.imagesclient;
    },
    CART(state){
        return state.cart;
    },
    CARTCOUNT(state){
        return state.cartCount;
    },
    TOTALCART(state){
        return state.totalcart;
    },
    LISTREVIEW(state){
        return state.review},

    ORDERS(state){
        return state.orders},

    ORDERONE(state){
        return state.orderone},

   AVGRATING(state){
        return state.avgrating},

    STATUSORDER(state){
        return state.status},
    STATUSORDERONE(state){
        return state.statusone},
    EVENTS(state){
        return state.events},
    EVENT(state){
        return state.event},
    RINGS(state){
        return state.rings},
    RING(state){
        return state.ring},
    STATUSRING(state){
        return state.status_ring},

    COUNT_NEW_ORDER(state){
        return state.count_new_order
    },
    COUNT_NEW_RING(state){
        return state.count_new_ring
    }
}
