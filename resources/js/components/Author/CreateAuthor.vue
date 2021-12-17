<template>
    <div>
        <v-toolbar
            class="elevation-10">

            <v-banner>После того как вы внесли все изменения, пожалуйста сохраните их</v-banner>
            <v-spacer></v-spacer>

            <v-btn color="primary" @click="saveAuthor">
                Сохранить
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
                    </v-row><v-row>
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
                <crop-image ref="cropper" :dialog-max-width="700" :max-width="700" :max-height="490" :min-crop-box-height="343" :min-crop-box-width="250" :aspect-ratio="343/250" :value="author.preview_image"/>
            </v-tab-item>
            <v-tab-item>
                <v-card>
                    <editor ref="editor" :content="author.biography"></editor>
                </v-card>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>
import CropImage from "../Reusable/CropImage";
import Editor from "../Reusable/Editor";

export default {
    name: "CreateAuthor",
    components: {
        CropImage,
        Editor
    },
    mounted() {
        this.$store.commit('changeHeaderText', 'Добавить автора')
    },
    data() {
        return {
            imgSrc: '',
            cropImg: '',
            data: null,
            author: {
                full_name: '',
                biography: '',
                preview_image: '',
                slug: ''
            },
            tab: 2,
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
            var formData = new FormData();

            this.buildFormData(formData, this.author)

            if (this.$refs.cropper && this.$refs.cropper.croppedBlob) {
                formData.append('preview_image', this.$refs.cropper.croppedBlob)
            }

            if (this.$refs.editor && CKEDITOR.instances.editor111.getData()) {
                formData.append('biography', CKEDITOR.instances.editor111.getData())
            } else {
                this.$store.commit('triggerSnack', {
                    text: 'Заполните контент, хотя бы одним символом',
                    color: 'orange'
                })
                return;
            }

            this.$http.post('/api/authors/create', formData)
                .then(res => {
                    this.$store.commit('triggerSnack', {text: 'Автор добавлен', color: 'green'})
                    this.$router.push({name: 'update-author', params: {id: res.data.data.id}});
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
        }
    }
}
</script>

<style scoped>

</style>
