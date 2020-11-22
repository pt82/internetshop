import axios from "axios";

export default {
    //все категории
    GET_CATEGORIES({commit}) {
        return axios
            .get('/api/category')
            .then((response) => {
                commit('SET_CATEGORIES', response.data.categories)
                return response;
            })
            .catch((error) => {
                console.log(error);
                return error;
            })
    },
    //add категории
    POST_CATEGORIES({commit}){
        return axios
            .post(`/api/category/`)
            .then(commit('SET_ADDCATEGORY'))
            .catch((error) => {
                console.log(error);
                return error;
            })
    },
    //обновить
     UPDATE_CATEGORIES ({commit}, index) {
        return axios
        .get(`/api/category/${index}`)
         .then(( categor ) => {
                commit('SET_UPCATEGORY', categor.data);

                return categor;
            })


        .catch((error) => {
            console.log(error);
            return error;
        })

    },
    //сохранить
    SAVE_CATEGORY ({commit}, index) {
        return axios
            .put(`/api/category/${index}`)
            .then(( categor ) => {
                commit('SET_SAVECATEGORY', categor.data);
                return categor;
            })
    },

    GET_SUBCATS({commit}) {

        return axios(`/api/subcategory/`, {
            method: "GET"
        })
            .then((sub) => {
                commit('SET_SUBCATS', sub.data);

                return sub;
            })
            .catch((error) => {
                console.log(error)
                return error;
            })
    },

    GET_SUBCAT({commit}, index) {
        return axios
            .get(`/api/subcategory/${index}`)
            .then((response) => {
                commit('SET_SUBCAT', response.data)

                return response;
            })
            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    // список под кат в зависимости от выбора в селекте категории
    UPDATE_SUBCAT ({commit}, index) {
        return axios
            .get(`/api/subcategory/${index}`)
            .then((subcategor) => {
                commit('SET_UPSUBCAT', subcategor.data);

                return subcategor;
            })

            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    // одна категория для редактирования
    UPDATE_SUBCATONE ({commit}, index) {
        return axios
            .get(`/api/subcategoryone/${index}`)
            .then((subcategorone) => {
                commit('SET_UPSUBCATONE', subcategorone.data);

                return subcategorone;
            })

            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    SAVE_SUBCAT ({commit}, index, form) {
        return axios
            .put(`/api/category/${index}`, form)
            .then(( subcategor ) => {
                commit('SET_SAVESUBCAT', subcategor.data);
                return subcategor;
            })
    },

        DEL_CAT({commit}, index) {
           return axios
                .delete(`/api/category/${index}`)
                .then(commit('SET_DELCAT'))
                .catch((error) => {

                return error;
            })

            },

    //удаление подкат
    DEL_SUBCAT({commit}, index) {
        return axios
            .delete(`/api/subcategory/${index}`)
            .then(commit('SET_DELSUBCAT'))
            .catch((error) => {
                console.log(error);
                return error;
            })

    },


    //все товары в админпанеле
    GET_LIST_TOVAR ({commit}) {
            return axios
                .get(`/api/tovars`)
                .then((tovars) => {
                    commit('SET_LISTTOVAR', tovars.data.tovar);

                    return tovars;
                })

                .catch((error) => {
                    console.log(error);
                    return error;
                })
        },

    //товар для редактирования в админпанеле
    UPDATE_TOVARONE ({commit}, index) {
        return axios
            .get(`/api/tovar/${index}`)
            .then((tovar) => {
                commit('SET_UPTOVAR', tovar.data);

                return tovar;
            })

            .catch((error) => {
                console.log(error);
                return error;
            })

    },

    //удаление товара в админпнеле
    DEL_TOVAR({commit}, index) {
        return axios
            .delete(`/api/tovars/${index}`)
            .then(commit('SET_DELTOVAR'))
            .catch((error) => {
                console.log(error);
                return error;
            })

    },

    //изображение я товара в админ панеле
    GET_LIST_IMAGE ({commit}, index) {
        return axios
            .get(`/api/files/${index}`)
            .then((images) => {
                commit('SET_LISTIMAGE', images.data);
                return images;
            })

            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    DEL_IMAGE({commit}, index) {
        return axios
            .post(`/api/files/${index}`)
            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    //список изображений в карточке товара
    GET_LIST_IMAGE_FOR_CLIENT ({commit}, index) {
        return axios
           .get(`/api/files/${index}`)
            .then((images) => {
                commit('SET_LISTIMAGE_FOR_CLIENT', images.data);
                return images;
            })

            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    INCREMENT_CART_ITEM({commit}, index) {
        commit('INCREMENT', index)
    },

    DECREMENT_CART_ITEM({commit}, index) {
        commit('DECREMENT', index)
    },

    DELETE_FROM_CART({commit}, index) {
        commit('REMOVE_FROM_CART', index)
    },

    GET_LIST_REVIEW ({commit}, index) {
        return axios
            .get(`/api/review/${index}`)
            .then((review) => {
                commit('SET_LISTREVIEW', review.data);
                return review;
            })

            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    GET_ORDERS({commit}) {
        return axios
            .get('/api/order')
            .then((response) => {
                commit('SET_ORDER', response.data)
                return response;
            })
            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    GET_ORDERONE({commit}, index) {
        return axios
            .get(`/api/order/${index}`)
            .then((response) => {
                commit('SET_ORDERONE', response.data)
                return response;
            })
            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    POST_UPORDERONE({commit}, index) {
        return axios
            .post(`/api/order/${index}`)
            .then((response) => {
                commit('SET_UPORDERONE', response.data)
                return response;
            })
            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    DEL_TOVAR_IN_ORDER({commit}, index) {
        return axios
            .post(`/api/order/tovar/${index}`)
            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    GET_STATUSORDER ({commit}) {
        return axios
            .get(`/api/status_order/`)
            .then((status) => {
                commit('SET_STATUSORDER', status.data.status);
                return status;
            })

            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    GET_STATUSORDERONE({commit}, index) {
        return axios
            .get(`/api/status_order/${index}`)
            .then((response) => {
                commit('SET_STATUSORDERONE', response.data)
                return response;
            })
            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    GET_EVENTS ({commit}) {
        return axios
            .get(`/api/event/`)
            .then((events) => {
                commit('SET_EVENTS', events.data.events);

                return events;
            })

            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    DEL_EVENT({commit}, index) {
        return axios
            .delete(`/api/event/${index}`)
            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    SHOW_EVENT({commit}, index) {
        return axios
            .get(`/api/event/${index}`)
            .then((event) => {
                commit('SET_EVENT', event.data)

            })
            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    GET_RINGS({commit}) {
        return axios
            .get(`/api/rings/`)
            .then((rings) => {
                commit('SET_RINGS', rings.data);
                return rings;
            })

            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    GET_RING({commit}, index) {
        return axios
            .get(`/api/ring/${index}`)
            .then((ring) => {
                commit('SET_RING', ring.data)

            })
            .catch((error) => {
                console.log(error);
                return error;
            })
    },

    GET_STATUSRING({commit}) {
        return axios
            .get(`/api/status_ring/`)
            .then((status_ring) => {
                commit('SET_STATUSRING', status_ring.data);
                return status_ring;
            })

            .catch((error) => {
                console.log(error);
                return error;
            })
    },
}
