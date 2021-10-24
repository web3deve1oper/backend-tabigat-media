<template>
    <div>

        <v-dialog
            v-model="dialog"
            max-width="700px"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="primary"
                    dark
                    class="mb-2"
                    @click="changeRubricType('create')"
                    v-bind="attrs"
                    v-on="on"
                >
                    Добавить рубрику
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <span class="text-h5">{{ dialogType === 'create' ? 'Добавить рубрику' : ' Редактировать рубрику' }}</span>
                </v-card-title>

                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col
                                cols="12"
                            >
                                <v-text-field
                                    v-model="dialogRubric.title"
                                    label="Название"
                                    :rules="[value => !!value || 'Обязательное поле']"
                                    :error-messages="titleError"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="3"
                            >
                                <v-text-field
                                    v-model="dialogRubric.order"
                                    label="Позиция"
                                    :rules="[value => !!value || 'Обязательное поле']"
                                    type="number"
                                    :error-messages="orderError"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="3"
                            >
                                <v-checkbox
                                    v-model="dialogRubric.is_preferable"
                                    label="Основной"
                                ></v-checkbox>
                            </v-col>
                            <v-col
                                cols="6"
                            >
                                <v-checkbox
                                    v-model="dialogRubric.is_visible"
                                    label="Отоброжать на платформе"
                                ></v-checkbox>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="closeDialog"
                    >
                        Отмена
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="submitDialog"
                    >
                        Сохранить
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <ApiDataTable
            :headers="headers"
            loading-text="Загрузка рубрик"
            api-url="/api/rubrics"
            ref="rubrics"
            parent="rubric"
        >
        </ApiDataTable>

        <v-btn
            depressed
            color="success"
            @click="saveInfo"
        >
            Сохранить
        </v-btn>
    </div>
</template>

<script>
import ApiDataTable from "../Reusable/ApiDataTable";

export default {
    name: "Rubric",
    components: {ApiDataTable},
    created() {
        this.$store.commit('changeHeaderText', 'Управление рубриками');
    },
    data() {
        return {
            orderError: null,
            titleError: null,
            dialogType: '',
            dialogRubric : {is_preferable: false, is_visible:false},
            dialog: false,
            headers: [
                {
                    text: 'ID',
                    align: 'start',
                    value: 'id'
                },
                {
                    text: 'Название',
                    align: 'start',
                    value: 'title'
                },
                {
                    text: 'Позиция',
                    align: 'start',
                    value: 'order'
                },
                {
                    text: 'Основной',
                    align: 'center',
                    value: 'is_preferable',
                    sortable: false,
                },
                {
                    text: 'Отоброжать в списке',
                    align: 'center',
                    value: 'is_visible',
                    sortable: false
                }
            ],
            rubrics: null
        }
    },
    methods: {
        saveInfo() {
            if (!this.isValidOrders()) {
                console.log(this.isValidOrders())
                this.$refs.rubrics.snackColor = 'red';
                this.$refs.rubrics.snackText = 'Позиции рубик не должны повторятся!'
                this.$refs.rubrics.snack = true;
                return;
            }

            this.$refs.rubrics.loading = true;
            this.$http.post('/admin/rubrics/edit-info', {
                rubrics: this.$refs.rubrics.items
            })
            .then(res => {
                this.$refs.rubrics.snack = true;
                this.$refs.rubrics.snackText = 'Успех'
                this.$refs.rubrics.loading = false;

                this.$refs.rubrics.getDataFromApi()
            })
            .catch(err => {
                this.$refs.rubrics.snack = true;
                this.$refs.rubrics.snackText = `Ошибка проверьте целостность данных`
                this.$refs.rubrics.loading = false;
            })
        },
        isValidOrders() {
            let result = this.$refs.rubrics.items.map(a => a.order);
            return new Set(result).size === this.$refs.rubrics.items.length
        },
        closeDialog() {
            this.dialog = false;
            this.dialogRubric = {};
            this.dialogType = '';
            this.orderError = null;
            this.titleError = null;
        },
        submitDialog() {
            this.titleError = null;
            this.orderError = null;
            this.$refs.rubrics.loading = true;
            this.$http.post('/admin/rubrics/upsert', {
                rubric: this.dialogRubric
            }).then(res => {
                console.log(res)
                this.$refs.rubrics.snack = true;
                this.$refs.rubrics.snackText = 'Успех'
                this.$refs.rubrics.loading = false;
                this.closeDialog();
                this.$refs.rubrics.getDataFromApi();
            })
            .catch(err => {
                console.log(err.response);
                if ('rubric.order' in err.response.data.errors) {
                    this.orderError = 'Должен быть уникальным';
                }

                if ('rubric.title' in err.response.data.errors) {
                    this.titleError = 'Должен быть уникальным';
                }

                this.$refs.rubrics.snack = true;
                this.$refs.rubrics.snackText = err.message;
                this.$refs.rubrics.loading = false;
            })
        },
        changeRubricType(type) {
            this.dialogType = type;
            this.dialogRubric = {};
        }
    }
}
</script>

<style scoped>

</style>
