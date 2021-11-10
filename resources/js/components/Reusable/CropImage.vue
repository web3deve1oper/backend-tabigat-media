<template>
    <v-card class="mt-5 elevation-10" height="2000px">
        <v-row justify="center" class="d-flex flex-column" align-content="center">
            <input
                class="mt-5"
                type="file"
                name="image"
                accept="image/*"
                placeholder="Выберите обложку"
                @change="setImage"
            />
            <v-dialog
                persistent
                v-model="dialog"
                :max-width="dialogMaxWidth"
                hide-overlay
                :disabled="!imgSrc"
            >
                <template v-slot:activator="{ on, attrs }">
                    <img
                        class="ml-auto mr-auto mt-10"
                        v-show="cropSrc"
                        v-bind="attrs"
                        v-on="on"
                        :src="cropSrc"
                        style="border: 1px solid gray"
                        alt="Cropped Image"
                    />
                    <v-banner v-show="cropSrc" single-line>
                        Нажмите на картинку если хотите отредактировать ее
                    </v-banner>
                    <v-banner v-show="!cropSrc" single-line>
                        Выберите картинку, нажав на кнопку выше
                    </v-banner>
                </template>
                <v-card>
                    <v-card-title><span class="headline">Отредактируйте картинку</span></v-card-title>
                    <v-card-text>
                        <vue-cropper
                            ref="cropper"
                            :minCropBoxWidth="minCropBoxWidth"
                            :minCropBoxHeight="minCropBoxHeight"
                            :aspectRatio="aspectRatio"
                            :initialAspectRation="aspectRatio"
                            :background="true"
                            :src="imgSrc"
                            :modal="true"
                            :center="false"
                            :highlight="true"
                        />
                    </v-card-text>
                    <v-card-actions>
                        <!-- <v-tooltip> -->
                        <v-btn color="blue" @click="cropImage">Сохранить</v-btn>
                        <v-spacer></v-spacer>

                        <v-btn color="blue darken-1" @click="dialog = false;" text
                        >Отмена
                        </v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </v-card>
</template>

<script>
import VueCropper from "vue-cropperjs";
// import axios from '@/axios.js'

export default {
    props: {
        value: {},
        pk: {default: "image_key"},
        dialogMaxWidth: {default: "1200px"},
        maxWidth: {default: 1200},
        maxHeight: {default: 400},
        // the URL of the blob image
        objectUrl: {default: ""},
        minCropBoxWidth: {default: 600},
        minCropBoxHeight: {default: 200},
        aspectRatio: {default: 3}
    },
    components: {
        VueCropper
    },
    data() {
        return {
            imgSrc: "",
            cropImg: null,
            dialog: false,
            file: null,
            filename: null,
            croppedBlob: null
        };
    },
    mounted() {
        this.imgSrc = this.value;
    },
    computed: {
        croppedFile() {
            return new File([this.cropImg], this.file.name, {type: this.file.type});
        },
        cropSrc() {
            return this.cropImg || this.value;
        }
    },
    methods: {
        setImage(e) {
            // const file = e;
            const file = e.target.files[0];

            this.file = file;
            this.filename = file.name;

            if (!file.type.includes("image/")) {
                alert("Please select an image file");
                return;
            }

            if (typeof FileReader === "function") {
                const reader = new FileReader();

                reader.onload = event => {
                    this.imgSrc = event.target.result;
                    // rebuild cropperjs with the updated source
                    this.$refs.cropper.replace(event.target.result);
                    this.$emit("update:dataUrl", this.imgSrc);
                };

                reader.readAsDataURL(file);
                this.dialog = true;
            } else {
                alert("Sorry, FileReader API not supported");
            }
        },
        cropImage() {
            // get image data for post processing, e.g. upload or setting image src
            this.cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL()
            this.$refs.cropper
                .getCroppedCanvas({
                    maxWidth: this.maxWidth,
                    maxHeight: this.maxHeight
                })
                .toBlob(
                    blob => {
                        this.cropImg = URL.createObjectURL(blob);
                        this.croppedBlob = blob;
                        this.$emit("update:objectUrl", this.cropImg);
                    },
                    "image/jpeg",
                    0.95
                );
            this.dialog = false;
        },
    }
};
</script>

<style lang="scss" scoped>
</style>
