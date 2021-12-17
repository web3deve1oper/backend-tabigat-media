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

        <v-btn
            depressed
            color="success"
            class="mt-2"
            :loading="downloadLoader"
            @click="downloadFeedbacks"
        >
            Скачать архив
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
            downloadLoader: false,
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
        },
        downloadFeedbacks() {
            if (this.$refs.feedbacks === 0) return;

            this.downloadLoader = true;

            this.$http.get('/api/feedbacks/download', {responseType: 'arraybuffer'})
                .then(response => {
                    let blob = new Blob([response.data], { type: 'application/csv' })
                    let link = document.createElement('a')
                    link.href = window.URL.createObjectURL(blob)
                    link.download = 'Отчет.xlsx'
                    link.click()
                    this.downloadLoader = false;
                    this.$store.commit('triggerSnack', {text: 'Успех!', color: 'green'})
                })
                .catch(err => {
                    this.downloadLoader = false;
                    this.$store.commit('triggerSnack', {text: 'Ошибка', color: 'red'})
                    console.log(err);
                })
        }
    }
}
</script>

<style scoped>

</style>
