<template>
    <div>
        <v-toolbar
            class="elevation-10">

            <v-banner>После того как вы внесли все изменения, пожалуйста сохраните их</v-banner>
            <v-spacer></v-spacer>

            <v-btn color="red mr-3" @click="deleteDialog = true">
                Удалить
            </v-btn>

            <v-btn color="primary" @click="updateArticle">
                Изменить
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
                                v-model="article.title"
                                label="Название"
                                :rules="notEmptyRule"
                                counter="255"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="article.slug"
                                label="Слаг"
                                :rules="notEmptyRule"
                                counter="255"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="article.description"
                                counter="255"
                                :rules="notEmptyRule"
                                label="Краткое описание"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-select v-model="article.rubric_id"
                                      :items="rubrics"
                                      item-text="title"
                                      item-value="id"
                                      label="Рубрика"
                                      required
                            >
                            </v-select>
                        </v-row>
                        <v-row>
                            <v-text-field
                                v-model="article.read_time"
                                label="Время прочтения"
                                clearable
                            ></v-text-field>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-checkbox
                                    v-model="article.posted"
                                    label="Опубликовать"
                                ></v-checkbox>
                            </v-col>
                            <v-col>
                                <v-checkbox
                                    v-model="article.is_long_read"
                                    label="Long read"
                                ></v-checkbox>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-combobox
                                v-model="article.tags"
                                :items="existingTags"
                                chips
                                clearable
                                label="Теги"
                                multiple
                                prepend-icon="mdi-filter-variant"
                                solo
                            >
                                <template v-slot:selection="{ attrs, item, select, selected }">
                                    <v-chip
                                        v-bind="attrs"
                                        :input-value="selected"
                                        close
                                        @click="select"
                                        @click:close="removeTag(item)"
                                    >
                                        <strong>#{{ item }}</strong>&nbsp;
                                    </v-chip>
                                </template>
                            </v-combobox>
                        </v-row>
                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <v-card flat max-width="900px" height="2000px" class="ml-auto mr-auto mt-5">
                        <v-row>
                            <v-select v-model="article.author_id"
                                      :items="authors"
                                      item-text="full_name"
                                      item-value="id"
                                      label="Автор статьи"
                                      required
                            >
                            </v-select>
                        </v-row>
                        <v-banner class="mt-5 mb-2">Ко-авторы
                            <v-btn small class="ml-10" @click="addStaff">Добавить еще</v-btn>
                        </v-banner>
                        <v-simple-table dense>
                            <template v-slot:default>
                                <thead>
                                <tr>
                                    <th class="text-left">
                                        Должность в создании статьи
                                    </th>
                                    <th class="text-left">
                                        Имя
                                    </th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="(st,index) in article.staff"
                                    :key="index + 'st'"
                                >
                                    <td>
                                        <v-text-field single-line :rules="notEmptyRule" v-model="st.title"
                                                      placeholder="Впишите позицию"></v-text-field>
                                    </td>
                                    <td>
                                        <v-text-field single-line v-model="st.full_name" :rules="notEmptyRule"
                                                      placeholder="Впишите имя"></v-text-field>
                                    </td>
                                    <td>
                                        <v-btn color="red" x-small depressed @click="removeStaff(index)">
                                            X
                                        </v-btn>
                                    </td>
                                </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <crop-image class="mb-10"
                                v-show="!article.is_long_read"
                                ref="cropperBig"
                                :value="article.preview_image_big_url"
                                key="big"
                                :min-crop-box-height="400"
                                :min-crop-box-width="1200"
                                :aspect-ratio="3"
                                label="Выберите картинку с большим размером"
                                :rules="notEmptyRule"
                    />

                    <crop-image ref="cropperSmall"
                                :value="article.preview_image_small_url"
                                key="small"
                                label="Выберите картинку с меньшим размером"
                                :dialog-max-width="700"
                                :min-crop-box-height="300"
                                :min-crop-box-width="600"
                                :aspect-ratio="2"
                                :rules="notEmptyRule"/>

                    <v-text-field
                        class="ml-10 mr-10"
                        v-model="article.photography"
                        label="Автор фотографии"
                        clearable
                    ></v-text-field>
                </v-tab-item>
                <v-tab-item>
                    <v-card>
                        <vue-editor v-model="article.content"
                                    useCustomImageHandler
                                    @image-added="handleImageAdded"
                                    id="contentEditor"
                        ></vue-editor>
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
                        @click="deleteArticle"
                    >
                        Удалить
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
import VueCropper from 'vue-cropperjs';
import 'cropperjs/dist/cropper.css';
import CropImage from "../Reusable/CropImage";
import {VueEditor} from "vue2-editor";


