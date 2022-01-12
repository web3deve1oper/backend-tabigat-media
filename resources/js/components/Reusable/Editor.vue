<template>
<!--    <ckeditor v-model="editorData" :config="editorConfig" @namespaceloaded="onNamespaceLoaded"></ckeditor>-->
    <textarea :name="uniqueId"></textarea>
</template>

<script>
export default {
    name: "Editor",
    props: {
        content: '',
        uniqueId: {
            default: 'editor111'
        }
    },
    mounted() {
        CKEDITOR.config.language = 'ru'
        CKEDITOR.config.height = '500px'
        CKEDITOR.config.extraPlugins = 'uploadimage'
        CKEDITOR.config.imageUploadUrl = '/api/articles/upload-temp-image'
        CKEDITOR.replace( this.uniqueId );
        CKEDITOR.instances[this.uniqueId].setData(this.content)
    }
}
</script>

<style scoped>

</style>
