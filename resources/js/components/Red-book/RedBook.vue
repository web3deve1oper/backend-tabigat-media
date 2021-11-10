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
                        @click="$router.push({name:'red-book-create'})"
                    >
                        Добавить тип
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
                      api-url="/api/red-book"
                      loading-text="Загружаю виды"
                      :show-select="false"
                      ref="redbook"
                      :redirect-to-edit-page-on-row-click="true"
                      model-name="red-book"
        >
        </ApiDataTable>
    </div>
</template>

<script>
import ApiDataTable from "../Reusable/ApiDataTable";
import _ from "lodash";

export default {
    name: "RedBook",
    components: {ApiDataTable},
    mounted() {
        this.$store.commit('changeHeaderText', 'Красная книга')
    },
    data() {
        return {
            search: '',
            headers: [
                {
                    text: 'ID',
                    value: 'id',
                    type: 'text'
                },
                {
                    text: 'Название вида',
                    value: 'name',
                    type: 'text',
                    sortable: false
                },
                {
                    text: 'Латинское название',
                    value: 'name_latin',
                    type: 'text',
                    sortable: false

                },
                {
                    text: 'Домен',
                    value: 'domain',
                    type: 'text',
                    sortable: false

                },
                {
                    text: 'Тип',
                    value: 'type',
                    type: 'text',
                    sortable: false

                },
                {
                    text: 'Класс',
                    value: 'class',
                    type: 'text',
                    sortable: false

                },
                {
                    text: 'Отряд',
                    value: 'squad',
                    type: 'text',
                    sortable: false

                },
                {
                    text: 'Семейство',
                    value: 'family',
                    type: 'text',
                    sortable: false

                },
                {
                    text: 'Род',
                    value: 'genus',
                    type: 'text',
                    sortable: false

                },
                {
                    text: 'Вид',
                    value: 'kind',
                    type: 'text',
                    sortable: false

                }
            ]
        }
    },
    methods: {
        doSearch: _.debounce(function (e) {
            this.$refs.redbook.getDataFromApi(this.search)
        }, 500),
    }
}
</script>

<style scoped>

</style>
