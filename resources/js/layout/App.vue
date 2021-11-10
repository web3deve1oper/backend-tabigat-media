<template>
    <v-app>
        <Sidebar v-if="isAuth"></Sidebar>

        <Header></Header>

        <v-main>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-main>

        <v-snackbar
            v-model="snack"
            :timeout="3000"
            :color="snackColor"
        >
            {{ snackText }}
        </v-snackbar>
    </v-app>
</template>

<script>
import Sidebar from "./Sidebar";
import Header from "./Header";

export default {
    name: "App",
    components: {Header, Sidebar},
    beforeMount() {
        if (!localStorage.getItem('auth-token')) {
            this.$store.commit('setAuth', false)
        }
    },
    computed: {
        snack: {
            get() {
                return this.$store.state.snack
            },
            set() {
                this.$store.commit('closeSnack')
            }
        },
        snackColor() {
            return this.$store.state.snackColor
        },
        snackText() {
            return this.$store.state.snackText
        },
        isAuth() {
            return this.$store.state.isAuth
        }
    },
}
</script>

<style scoped>

</style>
