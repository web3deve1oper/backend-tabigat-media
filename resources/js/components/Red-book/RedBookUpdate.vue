<template>
    <div>
        <v-toolbar
            class="elevation-10">

            <v-banner>После того как вы внесли все изменения, пожалуйста сохраните их</v-banner>
            <v-spacer></v-spacer>


            <v-btn color="red mr-3" @click="deleteDialog = true">
                Удалить
            </v-btn>

            <v-btn color="primary" @click="saveSpecie()">
                сохранить
            </v-btn>

            <template v-slot:extension>

                <v-tabs
                    v-model="tab"
                    centered
                >
                    <v-tab
                        v-for="n in tabs"
                        :key="n.name"
                    >
                        {{ n.title }}
                        <v-icon>{{ n.icon }}</v-icon>
                    </v-tab>
                </v-tabs>
            </template>
        </v-toolbar>

        <v-tabs-items v-model="tab" class="mt-5">
            <v-form ref="form"
                    v-model="validForm"
                    lazy-validation>
                <v-tab-item>
                    <v-card flat max-width="700px" max-height="2000px" class="ml-auto mr-auto mt-5 mb-10">
                        <v-row>
                            <v-text-field
                                v-model="specie.name"
                                label="Название"
                                :rules="notEmptyRule"
                                counter="255"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="specie.name_latin"
                                counter="255"
                                :rules="notEmptyRule"
                                label="Латинское название"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="specie.description"
                                counter="255"
                                label="Описание"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="specie.slug"
                                label="Слаг"
                                :rules="notEmptyRule"
                                counter="255"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="specie.kingdom"
                                counter="255"
                                label="Царство"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="specie.type"
                                label="Тип"
                                counter="255"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="specie.class"
                                label="Класс"
                                counter="255"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="specie.squad"
                                label="Отряд"
                                counter="255"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="specie.family"
                                label="Семейство"
                                clearable
                                counter="255"
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="specie.genus"
                                label="Род"
                                counter="255"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="specie.kind"
                                label="Вид"
                                counter="255"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="specie.subkind"
                                label="Подвид"
                                counter="255"
                                clearable
                            ></v-text-field>
                        </v-row>
                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <v-card flat max-width="900px" height="2000px" class="ml-auto mr-auto mt-5">
                        <v-row class="d-flex flex-column">
                            <v-banner class="mt-5 mb-2">Интересные факты
                                <v-btn small class="ml-10" @click="addFact">Добавить еще</v-btn>
                            </v-banner>
                            <v-simple-table dense>
                                <template v-slot:default>
                                    <thead>
                                    <tr>
                                        <th class="text-left">
                                            Описание факта
                                        </th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="(st,index) in specie.facts"
                                        :key="index + 'st'"
                                    >
                                        <td>
                                            <v-text-field single-line v-model="specie.facts[index]"
                                                          :rules="notEmptyRule"
                                                          placeholder="Впишите описание"></v-text-field>
                                        </td>
                                        <td>
                                            <v-btn color="red" x-small depressed @click="removeFact(index)">
                                                X
                                            </v-btn>
                                        </td>
                                    </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                        </v-row>
                        <v-row class="d-flex flex-column">
                            <v-banner class="mt-5 mb-2">Статус
                                <v-btn small class="ml-10" @click="addStatus">Добавить еще</v-btn>
                            </v-banner>
                            <v-simple-table dense>
                                <template v-slot:default>
                                    <thead>
                                    <tr>
                                        <th class="text-left">
                                            Описание статуса
                                        </th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="(st,index) in specie.status"
                                        :key="index + 'tt'"
                                    >
                                        <td>
                                            <v-text-field single-line v-model="specie.status[index]"
                                                          :rules="notEmptyRule"
                                                          placeholder="Впишите описание"></v-text-field>
                                        </td>
                                        <td>
                                            <v-btn color="red" x-small depressed @click="removeStatus(index)">
                                                X
                                            </v-btn>
                                        </td>
                                    </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                        </v-row>
                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <crop-image class="mb-10"
                                ref="cropperBig"
                                :value="specie.preview_image_big_url"
                                key="big"
                                :min-crop-box-height="600"
                                :min-crop-box-width="1200"
                                :aspect-ratio="1200/600"
                                label="Выберите картинку с большим размером"
                    />

                    <crop-image ref="cropperSmall"
                                :value="specie.preview_image_small_url"
                                key="small"
                                label="Выберите картинку с меньшим размером"
                                :dialog-max-width="700"
                                :min-crop-box-height="340"
                                :min-crop-box-width="285"
                                :aspect-ratio="285/340"/>
                </v-tab-item>
                <v-tab-item>
                    <v-card>
                        <editor ref="editor" :content="specie.content"
                        ></editor>
                    </v-card>
                </v-tab-item>
            </v-form>
        </v-tabs-items>
        <v-overlay :value="overlay">
            <v-progress-circular
                indeterminate
                size="64"
            ></v-progress-circular>
        </v-overlay>
        <v-dialog
            v-model="deleteDialog"
            persistent
            max-width="600"
        >
            <v-card>
                <v-card-title class="text-h5">
                    Вы действительно хотите удалить?
                </v-card-title>
                <v-card-text>
                    Эти данные нельзя будет вернуть, вы действительно хотите удалить?
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        color="green darken-1"
                        text
                        @click="deleteDialog = false"
                    >
                        Отмена
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="green darken-1"
                        text
                        @click="deleteSpecie"
                    >
                        Удалить
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import VueCropper from "vue-cropperjs";
import CropImage from "../Reusable/CropImage";
import Editor from "../Reusable/Editor";

