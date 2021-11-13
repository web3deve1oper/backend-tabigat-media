<template>
    <div>
        <v-card-title>
            <v-row justify="space-between" align-content="center">
                <!--                <v-col cols="1" class="mt-5">-->
                <!--                    Фильтр-->
                <!--                </v-col>-->
                <v-col cols="5">
                    <v-btn
                        color="primary"
                        class="mt-2"
                        dark
                        @click="$router.push({name:'send-mailing'})"
                    >
                        Совершить рассылку
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-title>

        <ApiDataTable api-url="/api/mailings"
                      loading-text="Загружаю почтовые адреса"
                      :headers="headers"
                      ref="mailings"
        >
        </ApiDataTable>
        <v-btn
            depressed
            color="danger"
            class="mt-2"
            @click="deleteMailings"
        >
            Удалить отмеченные
        </v-btn>
    </div>
</template>

<script>
import ApiDataTable from "../Reusable/ApiDataTable";

export default {
    name: "Mailing",
    components: {ApiDataTable},
    mounted() {
        this.$store.commit('changeHeaderText', 'Рассылка')
    },
    data() {
        return {
            headers:
                [
                    {
                        text: 'ID',
                        value: 'id',
                        type: 'text',
                    },
                    {
                        text: 'Email',
                        value: 'email',
                        type: 'text',
                        sortable: false
                    },
                    {
                        text: 'Дата подписания',
                        value: 'created_at',
                        type: 'text',
                    }
                ]
        }
    },
    methods: {
        deleteMailings() {
            if (this.$refs.mailings.selected.length === 0) return;
            this.$http.delete('/api/mailings', {
                data: {
                    mailings: this.$refs.mailings.selected
                }
            })
                .then(res => {
                    this.$store.commit('triggerSnack', {text: 'Успешно удалено', color: 'success'})
                    this.$refs.mailings.getDataFromApi();
                })
        }
    }
}
</script>

<style scoped>

</style>
