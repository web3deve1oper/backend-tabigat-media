<template>
    <div>
        <ApiDataTable model-name="feedback"
                      api-url="/api/feedbacks"
                      :headers="headers"
                      loading-text="Загружаю фидбеки"
                      ref="feedbacks">

        </ApiDataTable>

        <v-btn
            depressed
            color="danger"
            class="mt-2"
            @click="deleteFeedback"
        >
            Удалить отмеченные
        </v-btn>
    </div>
</template>

<script>
import ApiDataTable from "../Reusable/ApiDataTable";

export default {
    name: "Feedbacks",
    components: {ApiDataTable},
    mounted() {
        this.$store.commit('changeHeaderText', 'Обратная связь')
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
                        text: 'ФИО',
                        value: 'full_name',
                        type: 'text',
                        sortable: false
                    },
                    {
                        text: 'email',
                        value: 'email',
                        type: 'text',
                        sortable: false
                    },
                    {
                        text: 'Тип связи',
                        value: 'type',
                        type: 'text',
                        sortable: false
                    },
                    {
                        text: 'Сообщение',
                        value: 'message',
                        type: 'text',
                        sortable: false
                    },
                    {
                        text: 'Создано',
                        value: 'created_at',
                        type: 'text',
                    }
                ]
        }
    },
    methods: {
        deleteFeedback() {
            if (this.$refs.feedbacks.selected.length === 0) return;
            this.$refs.feedbacks.loading = true;
            this.$http.delete('/api/feedbacks', {
                data: {
                    feedbacks: this.$refs.feedbacks.selected
                }
            })
                .then(res => {
                    this.$refs.feedbacks.loading = false;
                    this.$store.commit('triggerSnack', {text: 'Успешно удалено', color: 'success'})
                    this.$refs.feedbacks.getDataFromApi();
                })
        }
    }
}
</script>

<style scoped>

</style>
