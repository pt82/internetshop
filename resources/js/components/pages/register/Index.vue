<template>
    <div>
        <b-container>

                    <b-card>
                        <b-card-title>
                            <h2>Create An Account</h2>
                        </b-card-title>
                        <b-form >
                            <b-row>
                                <b-input-group>
                                <b-form-input
                                    label="Name"
                                    v-model="form.name"

                                ></b-form-input>
                                    </b-input-group>
                            </b-row>

                            <b-row>
                                <b-input-group>
                                <b-form-input
                                    v-model="form.email"

                                ></b-form-input>
                                    </b-input-group>
                            </b-row>

                            <b-row>
                                <b-input-group >
                                <b-form-input
                                    v-model="form.password"
                                    type="password"
                                >
<!--                                    :error-messages="checkError('password')"-->
                                </b-form-input>
                                </b-input-group>
                            </b-row>

                            <b-row>
                                <b-input-group>
                                <b-form-input

                                    v-model="form.password_confirmation"
                                    type="password"
                                ></b-form-input>
                                    </b-input-group>
                            </b-row>

                        </b-form>
                        <b-row>
                            <b-button type="submit" variant="primary" @click="onRegister">
                                Register
                            </b-button>

                        </b-row>
                        </b-card>


        </b-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null
            },

            errors: {}
        };
    },

    methods: {
        onRegister() {
            this.errors = {};
            axios
                .post(`/api/register`, this.form)
                .then(response => {
                   console.log(response.data);
                    if (response.data.success) {
                        console.log(response.data);
                        this.$router.push("/");
                    }
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        }

        // checkError(field) {
        //     return this.errors.hasOwnProperty(field) ? this.errors[field] : [];
        // }
    }
};
</script>
