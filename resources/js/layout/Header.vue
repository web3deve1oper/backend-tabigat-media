<template>
    <v-app-bar absolute
               color="white"
               app>

        <v-toolbar-title>{{headerText}}</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon @click="logout" v-if="isAuth">
            <v-icon>mdi-logout</v-icon>
        </v-btn>

    </v-app-bar>
</template>

<script>
export default {
    name: "Header",
    computed: {
        headerText() { return this.$store.state.headerText},
        isAuth() {return this.$store.state.isAuth}
    },
    methods: {
        logout() {
            localStorage.removeItem('auth-token')
            this.$store.commit('setAuth',false)
            this.$router.push('/admin/login')
        }
    }
}
</script>

<style scoped>

</style>
