<template>
  <div>

      <b-container>

          <b-card>
              <b-card-title>
                  профиль
              </b-card-title>

              <b-form  >
                  <b-row>
                      <b-form-input
                          label="Name"
                          v-model="form.name"
                          :error-messages="checkError('name')"
                      >
                       </b-form-input>
                  </b-row>

                  <b-row>
                      <b-form-input
                          label="Email"
                          v-model="form.email"

                      >
                      </b-form-input>
                  </b-row>
                  <b-button @click="onUpdate('profile')" variant="primary">
                      Сохранить
                  </b-button>
              </b-form>
              <b-row>

              </b-row>



          </b-card>
      </b-container>
  </div>


</template>

<script>
import Auth from "../../../helpers/Auth";

export default {
    // computed: {
    //     profileImage() {
    //         return this.$store.state.Auth.photo;
    //     }
    // },

    data() {
        return {
            form: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
                action: null
            },


            errors: {}
        };
    },

    created() {
        this.edit_profile();
    },

    methods: {
        edit_profile() {
            axios
                .post('/api/edit_profile')
                .then(response => {
                    if (response.data.success) {
                        console.log(response.data.user)
                        this.form = response.data.user;
                    }
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        Auth.logout();
                        this.$router.push("/login");
                    }
                });
        },

        onUpdate(action) {
            this.errors = {};
            this.form.action = action;

            axios
                .post(`/api/update_profile`, this.form)
                .then(response => {

                    if (response.data.success) {
                        Auth.login(response.data.user);
                        console.log(this.form);
                        this.$store.commit(
                            "showInfo",
                            "Your profile was successfuly updated."
                        );
                    }
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },

        checkError(field) {
            return this.errors.hasOwnProperty(field) ? this.errors[field] : [];
        },

        // onSelectImage() {
        //     this.$refs.profileimage.click();
        // },
        //
        // onUploadImage(e) {
        //     if (e.target.files && e.target.files.length) {
        //         let file = e.target.files[0];
        //         let data = new FormData();
        //         this.form.action = "photo";
        //         for (let i in this.form) {
        //             data.append(i, this.form[i]);
        //         }
        //         data.append("profilephoto", file);
        //
        //         axios.post("/api/update_profile", data).then(response => {
        //             if (response.data.success) {
        //                 Auth.login(response.data.user);
        //
        //                 this.$store.commit(
        //                     "showInfo",
        //                     "Your photo was successfuly updated."
        //                 );
        //             }
        //         });
        //     }
        // }
    }
};
</script>

<style>
/*.profile-image {*/
/*    width: 200px;*/
/*    border-radius: 5px;*/
/*    border: 1px solid rgba(0, 0, 0, 0.5);*/
/*}*/

/*.profile-image-input {*/
/*    display: none;*/
/*}*/
</style>
