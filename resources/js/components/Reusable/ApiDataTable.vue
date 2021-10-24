<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="items"
            :options.sync="options"
            :server-items-length="totalItems"
            :loading="loading"
            class="elevation-1"
            :loading-text="loadingText"
            :footer-props="{'items-per-page-options': [15, 30, 50, 100]}"
        >
<!--            @TODO refactor template as props-->
                <template v-slot:item.is_preferable="{ item }" v-if="parent === 'rubric'">
                    <v-simple-checkbox
                        v-model="item.is_preferable"
                    ></v-simple-checkbox>
                </template>
                <template v-slot:item.is_visible="{ item }" v-if="parent === 'rubric'">
                    <v-simple-checkbox
                        v-model="item.is_visible"
                    ></v-simple-checkbox>
                </template>
                <template v-slot:item.order="props" v-if="parent === 'rubric'">
                    <v-edit-dialog
                        :return-value.sync="props.item.order"
                    >
                        {{ props.item.order }}
                        <template v-slot:input>
                            <v-text-field
                                type="number"
                                v-model="props.item.order"
                                label="Проставить очередность"
                                single-line
                                counter
                            ></v-text-field>
                        </template>
                    </v-edit-dialog>
                </template>

        </v-data-table>
        <v-snackbar
            v-model="snack"
            :timeout="3000"
            color="primary"
        >
            {{ snackText }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    v-bind="attrs"
                    text
                    @click="snack = false"
                >
                    Закрыть
                </v-btn>
            </template>
        </v-snackbar>
    </div>
</template>

<script>
export default {
    name: "ApiDataTable",
    props: {
        headers: Array,
        loadingText: String,
        apiUrl: String,
        parent: String
    },
    data() {
        return {
            snack: false,
            snackColor: '',
            snackText: '',
            loading: true,
            items: [],
            options: {},
            totalItems: 0,
            parentName: ''
        }
    },
    watch: {
        options: {
            handler() {
                this.getDataFromApi()
            },
            deep: true,
        }
    },
    methods: {
        getDataFromApi() {
            console.log(this.options)
            this.loading = true;
            this.apiCall()
                .then(res => {
                    console.log(res)
                    this.loading = false;
                    this.items = res.data.data.data;
                    this.totalItems = res.data.data.total;
                })
        },
        apiCall() {
            const {sortBy, sortDesc, page, itemsPerPage} = this.options
            return this.$http.get(this.apiUrl, {
                params: {
                    sort: sortBy[0] ? `${sortDesc[0] ? '-' : ''}${sortBy[0]}` : 'id',
                    sortDesc,
                    page,
                    itemsPerPage
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
