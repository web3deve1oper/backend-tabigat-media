<template>
    <v-row justify="center" align-content="center" class="mt-lg-5">
        <v-card class="px-4" max-width="600" color="#DCDCDC">
            <v-card-text>
                <v-form ref="loginForm" v-model="valid" lazy-validation>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field v-model="loginEmail" :rules="loginEmailRules" label="E-mail"
                                          required autocomplete="false"></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field v-model="loginPassword" :append-icon="show1?'eye':'eye-off'"
                                          :rules="[rules.required, rules.min]" :type="show1 ? 'text' : 'password'"
                                          name="input-10-1" label="Password" hint="At least 8 characters" counter
                                          @click:append="show1 = !show1" autocomplete="false"></v-text-field>
                        </v-col>
                        <v-col class="d-flex" cols="12" sm="6" xsm="12">
                        </v-col>
                        <v-spacer></v-spacer>
                        <v-col class="d-flex" cols="12" sm="3" xsm="12" align-end>
                            <v-btn x-large block :disabled="!valid" color="success" @click="validate"> Войти</v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
        </v-card>
    </v-row>
</template>

<script>
export default {
    name: "Login",
    computed: {
        passwordMatch() {
            return () => this.password === this.verify || "Password must match";
        }
    },
    methods: {
        validate() {
            if (this.$refs.loginForm.validate()) {
                this.$http.post('/admin/login', {
                    email : this.loginEmail,
                    password: this.loginPassword,
                    _token: this.csrf
                }).then(res => {
                    localStorage.setItem('auth-token', res.data.data.token)
                    this.$store.commit('setAuth', true)
                    this.$router.push('/admin/about')
                    this.$store.commit('triggerSnack', {text:'Авторизовано',color:'green'})
                })
            }
        },
        reset() {
            this.$refs.form.reset();
        },
        resetValidation() {
            this.$refs.form.resetValidation();
        }
    },
    mounted() {
        this.$store.commit('changeHeaderText', 'Авторизуйтесь прежде чем, использовать панель администратора!')
    },
    data: () => ({
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        dialog: true,
        tab: 0,
        tabs: [
            {name: "Login", icon: "mdi-account"},
            {name: "Register", icon: "mdi-account-outline"}
        ],
        valid: true,
        email: "",
        password: "",
        loginPassword: "",
        loginEmail: "",
        loginEmailRules: [
            v => !!v || "Required",
            v => /.+@.+\..+/.test(v) || "E-mail must be valid"
        ],
        emailRules: [
            v => !!v || "Required",
            v => /.+@.+\..+/.test(v) || "E-mail must be valid"
        ],

        show1: false,
        rules: {
            required: value => !!value || "Required.",
            min: v => (v && v.length >= 3) || "Min 8 characters"
        }
    })
}
</script>

<style scoped>

</style>
