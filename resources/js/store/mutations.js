export default {
    showInfo(state, message) {
        state.info.text = message;
        state.info.show = true;
    },

    setImagesList(state, payload) {
        state.imagesList = payload;
    },

    Login(state) {
        state.Auth.user_id = localStorage.getItem("user_id");
        state.Auth.api_token = localStorage.getItem("api_token");
        state.Auth.name = localStorage.getItem("name");
        state.Auth.photo = localStorage.getItem("photo");
        state.Auth.role = localStorage.getItem("role");
        state.Auth.login =
            state.Auth.user_id !== null &&
            state.Auth.api_token !== null &&
            state.Auth.role !== null &&
            state.Auth.name !== null;
    },

    SET_CATEGORIES: (state, categories) =>{
        state.categories = categories;

    },

    SET_SUBCATS: (state, subcategories) =>{
        state.subcategories = subcategories;

    },
    SET_SUBCAT: (state, subcategory) =>{
        state.subcategory = subcategory;

    },
    SET_DELCAT: (state, categories) =>{
        state.categories = categories;

    },
    SET_DELSUBCAT: (state, subcategories) =>{
        state.subcategories = subcategories;

    },

    SET_UPCATEGORY: (state, categor) =>{
        state.categor = categor;

    },
    SET_SAVECATEGORY: (state, categor) => {
        state.categor = categor;

    },
    SET_SAVESUBCAT: (state, subcategor) => {
        state.subcategor = subcategor;

    },

    SET_UPSUBCAT: (state, subcategor) =>{
        state.subcategor = subcategor;

    },

    SET_UPSUBCATONE: (state, subcategorone) =>{
        state.subcategorone = subcategorone;

    },

    SET_LISTTOVAR: (state, tovars) =>{
        state.tovars = tovars;

    },
    SET_UPTOVAR: (state, tovar) =>{
        state.tovar = tovar;

    },
    SET_DELTOVAR: (state, tovar) =>{
        state.tovar = tovar;

    },

    SET_LISTIMAGE: (state, images) => {
        state.images = images;
    },

    SET_LISTIMAGE_FOR_CLIENT: (state, images) => {
        state.imagesclient = images;
    },

    //добавляем товар в корзину, если такой уже есть увеличиваем количетсво
    ADD_TO_CART(state, item) {
        let tempcart={};
        let found = state.cart.find(tovar => tovar.id_tovars == item.id);
        if (found) {
            found.quantity ++;
            found.pricein=item.pricein;
            found.totalPrice = found.quantity * item.pricein;
            found.photo = item.photo;
            found.balance=item.balance;
            this.commit('SET_CART_TOTAL');
        } else {
            tempcart.id_tovars=item.id
            tempcart.quantity=1;
            tempcart.pricein=item.pricein;
            tempcart.photo = item.photo;
            tempcart.totalPrice=item.pricein;
            tempcart.name=item.name;
            tempcart.balance=item.balance
            state.cart.push(tempcart);
            tempcart={};

            this.commit('SET_CART_TOTAL');
        }


        state.cartCount++;
        this.commit('SAVE_CART');
    },

    //сохраняем в кэш
    SAVE_CART(state) {
        window.localStorage.setItem('cart', JSON.stringify(state.cart));
        window.localStorage.setItem('cartCount', state.cartCount);
        window.localStorage.setItem('totalcart', state.totalcart);
    },

    //удаляем товар с корзины
    REMOVE_FROM_CART (state, index) {
        state.cartCount=state.cartCount-state.cart[index].quantity;
        state.cart.splice(index, 1)
        this.commit('SET_CART_TOTAL');
        this.commit('SAVE_CART');
    },
    //увеличиваем кол-во товаров в корзине
    INCREMENT (state, index) {
        state.cart[index].quantity++
        state.cartCount++;
        state.cart[index].totalPrice=state.cart[index].quantity*state.cart[index].pricein
        this.commit('SET_CART_TOTAL');
        this.commit('SAVE_CART');
    },

    //уменьшаем кол-во товаров в корзине
    DECREMENT (state, index) {
        if (state.cart[index].quantity > 1) {
            state.cart[index].quantity--;
            state.cartCount--;
            state.cart[index].totalPrice=state.cart[index].quantity*state.cart[index].pricein
            this.commit('SET_CART_TOTAL');
            this.commit('SAVE_CART');
        }
    },

    //итог в корзине
    SET_CART_TOTAL(state) {
        let result=0
        let sum = 0
        let cart = state.cart;
        if (cart.length) {

            for (let item of cart) {
                result=(item.pricein * item.quantity)
                sum=sum+result
            }
            return state.totalcart = sum;
        } else {
            return state.totalcart = 0;
        }
    },


    SET_LISTREVIEW (state, review) {
        state.review = review;
        this.commit('SET_AVG_RATING');
    },
    //средний рейтинг в карточке товара
    SET_AVG_RATING(state) {
        state.avgrating= 0
        let summ = 0;
        let result = 0;
       let rating = state.review;
         if (rating.length) {
            for (let item of rating) {
                 summ = summ + item.rating
            }
            result = summ / rating.length

            return state.avgrating = result.toFixed(1);;
        }
    },

   //в админ панеле считаем склько заказов в статусе новый
    SET_ORDER (state, orders) {
    state.orders = orders;
    let new_order=0
    let arr_new_order = state.orders;
        for (let item of arr_new_order) {
           if(item.id_statusorders===1){
               new_order++
           }
        }
    state.count_new_order=new_order;

},

    SET_ORDERONE (state, order) {
        state.orderone = order;
    },
    SET_STATUSORDER (state, status) {
        state.status = status;
    },
    SET_STATUSORDERONE (state, status) {
        state.statusone = status;
    },

    SET_EVENTS (state, events) {
        state.events = events;
    },
    SET_EVENT (state, events) {
        state.event = events;
    },
    //в админ панеле считаем сколько звонков в статусе новый
    SET_RINGS (state, rings) {
        state.rings = rings;
        let new_ring=0
        let arr_new_ring = state.rings;
        for (let item of arr_new_ring) {
            if(item.id_status_rings===1){
                new_ring++
            }
        }
        state.count_new_ring=new_ring;
    },

    SET_RING (state, ring) {
        state.ring = ring;

    },
    SET_STATUSRING (state, status_ring) {
        state.status_ring = status_ring;
    },
   CATALOG_SUB(state, id){
     let sub= state.subcategories
   },
};
