
import VueRouter from 'vue-router'
import Categories from './components/pages/categories/Index'
import Sub from './components/pages/sub/Index'
import Tovars from './components/pages/tovars/Index'
import Tovar from './components/pages/Onetovar/Index'
import Cart from './components/pages/cart/Index'
import Order from './components/pages/order/Index'
import Register from './components/pages/register/Index'
import Login from './components/pages/login/Index'
import Profile from './components/pages/Profile/Profile'
import Admin from './components/pages/admin/Index'
import Addcategory from './components/pages/admin/Addcategory/Index'
import Addsubcat from './components/pages/admin/Addsubcat/Index'
import AddEvent from './components/pages/admin/AddEvent/Index'
import Addtovar from './components/pages/admin/Addtovar/Index'
import Orderadmin from './components/pages/admin/Orders/Index'
import Order_add from './components/pages/admin/Orders/Order_add'
import Orderadmin_one from './components/pages/admin/Orders/Odrer'
import Ring from './components/pages/admin/Ring/Index'
import Ring_edit from './components/pages/admin/Ring/Edit'
// import Search from './components/pages/Search/Index'
import Delivery from './components/pages/Delivery/Index'
import Services from './components/pages/Services/Index'
import Sales from './components/pages/Sales/Index'
import News from './components/pages/News/Index'
import Contacts from './components/pages/Contacts/Index'
import Error404 from './components/pages/Error404/Index'


import Auth from "./helpers/Auth";

const router = new VueRouter ({
    routes: [
        {
            path: '',
           // name: 'product',
            component: Categories,
            meta: {
                guest: true,
                requiresAuth: true
            }
        },
        {
            path: '/subcategory/:id',

            component: Sub,
            meta: {
                guest: true,
                requiresAuth: true
            }
        },
        {
            path: '/subcategory/:id/tovars',

            component: Tovars
        },
        {
            path: '/subcategory/:id/tovars/:id_tovars',
             name: 'tovar',
            component: Tovar
        },
        {   path: '/register',
            component: Register
        },
        {   path: '/login',
            component: Login
        },
        {   path: "/profile",
            component: Profile
        },
        {   path: "/cart",
            component: Cart
        },
        {   path: "/order",
            component: Order
        },
        {   path: "/search/:id",
            component: Search
        },
        {   path: "/delivery",
            component: Delivery
        },
        {   path: "/services",
            component: Services
        },
        {   path: "/sales",
            component: Sales
        },
        {   path: "/news",
            component: News
        },
        {   path: "/contacts",
            component: Contacts
        },
        {   path: "/event",
            component: Event
        },
        {   path: "/error404",
            component: Error404
        },

        {   path: '/admin',
            component: Admin,
            //если не админ роут на еррор404
            beforeEnter: (from, to, next) => {
                if(window.store.state.Auth.role !== '1')  {// || store.state.Auth.role===null
                    next('/error404')
                }
                else {
                    next()
                }
            },

                meta: {
                 is_admin : true
            },
            children: [
                {
                path: 'category',
                component: Addcategory
                 },

                {
                    path: 'addsubcat',
                    component: Addsubcat
                },
                {
                    path: 'addtovar',
                    component: Addtovar
                },
                {
                    path: 'order',
                    component: Orderadmin
                },
                {
                    path: 'order/:id',
                    component: Orderadmin_one
                },
                {
                    path: 'order_add',
                    component:  Order_add
                },

                {
                    path: 'addevent',
                    component: AddEvent
                },
                {
                    path: 'rings',
                    component: Ring
                },
                {
                    path: 'ring/:id',
                    component: Ring_edit
                },


            ]
        },

    ],
    //отключение хеша
   mode: 'history'
})


// //apply route guard
// router.beforeEach((to, from, next) => {
// // list of blocked routes
//     let role = JSON.parse(localStorage.getItem('role'))
//     if (role === 'user' || role=== '') {
//         const protectedRoutes = ['/admin', 'admin/category', '/admin/addsubcat', '/admin/addtovar'];
//
// // the route user is trying to access is in blocked routes list
//         if (protectedRoutes.includes(to.path)) {
// // redirect to route having unauhorised message page
//             return next('/login');
//         } else {
// // otherwise allow user to access route
//             return next();
//         }
//
// }})


// router.beforeEach((to, from, next) => {
//     if(to.matched.some(record => record.meta.requiresAuth)) {
//         if (localStorage.getItem('api_token') == null) {
//             next({
//                 path: '/login',
//                 params: { nextUrl: to.fullPath }
//             })
//         } else {
//             let user = JSON.parse(localStorage.getItem('role'))
//             if(to.matched.some(record => record.meta.is_admin)) {
//
//                 if(user.is_admin == 1){
//                     next()
//                 }
//                 else{
//                     next('')
//                 }
//             }else {
//                 next()
//             }
//         }
//     } else if(to.matched.some(record => record.meta.guest)) {
//         if(localStorage.getItem('jwt') == null){
//             next()
//         }
//         else{
//             next( '/login')
//         }
//     }else {
//         next()
//     }
// })





export default router

