<template>
    <div>
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
        >
            <v-select
                v-model="article"
                :items="articles"
                item-text="title"
                item-value="id"
                persistent-hint
                return-object
                @change="articleSelected"
                single-line
                :rules="[v => !!v || 'Выберите статью']"
                label="Статья"
                required
            ></v-select>

            <v-text-field
                v-model="title"
                :counter="100"
                label="Заголовок"
                required
            ></v-text-field>

            <v-text-field
                v-model="body"
                :counter="254"
                :rules="[v => !!v || 'Обязательное поле']"
                label="Описание"
                required
            ></v-text-field>

            <v-text-field
                v-model="subject"
                :counter="100"
                :rules="[v => !!v || 'Обязательное поле']"
                label="Титул"
                required
            ></v-text-field>

            <v-btn v-if="!loading" class="success" text @click="submitMailing">
                Отправить рассылку
            </v-btn>
            <v-progress-circular
                v-if="loading"
                :width="3"
                color="green"
                indeterminate
            ></v-progress-circular>
        </v-form>
    </div>
</template>

<script>
export default {
    name: "SubmitMailing",
    mounted() {
        this.$store.commit('changeHeaderText', 'Отправка рассылки')
        this.getArticles()
    },
    data() {
        return {
            valid: null,
            loading: false,
            title: '',
            body: '',
            article: '',
            articles: [],
            subject: 'Табигат медиа рекомендует к чтению'
        }
    },
    methods: {
        getArticles() {
            this.$http.get('/api/articles?itemsPerPage=10000000&include=author')
                .then(res => {
                    this.articles = res.data.data.data;
                })
        },
        submitMailing() {
            this.$refs.form.validate()
            if (!this.valid) return;

            this.loading = true;

            this.$http.post('/api/mailings/send', {
                article: this.article,
                body: this.body,
                title: this.title,
                subject: this.subject
            }).then(res => {
                this.loading = false;
                this.$store.commit('triggerSnack', {text: 'Рассылка отправлена успешно!', color: 'green'})
            })
        },
        articleSelected() {
            this.title = this.article.title;
            this.body = this.article.description;
        }
    }
}
</script>

<style scoped>

</style>