export default {
    name: "UpdateArticle",
    components: {
        VueCropper,
        CropImage,
        VueEditor
    },
    mounted() {
        this.getAuthors()
        this.getArticle()
        this.getRubrics()
    },
    data() {
        return {
            validForm: true,
            existingTags: [],
            imgSrc: '',
            overlay: true,
            cropImg: '',
            data: null,
            authors: [],
            article: {},
            tab: null,
            tabs: [
                {
                    title: 'Основная информация',
                    name: 'general-info',
                    icon: 'mdi-collage'
                },
                {
                    title: 'Авторы',
                    name: 'authors',
                    icon: 'mdi-human-edit',
                },
                {
                    title: 'Обложка статьи',
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
            rubrics: [],
            deleteDialog: false
        }
    },
    methods: {
        getAuthors() {
            this.$http.get('/api/authors')
                .then(res => {
                    console.log(res)
                    this.authors = res.data.data.data;
                })
        },
        getRubrics() {
            this.$http.get('/api/rubrics')
                .then(res => {
                    this.rubrics = res.data.data.data;
                })
        },
        removeStaff(index) {
            this.article.staff.splice(index, 1)
        },
        addStaff() {
            this.article.staff.push({title: 'Художник', full_name: 'Тестов Тест'})
        },
        handleImageAdded: function (file, Editor, cursorLocation, resetUploader) {
            var formData = new FormData();
            formData.append("file", file);

            this.$http.post('/api/articles/upload-temp-image',
                formData
            )
                .then(result => {
                    const url = result.data.data.url; // Get url from response
                    Editor.insertEmbed(cursorLocation, "image", url);
                    resetUploader();
                })
                .catch(err => {
                    console.log(err);
                });
        },
        updateArticle() {
            if (!this.$refs.form.validate()) {
                this.$store.commit('triggerSnack', {text: 'Перепровьте данные', color: 'red'})
                return;
            }

            var formData = new FormData();

            if (this.$refs.cropperBig && this.$refs.cropperBig.croppedBlob) {
                formData.append('preview_image_big', this.$refs.cropperBig.croppedBlob)
            }
            if (this.$refs.cropperSmall && this.$refs.cropperSmall.croppedBlob) {
                formData.append('preview_image_small', this.$refs.cropperSmall.croppedBlob)
            }

            this.buildFormData(formData, this.article)

            this.$http.post(`/api/articles/${this.article.id}/update`, formData)
                .then(res => {
                    this.$store.commit('triggerSnack', {text: 'Статья отредактирована', color: 'green'})
                })
                .catch(err => {
                    console.log(err)
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
        getArticle() {
            this.$http.get(`/api/articles/${this.$route.params.id}`)
                .then(res => {
                    this.article = res.data.data;
                    if (this.article.posted_at) {
                        this.article.posted = true;
                    }
                    this.$store.commit('changeHeaderText', 'Изменить статью:' + this.article.title)
                    this.article.staff = res.data.data.staff ?? [];
                    this.article.tags = res.data.data.tags.map(a => a.name);
                    this.overlay = false;
                })
                .catch(err => {
                    console.log(err)
                })
        },
        deleteArticle() {
            this.overlay = true

            this.$http.delete(`/api/articles/${this.article.id}`)
                .then(res => {
                    this.overlay = false;
                    this.$store.commit('triggerSnack', {text: "Успешно удалено", color: "green"})
                    this.$router.push('/admin/articles')
                })
                .catch(res => {
                    this.overlay = false;
                    this.$store.commit('triggerSnack', {text: "Ошибка! Перезагрузите страницу", color: "red"})
                })
        },
        getTags() {
            this.$http('/api/tags')
                .then(res => {
                    this.existingTags = res.data.data.map(a => a.name);
                })
                .catch(err => {

                })
        },
        removeTag(item) {
            this.article.tags.splice(this.article.tags.indexOf(item), 1)
            this.article.tags = [...this.article.tags]
        },
    }
}
</script>

<style scoped>

</style>
