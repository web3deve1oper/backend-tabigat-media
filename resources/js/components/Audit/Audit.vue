<template>
    <v-simple-table v-if="audit">
        <template v-slot:default>
            <thead>
            <tr>
                <th class="text-left">
                    Поле
                </th>
                <th class="text-left">
                    Старое значение
                </th>
                <th class="text-left">
                    Новое значение значение
                </th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(value, name) in audit.new_values"
                :key="name"
            >
                <td>{{ name }}</td>
                <td v-if="name === 'content' || name ==='biography'" class="text-left" colspan="2">
                    <v-dialog
                        v-model="dialog"
                        fullscreen
                        hide-overlay
                        transition="dialog-bottom-transition"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                class="primary ml-lg-15 "
                                text
                                v-bind="attrs"
                                v-on="on"
                            >
                                просмотреть
                            </v-btn>
                        </template>
                        <v-card>
                            <v-toolbar
                                dark
                                color="primary"
                            >
                                <v-btn
                                    icon
                                    dark
                                    @click="dialog = false"
                                >
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                                <v-toolbar-title>Разница контента</v-toolbar-title>
                                <v-spacer></v-spacer>
                            </v-toolbar>
                            <v-card-text>
                                <code-diff :output-format="'side-by-side'" :old-string="audit.old_values[name]" :new-string="value" :context="10" />
                            </v-card-text>
                        </v-card>
                    </v-dialog>
                </td>
                <td v-if="name !== 'content' && name !== 'biography'">
                    <span v-if="name === 'preview_image_big_url' || name === 'preview_image_small_url'"><a
                        :href="audit.old_values[name] ">картинка</a></span>
                    <span v-else>{{ audit.old_values[name] ? audit.old_values[name] : '-' }}</span>
                </td>
                <td v-if="name !== 'content' && name !== 'biography'">
                    <span v-if="name === 'preview_image_big_url' || name === 'preview_image_small_url'"><a
                        :href="value">картинка</a></span>
                    <span v-else>{{ value ? value : '-' }}</span>
                </td>
            </tr>
            </tbody>
        </template>
    </v-simple-table>

</template>

<script>
import CodeDiff from 'vue-code-diff';

export default {
    name: "Audit",
    components: {
      CodeDiff
    },
    data() {
        return {
            audit: null,
            dialog: null
        }
    },
    mounted() {
        this.getAudit()
    },
    methods: {
        getAudit() {
            this.$http.get(`/api/audits/${this.$route.params.id}`)
                .then(res => {
                    console.log(res.data.data)
                    this.audit = res.data.data;
                    this.$store.commit('changeHeaderText', `Изменение ${this.audit.id}. Измененения внес: ${this.audit.user.name}`)

                })
                .catch(err => {
                    this.$store.commit('triggerSnack', 'Произошла ошибка')
                    console.log(err)
                })
        }
    }
}
</script>

<style scoped>

</style>
