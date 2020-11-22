<template>
  <div>
      <b-container>
                 <b-card>
                      <b-form >
                          <b-row>
                              <b-form-input
                                label="Email"
                                v-model="form.email"
                              ></b-form-input>
                              </b-row>

                          <b-row>
                              <b-form-input
                                label="Password"
                                v-model="form.password"
                                type="password">
                                @keyup="onKeyup"
                              </b-form-input>
                          </b-row>
                          </b-form>

                      <b-row>
                          <b-button type="submit" variant="primary" @click="onLogin">
                              Login
                          </b-button>
                      </b-row>


                  </b-card>
      </b-container>
  </div>
</template>

<script>
import Auth from "../../../helpers/Auth";
export default {
    data() {
        return {
            form: {
                email: null,
                password: null
            },

            errors: {}
        };
    },
    computed: {
        userRole: function () {
            let role = this.$store.state.userRole
            if(role === '2'){
                router.push('/')
            } else if(role === '1'){
                router.push('/admin')
            }

          return role
       }
    },
    methods: {
        onLogin() {
            this.errors = {};
            axios
                .post("/api/login", this.form)
                .then(response => {

                        Auth.login(response.data.user);
                        console.log(response.data.user)
                        console.log(response.data.user)
                        if(response.data.user.role!=='1')
                        this.$router.push("/");
                        else this.$router.push("/admin");

                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },

        checkError(field) {
            return this.errors.hasOwnProperty(field) ? this.errors[field] : [];
        },

        onKeyup(e) {
            if (e.code === "Enter") {
                this.onLogin();
            }
        }
    }
};
</script>
