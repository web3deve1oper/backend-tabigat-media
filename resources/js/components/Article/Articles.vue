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
                        @click="$router.push({name:'create-article'})"
                    >
                        Добавить статью
                    </v-btn>
                </v-col>
                <v-col cols="7">
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Поиск по любому параметру"
                        @input="doSearch"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-card-title>

        <ApiDataTable api-url="/api/articles"
                      loading-text="Загрузка статей"
                      :headers="headers"
                      :api-includes="apiIncludes"
                      ref="articles"
                      :redirect-to-edit-page-on-row-click="true"
                      model-name="articles"
                      :show-select="false">
        </ApiDataTable>
    </div>
</template>

<script>
import ApiDataTable from "../Reusable/ApiDataTable";
import _ from 'lodash';

export default {
    name: "Articles",
    data() {
        return {
            rubrics: [],
            headers: [
                {
                    text: 'ID',
                    value: 'id',
                    type: 'text'
                },
                {
                    text: 'Автор',
                    value: 'author.full_name',
                    type: 'text',
                    sortable: false
                },
                {
                    text: 'Рубрика',
                    value: 'rubric.title',
                    type: 'text',
                    sortable: false
                },
                {
                    text: 'Название',
                    value: 'title',
                    type: 'text',
                    sortable: false
                },
                {
                    text: 'Описание',
                    value: 'description',
                    type: 'text',
                    sortable: false
                },
                {
                    text: 'Время на чтение',
                    value: 'read_time',
                    type: 'text',
                },
                {
                    text: 'Количество просмотров',
                    value: 'views',
                    type: 'text',
                },
                {
                    text: 'Фотография',
                    value: 'photography',
                    type: 'text',
                    sortable: false
                },
                {
                    text: 'Опубликовано',
                    value: 'posted_at',
                    type: 'text',
                },
                {
                    text: 'Создано',
                    value: 'created_at',
                    type: 'text',
                },
                {
                    text: 'Изменено',
                    value: 'updated_at',
                    type: '',
                },
            ],
            apiIncludes: 'author,rubric',
            search: ''
        }
    },
    methods: {
        doSearch: _.debounce(function (e) {
            this.$refs.articles.getDataFromApi(this.search)
        }, 500),
        deleteArticles() {
            if (this.$refs.articles.selected.length === 0) return;
            this.$refs.articles.loading = true;
            this.$http.delete('/api/articles', {
                data: {
                    articles: this.$refs.articles.selected
                }
            })
                .then(res => {
                    this.$refs.articles.loading = false;
                    this.$store.commit('triggerSnack', {text: 'Успешно удалено', color: 'success'})

                    this.$refs.articles.getDataFromApi();
                })
        }
    },
    mounted() {
        this.$store.commit('changeHeaderText', 'Статьи')
    },
    components: {ApiDataTable}
}
</script>

<style scoped>

</style>
