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
                        @click="$router.push({name:'create-author'})"
                    >
                        Добавить автора
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
        <ApiDataTable :headers="headers"
                      api-url="/api/authors"
                      loading-text="Загружаю авторов"
                      :show-select="false"
                      ref="authors"
                      :api-includes="apiIncludes"
                      :redirect-to-edit-page-on-row-click="true"
                      model-name="authors"
        >
        </ApiDataTable>
    </div>
</template>

<script>
import ApiDataTable from "../Reusable/ApiDataTable";
import _ from "lodash";

export default {
    name: "Authors",
    components: {
      ApiDataTable
    },
    mounted() {
      this.$store.commit('changeHeaderText', 'Авторы')
    },
    data() {
        return {
            headers: [
                {
                    text: 'ID',
                    value: 'id',
                    type: 'text'
                },
                {
                    text: 'ФИО',
                    value: 'full_name',
                    type: 'text',
                    sortable: false
                },
                {
                    text: 'Количество статей',
                    value: 'articles_count',
                    type: 'text'
                },
                {
                    text: 'Изменен',
                    value: 'updated_at',
                    type: 'text'
                },
                {
                    text: 'Создан',
                    value: 'created_at',
                    type: 'text'
                },
            ],
            apiIncludes: 'articlesCount',
            search: ''
        }
    },
    methods: {
        doSearch: _.debounce(function (e) {
            this.$refs.authors.getDataFromApi(this.search)
        }, 500),

    }
}
</script>

<style scoped>

</style>
