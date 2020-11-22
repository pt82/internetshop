export default {

    init() {
        store.commit("Login");
        if (store.state.Auth.api_token) {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + store.state.Auth.api_token;

        }
    },

    login(data) {

            localStorage.setItem("user_id", data.user_id);
            localStorage.setItem("api_token", data.api_token);
            localStorage.setItem("name", data.name);
            localStorage.setItem("role", data.role);
            localStorage.setItem("photo", data.photo);
            this.init();

    },

    logout() {
        localStorage.removeItem("user_id");
        localStorage.removeItem("api_token");
        localStorage.removeItem("name");
        localStorage.removeItem("photo");
        localStorage.removeItem("role");
        // window.location.reload();
       this.init();
    },
    clear_cart(){
        // localStorage.removeItem("cart");
        // store.replaceState({cart:[]})
        store.state.cart=[];
        store.state.cartCount=0;
        store.state.totalcart=0
        // localStorage.removeItem("totalcart");
        // localStorage.removeItem("cartCount");


    },
    closeModal()
    {
        $(".modal").modal("hide")
    },
    animatetocart(){
        var butWrap =  $('#btn_cart');
        $('#btn_cart').click(function(e){
            butWrap.append('<div class="animtocart"></div>');
            var pos = $('#btn_cart').offset();
            var elem_left = pos.left;
            var elem_top = pos.top;
            $('.animtocart').css({
                'position' : 'absolute',
                'background' : '#FF0000',
                'width' :  '40px',
                'height' : '40px',
                'border-radius' : '100px',
                'z-index' : '9999999999',
                'left' : e.pageX - elem_left,
                'top' : e.pageY - elem_top,
            });

            var cart = $('.cart').position().top - 450;
                 $('.animtocart').animate({ top : cart +'px', left: 1 + 'px', width: 0, height: 0 }, 1000,
                function() {
                    $(this).remove();}
            );
        });
    },
    numberWithSpaces(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
},

    check() {
        if (!store.state.Auth.login) {
            router.push("/login");
        }
    }
};
