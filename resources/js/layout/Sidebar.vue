<template>
    <v-navigation-drawer permanent app>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h6">
                        Tabigat Media
                    </v-list-item-title>
                    <v-list-item-subtitle>
                        Администратирование
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list nav>
                <v-list-item
                    v-for="item in items"
                    :key="item.title"
                    link
                    :to="{name : item.route}"
                    :disabled="disabled"
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>

                </v-list-item>
            </v-list>
        </v-navigation-drawer>
</template>

<script>
export default {
    name: "Sidebar",
    data() {
        return {
            items: [
                {title: 'Главная', icon: 'mdi-image', route:'about'},
                {title: 'Рубрики', icon: 'mdi-help-box', route: 'rubrics'},
            ]
        }
    },
    computed: {
        disabled() { return !this.$store.state.isAuth}
    }
}
</script>

<style scoped>

</style>
