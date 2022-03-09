<template>
    <div>
        <v-row justify="center" class="d-flex flex-column" align-content="center">
            <v-file-input
                class="mt-5"
                type="file"
                name="image"
                accept="image/*"
                :placeholder="label"
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
                        
                        style="border: 1px solid gray; max-width:600px"
                        alt="Cropped Image"
                    />
                    <v-banner v-show="cropSrc" single-line>
                        Нажмите на картинку если хотите отредактировать ее
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
                            :background="true"
                            :minCanvasWidth="1200"
                            :minCanvasHeight="400"
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
    </div>
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
        minCropBoxWidth: {default: 1200},
        minCropBoxHeight: {default: 400},
        aspectRatio: {default: 3},
        rules: Array,
        label: {
            default: 'Выберите картинку'
        }
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
            const file = e;

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
            console.log(this.cropImg)
            this.$refs.cropper
                .getCroppedCanvas({
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                })
                .toBlob(
                    blob => {
                        this.cropImg = URL.createObjectURL(blob);
                        this.croppedBlob = blob;
                        this.$emit("update:objectUrl", this.cropImg);

                        console.log(this.cropImg)
                    },
                    "image/jpeg",
                    1
                );
            this.dialog = false;
        },
    }
};
</script>

<style lang="scss" scoped>
</style>
