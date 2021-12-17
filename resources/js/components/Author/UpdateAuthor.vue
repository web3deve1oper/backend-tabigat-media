<template>
    <div>
        <v-toolbar
            class="elevation-10">

            <v-banner>После того как вы внесли все изменения, пожалуйста сохраните их</v-banner>
            <v-spacer></v-spacer>

            <v-btn color="red mr-3" @click="deleteDialog = true">
                Удалить
            </v-btn>
            <v-btn color="primary" @click="saveAuthor">
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
            <v-tab-item>
                <v-card flat max-width="700px" max-height="2000px" class="ml-auto mr-auto mt-5 mb-10">
                    <v-row>
                        <v-text-field
                            v-model="author.full_name"
                            label="ФИО"
                            :rules="notEmptyRule"
                            counter="255"
                            clearable
                        ></v-text-field>
                    </v-row>
                    <v-row>
                        <v-text-field
                            v-model="author.slug"
                            label="Slug"
                            :rules="notEmptyRule"
                            counter="255"
                            clearable
                        ></v-text-field>
                    </v-row>
                </v-card>
            </v-tab-item>
            <v-tab-item>
                <crop-image ref="cropper" :dialog-max-width="700" :max-width="700" :max-height="490"
                            :min-crop-box-height="343" :min-crop-box-width="250" :aspect-ratio="343/250"
                            :value="author.preview_image_url"/>
            </v-tab-item>
            <v-tab-item>
                <v-card>
                    <editor ref="editor" :content="author.biography"></editor>
                </v-card>
            </v-tab-item>
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
                        @click="deleteAuthor"
                    >
                        Удалить
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>

</template>

<script>
import CropImage from "../Reusable/CropImage";
import Editor from "../Reusable/Editor";

export default {
    name: "UpdateAuthor",
    components: {
        CropImage,
        Editor
    },
    mounted() {
        this.getAuthor();
    },
    data() {
        return {
            overlay: false,
            deleteDialog: false,
            imgSrc: '',
            cropImg: '',
            data: null,
            author: {
                full_name: '',
                biography: '',
                preview_image: '',
                slug: ''
            },
            tab: null,
            tabs: [
                {
                    title: 'Основная информация',
                    name: 'general-info',
                    icon: 'mdi-collage'
                },
                {
                    title: 'Фото автора',
                    name: 'upload-image',
                    icon: 'mdi-image-plus'
                },
                {
                    title: 'Биография',
                    name: 'content',
                    icon: 'mdi-content-copy'
                }
            ],
            notEmptyRule: [
                v => !!v || 'Обязательное поле',
            ]
        }
    },
    methods: {
        saveAuthor() {
            this.overlay = true;
            var formData = new FormData();

            this.buildFormData(formData, this.author)
            if (this.$refs.cropper && this.$refs.cropper.croppedBlob) {
                formData.append('preview_image', this.$refs.cropper.croppedBlob)
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

            this.$http.post(`/api/authors/${this.author.id}/update`, formData)
                .then(res => {
                    this.overlay = false;
                    this.$store.commit('triggerSnack', {text: 'Автор изменен', color: 'green'})
                })
                .catch(err => {
                    this.$store.commit('triggerSnack', {text: 'Обновите страницу', color: 'red'})
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
        getAuthor() {
            this.overlay = true;

            this.$http.get(`/api/authors/${this.$route.params.id}`)
                .then(res => {
                    this.author = res.data.data;
                    this.$store.commit('changeHeaderText', 'Изменить автора: ' + this.author.full_name)
                    this.overlay = false;
                })
                .catch(res => {
                    this.$router.push('/admin/authors');
                })
        },
        deleteAuthor() {
            this.overlay = true;

            this.$http.delete(`/api/authors/${this.author.id}`)
                .then(res => {
                    this.$router.push('/admin/authors')
                    this.$store.commit('triggerSnack', {text: 'Автор удален', color: 'green'})
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
