<template>
    <div class="lang-switcher">
        <v-menu>
            <template v-slot:activator="{ props }">
                <v-btn
                    v-bind="props"
                    icon="mdi-translate"
                    variant="text"
                    color="white"
                >
                </v-btn>
            </template>
            <v-list>
                <v-list-item
                    v-for="lang in languages"
                    :key="lang.lang"
                    @click="changeLanguage(lang.lang)"
                >
                    <v-list-item-title>{{ lang.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const languages = [
    { title: "English", lang: "en" },
    { title: "دری", lang: "fa" },
    { title: "پښتو", lang: "pa" },
];

const changeLanguage = (lang) => {
    console.log("Language changed to:", lang);
    // Add your language switching logic here
};
</script>

<style scoped>
.lang-switcher {
    position: relative;
}
</style>
