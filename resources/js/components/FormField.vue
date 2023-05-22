<template>
    <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText" :full-width-content="fullWidthContent">
        <template #field>
            <editor
                :id="field.attribute"
                :api-key="field.options.apiKey"
                v-model="value"
                :init="field.options.init"
                :plugins="field.options.plugins"
                :toolbar="field.options.toolbar"
            />
        </template>
    </DefaultField>
</template>

<script>
import {FormField, HandlesValidationErrors} from "laravel-nova";
import Editor from "@tinymce/tinymce-vue";
import axios from "axios";

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ["resourceName", "resourceId", "field", "options"],

    components: {
        editor: Editor,
    },

    created() {
        if (this.field.autoDeleteImage === true) {
            this.field.options.init.setup = this.setup;
        }

        this.field.options.init['images_upload_handler'] = this.imageUploader;
    },

    methods: {
        imageUploader: function (blobInfo, progress) {
            return new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                formData.append('field', this.field.attribute);

                Nova.request().post(`/nova-vendor/editor/${this.resourceName}/image-manager`, formData)
                    .then(function (response) {
                        resolve(response.data.location)
                    })
                    .catch(function (error) {
                        reject(error)
                        console.log(error);
                    });
            });
        },
        setup: function (editor) {
            let resource = this.resourceName;
            let field = this.field.attribute;
            editor.on("keydown", function (e) {
                if ((e.keyCode === 8 || e.keyCode === 46) && tinymce.activeEditor.selection) {
                    const selectedNode = tinymce.activeEditor.selection.getNode();
                    if (selectedNode && selectedNode.nodeName === 'IMG' || selectedNode && selectedNode.nodeName === 'FIGURE') {
                        const imageSrc = selectedNode.src ?? selectedNode.firstChild.src;
                        Nova.request().delete(`/nova-vendor/editor/${resource}/image-manager`, {
                            data: {
                                url: imageSrc,
                                field: field
                            }
                        })
                    }
                }
            });
        },

        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || "";
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || "");
        },
    },
};
</script>
