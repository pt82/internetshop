
export default {
    info: {
        timeout: 3000,
        show: false,
        text: null
    },
    categor:[],
    subcategor:[],
    subcategorone:[],
    categories: [],
    subcategories: [],
    subcategory:[],
    tovars: [],
    tovar: [],
    images: [],
    imagesclient: [],
    imagesList: [],
    review:[],
    orders:[],
    count_new_order:0,
    id_order:'',
    orderone:[],
    avgrating: 0,
    status: [],
    statusone:[],
    events: [],
    event:[],
    rings:[],
    ring:[],
    id_rings:null,
    status_ring:[],
    count_new_ring:0,


    // cart:  [],
    // cartCount:  0,

    cart: window.localStorage.getItem('cart') ? JSON.parse(window.localStorage.getItem('cart')) : [],
    cartCount: window.localStorage.getItem('cartCount') ? parseInt(window.localStorage.getItem('cartCount')) : 0,
    totalcart:window.localStorage.getItem('totalcart') ? parseInt(window.localStorage.getItem('totalcart')) : 0,


    // nav: [
    //     { path: "/", title: "Home", auth: "both" },
    //     { path: "/upload_file", title: "File upload", auth: true },
    //     { path: "/browse_files", title: "Browse files", auth: true },
    //     { path: "/carousel", title: "Carousel", auth: true }
    // ],

    authNav: [
        { path: "/register", title: "Регистрация", auth: false },
        { path: "/login", title: "Вход", auth: false }
    ],

    profileNav: [
        { path: "/profile", title: "Профиль", auth: true },
        { path: "/logout", title: "Выйти", auth: true }
    ],

    Auth: {
        login: false,
        user_id: null,
        api_token: null,
        name: null,
        photo: null,
        role: null
    }
};
