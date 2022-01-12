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
                    v-model="user.email"
                    label="Email"
                    type="email"
                    :rules="notEmptyRule"
                    clearable
                ></v-text-field>
            </v-col>
            <v-col>
                <v-text-field
                    v-model="user.password"
                    label="Пароль"
                    type="password"
                    clearable
                ></v-text-field>
            </v-col>
            <v-col>
                <v-text-field
                    v-model="user.passwordConfirm"
                    label="Подтверждение пароля"
                    type="password"
                    :rules="passwordConfirm"
                    clearable
                ></v-text-field>
            </v-col>
        </v-row>
        <v-btn class="primary" @click="saveUser" :loading="loading">
            Сохранить
        </v-btn>
    </v-card>
</template>

<script>
export default {
    name: "CreateUser",
    mounted() {
        this.$store.commit('changeHeaderText', 'Создание админа')
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
        saveUser() {
            this.loading = true;

            this.$http.post('/api/users', {
                user: this.user
            }).then(res => {
                this.loading = false;
                this.$store.commit('triggerSnack', {color: 'green', text: 'Пользователь создан'});
                this.$router.push('/admin/users')
            }).catch(err => {
                this.$store.commit('triggerSnack', {color: 'red', text: err.response.data.errors[Object.keys(err.response.data.errors)[0]][0]});
                this.loading = false;
            })
        }
    }
}
</script>

<style scoped>

</style>
