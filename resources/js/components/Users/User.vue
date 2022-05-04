<template>
    <v-card flat max-width="700px" max-height="2000px" class="ml-auto mr-auto mt-5 mb-10">
        <v-row class="d-flex flex-column">
            <v-col>
                <v-text-field
                    v-model="user.name"
                    label="ФИО"
                    :rules="notEmptyRule"
                    counter="255"
                    clearable
                ></v-text-field>
            </v-col>
            <v-col>
                <v-text-field
                    v-model="user.password"
                    label="Новый пароль"
                    type="password"
                    clearable
                ></v-text-field>
            </v-col>
            <v-col>
                <v-text-field
                    v-model="user.passwordConfirm"
                    label="Подтверждение нового пароля"
                    type="password"
                    :rules="passwordConfirm"
                    clearable
                ></v-text-field>
            </v-col>
        </v-row>
        <v-btn class="primary" @click="saveUser" :loading="loading">
            Сохранить
        </v-btn>
        <v-btn
                color="red mr-3"
                @click="deleteUser"
        >
            Удалить
        </v-btn>
    </v-card>
</template>

<script>
export default {
    name: "User",
    mounted() {
        this.getUser()
    },
    data() {
        return {
            user: {},
            notEmptyRule: [
                v => !!v || 'Обязательное поле',
            ],
            passwordConfirm: [
                v => v === this.user.password || 'Пароли не совпадают'
            ],
            loading: false
        }
    },
    methods: {
        getUser() {
            this.$http.get(`/api/users/${this.$route.params.id}`)
                .then(res => {
                    this.user = res.data.data;
                    this.$store.commit('changeHeaderText', `Редактирование админа: ${this.user.name}`)
                })
                .catch(err => {
                    this.$store.commit('triggerSnack', 'Непредвиденна ошибка')
                    console.log(err)
                })
        },
        saveUser() {
            this.loading = true;

            this.$http.post(`/api/users/${this.user.id}`, {
                user: this.user
            }).then(res => {
                this.loading = false;
                this.$store.commit('triggerSnack', {color: 'green', text: 'Пользователь отредактирован'});
                this.$router.push('/admin/users')
            }).catch(err => {
                this.$store.commit('triggerSnack', {color: 'red', text: err.response.data.errors[Object.keys(err.response.data.errors)[0]][0]});
                this.loading = false;
            })
        },
        deleteUser() {
            this.overlay = true;

            this.$http.delete(`/api/users/${this.user.id}`)
                .then(res => {
                    this.$router.push('/admin/users')
                    this.$store.commit('triggerSnack', {text: 'Пользователь удален', color: 'green'})
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
