<template>
    <div>
        <v-row justify="space-between" align-content="center" class="mt-auto mb-auto">
            <v-col cols="4" v-show="!loading" v-if="daily">
                <v-card
                    class="mx-auto"
                    max-width="400"
                >
                    <v-img
                        class="white--text align-end"
                        height="200px"
                        :src="daily.preview_image_big_url ? daily.preview_image_big_url : daily.preview_image_small_url"
                    >
                        <v-card-title>{{ daily.title }}</v-card-title>
                    </v-img>

                    <v-card-subtitle class="pb-0">
                        ID {{ daily.id }}
                    </v-card-subtitle>

                    <v-card-text class="text--primary">
                        <div>{{ daily.author.full_name }}</div>

                        <div>Количество просмотров: {{ daily.views }}</div>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn
                            color="red"
                            text
                            @click="deleteDaily"
                        >
                            Убрать
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="4" class="mr-auto" v-show="!daily && !loading">
                <v-card
                    class="mx-auto"
                    width="400"
                    height="350"
                >
                    <v-dialog
                        v-model="dialog"
                        width="600px"
                        height="600px"
                        scrollable
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-row align-content="center" justify="center">
                                <v-icon dense v-bind="attrs" v-on="on" size="350px" color="#E3DDDC">mdi-plus</v-icon>
                            </v-row>
                        </template>
                        <v-card>
                            <v-select
                                class="mt-2 mb-2 ml-2 mr-2"
                                v-model="chosenArticle"
                                :items="articles"
                                item-text="title"
                                item-value="id"
                                label="Выберите статью"
                                persistent-hint
                                return-object
                                single-line
                                v-on:change="dailySelected"
                            ></v-select>
                        </v-card>
                    </v-dialog>
                </v-card>
            </v-col>
            <v-col cols="4" v-show="loading" v-for="i in 1" :key="i+'asd'">
                <v-skeleton-loader
                    width="350"
                    height="400"
                    type="card"
                ></v-skeleton-loader>
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    name: "DailyArticle",
    mounted() {
        this.getDaily()
        this.getArticles()
        this.$store.commit('changeHeaderText', 'Статья дня')
    },
    data() {
        return {
            daily: null,
            loading: false,
            articles: [],
            chosenArticle: {},
            dialog: false,
        }
    },
    methods: {
        getArticles() {
            this.$http.get('/api/articles?filter[daily]=0&itemsPerPage=10000000&include=author')
                .then(res => {
                    this.articles = res.data.data.data;
                })
        },
        getDaily() {
            this.loading = true;
            this.$http.get('/api/articles?filter[daily]=1&include=author')
                .then(res => {
                    this.daily = res.data.data.data[0];
                    this.sleep(2000).then(rs => {
                        this.loading = false;
                    })
                })
        },
        dailySelected() {
            this.dialog = false;
            this.$http.post(`/api/articles/add-daily/${this.chosenArticle.id}`)
                .then(res => {
                    console.log(res.data.data);
                    this.daily = res.data.data;
                    this.$store.commit('triggerSnack', {text: 'Дневная статья добавлена', color: 'green'})
                    this.chosenArticle = null;
                    this.getArticles();
                })
                .catch(res => {
                    this.$store.commit('triggerSnack', {text: 'Ошибка', color: 'red'})
                    this.dialog = false;
                    this.chosenArticle = null;
                })
        },
        deleteDaily() {
            this.$http.post(`/api/articles/delete-daily/${this.daily.id}`)
                .then(res => {
                    console.log(res)
                    this.daily = null;
                    this.$store.commit('triggerSnack', {text: 'Статья дня удалена', color: 'green'})
                    this.getArticles();
                })
                .catch(res => {
                    this.$store.commit('triggerSnack', {text: 'Ошибка', color: 'red'})
                })
        },
        sleep(time) {
            return new Promise((resolve) => setTimeout(resolve, time));
        }
    }
}
</script>

<style scoped>

</style>
