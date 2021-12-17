<template>
<!--    <ckeditor v-model="editorData" :config="editorConfig" @namespaceloaded="onNamespaceLoaded"></ckeditor>-->
    <textarea name="editor111"></textarea>
</template>

<script>
export default {
    name: "Editor",
    props: {
        content: '',
    },
    mounted() {
        CKEDITOR.config.language = 'ru'
        CKEDITOR.config.height = '500px'
        CKEDITOR.config.extraPlugins = 'uploadimage'
        CKEDITOR.config.imageUploadUrl = '/api/articles/upload-temp-image'
        CKEDITOR.replace( 'editor111' );
        CKEDITOR.instances.editor111.setData(this.content)
    }
}
</script>

<style scoped>

</style>
