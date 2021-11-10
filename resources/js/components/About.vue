<template>
<div>
    Tabigat Media
</div>
</template>

<script>
export default {
    name: "About",
    mounted() {
        this.$store.commit('changeHeaderText', 'Главная')
    }
}
</script>

<style scoped>

</style>
