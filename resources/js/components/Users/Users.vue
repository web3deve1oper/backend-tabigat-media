<template>
    <div>
        <v-btn
            color="primary"
            class="mb-2"
            dark
            @click="$router.push({name:'create-user'})"
        >
            Добавить автора
        </v-btn>
        <ApiDataTable
            :headers="headers"
            loading-text="Загрузка авторов"
            api-url="/api/users"
            ref="users"
            model-name="users"
            :redirect-to-edit-page-on-row-click="true"
        >
        </ApiDataTable>
    </div>
</template>

<script>
import ApiDataTable from "../Reusable/ApiDataTable";

export default {
    name: "Users",
    components: {ApiDataTable},
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
                    value: 'name',
                    type: 'text'
                },
                {
                    text: 'Email',
                    value: 'email',
                    type : 'text'
                },
                {
                    text: 'Создан',
                    value: 'created_at',
                    type: 'text'
                }
            ],
        }
    }
}
</script>

<style scoped>

</style>
