<template>
    <div>
        <v-row justify="space-between" align-content="center" class="mt-auto mb-auto">
            <v-col cols="4" v-for="favourite in favourites" :key="favourite.id">
                <v-card
                    class="mx-auto"
                    max-width="400"
                >
                    <v-img
                        class="white--text align-end"
                        height="200px"
                        :src="favourite.preview_image_big_url ? favourite.preview_image_big_url : favourite.preview_image_small_url"
                    >
                        <v-card-title>{{ favourite.title }}</v-card-title>
                    </v-img>

                    <v-card-subtitle class="pb-0">
                        ID {{ favourite.id }}
                    </v-card-subtitle>

                    <v-card-text class="text--primary">
                        <div>{{ favourite.author.full_name }}</div>

                        <div>Количество просмотров: {{ favourite.views }}</div>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn
                            color="red"
                            text
                            @click="deleteFavourite(favourite)"
                        >
                            Убрать
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="4" class="mr-auto" v-show="favourites.length < 3">
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
                            <v-row class="ml-auto mt-auto mb-auto">
                                <v-icon v-bind="attrs" v-on="on" size="350px" color="#E3DDDC">mdi-plus</v-icon>
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
                                v-on:change="favouriteSelected"
                            ></v-select>
                        </v-card>
                    </v-dialog>
                </v-card>
            </v-col>
            <v-col cols="4" v-show="loading" v-for="i in 3" :key="i+'asd'">
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
    name: "FavouriteArticles",
    mounted() {
        this.getFavourites()
        this.getArticles()
        this.$store.commit('changeHeaderText', 'Избранные статьи')
    },
    data() {
        return {
            dialog: false,
            favourites: [],
            chosenArticle: null,
            articles: [],
            loading: true
        }
    },
    methods: {
        getArticles() {
            this.$http.get('/api/articles?filter[favourite]=0&itemsPerPage=10000000&include=author')
                .then(res => {
                    this.articles = res.data.data.data;
                })
        },
        getFavourites() {
            this.loading = true;
            this.$http.get('/api/articles?filter[favourite]=1&include=author')
                .then(res => {
                    this.loading = false;
                    this.favourites = res.data.data.data;
                })
        },
        favouriteSelected() {
            this.dialog = false;
            this.$http.post(`/api/articles/add-favourite/${this.chosenArticle.id}`)
                .then(res => {
                    this.$store.commit('triggerSnack', {text: 'Избранная статья добавлена', color: 'green'})
                    this.favourites.push(this.chosenArticle)
                    this.chosenArticle = null;
                    this.getArticles();
                })
                .catch(res => {
                    this.$store.commit('triggerSnack', {text: 'Ошибка', color: 'red'})
                    this.dialog = false;
                    this.chosenArticle = null;
                })
        },
        deleteFavourite(article) {
            this.$http.post(`/api/articles/delete-favourite/${article.id}`)
                .then(res => {
                    this.favourites.splice(this.favourites.indexOf(article), 1)
                    this.$store.commit('triggerSnack', {text: 'Статья удалена успешно', color: 'green'})
                    this.getArticles();
                })
                .catch(res => {
                    this.$store.commit('triggerSnack', {text: 'Ошибка', color: 'red'})
                })
        }
    }
}
</script>

<style scoped>

</style>
