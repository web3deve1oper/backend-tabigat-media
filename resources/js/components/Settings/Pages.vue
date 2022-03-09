<template>
    <div>
        <v-toolbar
            class="elevation-10">

            <v-banner>После того как вы внесли все изменения, пожалуйста сохраните их</v-banner>
            <v-spacer></v-spacer>

            <v-btn color="primary" @click="savePages" :loading="btnLoading">
                Сохранить
            </v-btn>

            <template v-slot:extension>

                <v-tabs
                    v-model="tab"
                    centered
                >
                    <v-tab
                        v-for="n in tabs"
                        :key="n"
                    >
                        {{ n }}
                    </v-tab>
                </v-tabs>
            </template>
        </v-toolbar>

        <v-tabs-items v-model="tab" class="mt-5" v-if="!loading">
            <v-tab-item>
                <v-card>
                    <editor ref="pagesAbout" :content="pages.about" uniqueId="pagesAbout"></editor>
                </v-card>
            </v-tab-item>
            <v-tab-item :eager="true">
                <v-card>
                    <editor ref="pagesConfidentialityPolicy" :content="pages.confidentiality_policy" uniqueId="pagesConfidentialityPolicy"></editor>
                </v-card>
            </v-tab-item>
            <v-tab-item :eager="true">
                <v-card>
                    <editor ref="pagesLegalInformation" :content="pages.legal_information" uniqueId="pagesLegalInformation"></editor>
                </v-card>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>
import Editor from "../Reusable/Editor";

import axios from "axios";

export default {
    components: {
        Editor,
    },
    name: "Pages",
    mounted() {
        this.$store.commit('changeHeaderText', 'Страницы сайта')
        this.getPages()
    },
    data() {
        return {
            tab: null,
            tabs: [
                'О проекте',
                'Политика конфиденциальности',
                'Правовая информация'
            ],
            pages: {},
            btnLoading: false,
            loading: false
        }
    },
    methods: {
        savePages() {
            this.btnLoading = true;

            console.log(CKEDITOR.instances.pagesAbout.getData());
            console.log(CKEDITOR.instances.pagesConfidentialityPolicy.getData());
            console.log(CKEDITOR.instances.pagesLegalInformation.getData());

            this.$http.post('/api/page-settings', {
                pages: {
                    about: CKEDITOR.instances.pagesAbout.getData(),
                    confidentiality_policy: CKEDITOR.instances.pagesConfidentialityPolicy.getData(),
                    legal_information: CKEDITOR.instances.pagesLegalInformation.getData(),

                }
            }).then(res => {
                this.btnLoading = false;
                this.$store.commit('triggerSnack', {text: 'Успешно обновлено', color: 'green'})
            }).catch(err => {
                console.log(err)
                this.btnLoading = false;
                this.$store.commit('triggerSnack', {text: 'Ошибка', color: 'green'})
            })
        },

        getPages() {
            this.loading = true;
            axios.all([
                this.$http.get('/api/page-settings?key=about')
                    .then(res => {
                        console.log(res);
                        this.pages.about = res.data.data;
                    })
                    .catch(err => {
                        console.log(err);
                    }),
                this.$http.get('/api/page-settings?key=confidentiality_policy')
                    .then(res => {
                        console.log(res);
                        this.pages.confidentiality_policy = res.data.data;
                    })
                    .catch(err => {
                        console.log(err);
                    }),
                this.$http.get('/api/page-settings?key=legal_information')
                    .then(res => {
                        console.log(res);
                        this.pages.legal_information = res.data.data;
                    })
                    .catch(err => {
                        console.log(err);
                    })
            ]).then(res => {
                this.loading = false;
            })

        }
    }
}
</script>

<style scoped>

</style>