export default {
    name: "RedBookUpdate",
    components: {
        VueCropper,
        CropImage,
        Editor
    },
    mounted() {
        this.getSpecie()
    },
    data() {
        return {
            validForm: true,
            tab: 3,
            overlay: true,
            specie: {
                facts: [],
                status: []
            },
            tabs: [
                {
                    title: 'Основная информация',
                    name: 'general-info',
                    icon: 'mdi-collage'
                },
                {
                    title: 'Доп. информация',
                    name: 'authors',
                    icon: 'mdi-human-edit',
                },
                {
                    title: 'Картинка вида',
                    name: 'upload-image',
                    icon: 'mdi-image-plus'
                },
                {
                    title: 'Контент',
                    name: 'content',
                    icon: 'mdi-content-copy'
                }
            ],
            notEmptyRule: [
                v => !!v || 'Обязательное поле',
            ],
            deleteDialog: false
        }
    },
    methods: {
        removeFact(index) {
            this.specie.facts.splice(index, 1)
        },
        addFact() {
            this.specie.facts.push('*Интересный факт*')
        },
        removeStatus(index) {
            this.specie.status.splice(index, 1)
        },
        addStatus() {
            this.specie.status.push('*Статус*')
        },
        saveSpecie() {
            this.overlay = true;

            if (!this.$refs.form.validate()) {
                this.$store.commit('triggerSnack', {text: 'Убедитесь что вы заполняли нужные поля', color: 'red'})
                this.overlay = false;
                return;
            }

            var formData = new FormData();
            this.buildFormData(formData, this.specie)

            if (this.$refs.cropperBig && this.$refs.cropperBig.croppedBlob) {
                formData.append('preview_image_big', this.$refs.cropperBig.croppedBlob)
            }
            if (this.$refs.cropperSmall && this.$refs.cropperSmall.croppedBlob) {
                formData.append('preview_image_small', this.$refs.cropperSmall.croppedBlob)
            }

            if (this.$refs.editor && CKEDITOR.instances.editor111.getData()) {
                formData.append('content', CKEDITOR.instances.editor111.getData())
            } else {
                this.$store.commit('triggerSnack', {
                    text: 'Заполните контент, хотя бы одним символом',
                    color: 'orange'
                })
                return;
            }

            this.$http.post(`/api/red-book/${this.specie.id}/update`, formData)
                .then(res => {
                    this.overlay = false;
                    this.$store.commit('triggerSnack', {text: 'Вид обновлен', color: 'green'})
                })
                .catch(err => {
                    this.overlay = false;
                    this.$store.commit('triggerSnack', {text: 'Убедитесь что вы заполняли нужные поля', color: 'red'})
                })
        },
        buildFormData(formData, data, parentKey) {
            if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File)) {
                Object.keys(data).forEach(key => {
                    this.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
                });
            } else {
                const value = data == null ? '' : data;

                formData.append(parentKey, value);
            }
        },
        getSpecie() {
            this.$http.get(`/api/red-book/${this.$route.params.id}`)
                .then(res => {
                    this.specie = res.data.data;
                    this.$store.commit('changeHeaderText', 'Изменить вид: ' + this.specie.name)
                    this.overlay = false;
                })
                .catch(err => {
                    this.$router.push('/admin/red-book');
                })
        },
        deleteSpecie() {
            this.overlay = true;

            this.$http.delete(`/api/red-book/${this.$route.params.id}`)
                .then(res => {
                    this.$store.commit('changeHeaderText', 'Вид успешно удален')
                    this.overlay = false;
                    this.$router.push('/admin/red-book')
                })
                .catch(res => {
                    this.$store.commit('changeHeaderText', 'Ошибка, перезагрузите страницу')
                })
        }
    }
}
</script>

<style scoped>

</style>
