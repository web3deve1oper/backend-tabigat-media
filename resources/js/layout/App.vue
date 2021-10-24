<template>
    <v-app>
        <Sidebar></Sidebar>

        <Header></Header>

        <v-main>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-main>
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
    }
}
</script>

<style scoped>

</style>
