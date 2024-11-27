<template>
    <v-text-field
        :value="value"
        :disabled="disabled"
        :rules="rules"
        :label="label"
        :suffix="suffix"
        :type="type"
        dense
        outlined
        @input="(text) => $emit('input', text)"
    >
    </v-text-field>
</template>

<script>
import { VTextField } from "vuetify/lib";
export default {
    extends: VTextField,

    props: {
        rules: {
            type: Array,
            default: () => [],
        },
        "append-icon": {},
        disabled: {
            type: Boolean,
            default: false,
        },
        outlined: {
            type: Boolean,
            default: true,
        },
        label: {
            type: String,
            default: null,
        },
        value: {
            type: String,
        },
        suffix: {
            type: String,
            default: "",
        },
        type: {
            type: String,
            default: "",
        },
    },

    created() {},
};
</script>

<style></style>
