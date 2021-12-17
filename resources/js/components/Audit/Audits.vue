<template>
    <ApiDataTable api-url="/api/audits"
                  loading-text="Загрузка аудитов"
                  :headers="headers"
                  :api-includes="apiIncludes"
                  ref="audits"
                  :redirect-to-edit-page-on-row-click="true"
                  model-name="audits"
                  :show-select="false">
    </ApiDataTable>
</template>

<script>
import ApiDataTable from "../Reusable/ApiDataTable";
import _ from 'lodash';

export default {
    name: "Audits",
    components: {
      ApiDataTable
    },
    mounted() {
        this.$store.commit('changeHeaderText', 'Журнал аудита')
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
                    text: 'Измененная Модель:',
                    value: 'auditable_type',
                    type: 'text',
                    sortable: false,
                    translation: true
                },
                {
                    text: 'ID имзененной модели',
                    value: 'auditable_id',
                    type: 'text',
                    sortable: false
                },
                {
                    text: 'Пользователь:',
                    value: 'user_id',
                    type: 'text',
                    sortable: false
                },
                {
                    text: 'IP',
                    value: 'ip_address',
                    type: 'text',
                    sortable: false
                },
                {
                    text: 'Агент',
                    value: 'user_agent',
                    type: 'text',
                    sortable: false
                },
                {
                    text: 'Тип изменения',
                    value: 'event',
                    type: 'text',
                    sortable:false,
                    translation: true
                },
                {
                    text: 'Дата изменения',
                    value: 'created_at',
                    type: 'text',
                    sortable:false,
                    translation: true
                }
            ],
            apiIncludes: '',
            search: ''
        }
    },

}
</script>

<style scoped>

</style>
