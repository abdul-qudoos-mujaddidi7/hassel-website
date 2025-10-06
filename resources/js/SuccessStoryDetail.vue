<template>
    <div class="min-h-screen">
        <section
            class="relative h-[420px] md:h-[560px] lg:h-[640px] bg-cover bg-center bg-no-repeat"
            :style="bgStyle"
        >
            <div
                class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/50 to-black/70"
            ></div>
            <div
                class="relative z-10 max-w-5xl mx-auto h-full flex items-end md:items-center px-4 sm:px-6 lg:px-8 py-10"
            >
                <div class="w-full">
                    <div
                        class="inline-flex items-center text-white/90 text-xs md:text-sm bg-white/10 backdrop-blur px-3 py-1 rounded-full mb-3"
                    >
                        <svg
                            class="w-4 h-4 mr-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                        {{ story?.published_date }}
                    </div>
                    <h1
                        class="text-4xl md:text-6xl font-extrabold text-white leading-tight"
                    >
                        {{ story?.title }}
                    </h1>
                    <div
                        v-if="story?.client_name"
                        class="mt-4 inline-flex items-center bg-white/15 backdrop-blur px-4 py-2 rounded-full"
                    >
                        <svg
                            class="w-5 h-5 text-white mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                        <span class="text-white font-medium">{{
                            story.client_name
                        }}</span>
                    </div>
                    <p
                        v-if="storyLead"
                        class="mt-6 text-white/90 max-w-3xl text-sm md:text-lg"
                    >
                        {{ storyLead }}
                    </p>
                </div>
            </div>
        </section>

        <section class="py-10 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <router-link
                    to="/resources#success-stories"
                    class="inline-flex items-center text-green-600 hover:text-green-700 mb-6"
                >
                    <svg
                        class="w-4 h-4 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                    Back to Success Stories
                </router-link>

                <div
                    class="prose max-w-none mb-10"
                    v-html="formattedStory"
                ></div>

                <!-- Meta details -->
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-gray-50 border border-gray-200 rounded-lg p-6"
                >
                    <div>
                        <div class="text-sm text-gray-500">Client</div>
                        <div class="text-gray-900 font-medium">
                            {{ story?.client_name || "—" }}
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Published</div>
                        <div class="text-gray-900 font-medium">
                            {{ story?.published_date || "—" }}
                        </div>
                    </div>
                </div>

                <!-- Related stories -->
                <section v-if="relatedStories.length" class="mt-12">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">
                        Related Stories
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <article
                            v-for="rs in relatedStories"
                            :key="rs.id"
                            class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md"
                        >
                            <img
                                :src="
                                    rs.image_url ||
                                    '/images/placeholder-news.jpg'
                                "
                                :alt="rs.title"
                                class="w-full h-32 object-cover"
                            />
                            <div class="p-4">
                                <div class="text-xs text-gray-500 mb-1">
                                    {{ rs.published_date }}
                                </div>
                                <h3
                                    class="text-sm font-semibold text-gray-900 line-clamp-2"
                                >
                                    {{ rs.title }}
                                </h3>
                                <router-link
                                    :to="{
                                        name: 'success-story-detail',
                                        params: { slug: rs.slug || rs.id },
                                    }"
                                    class="text-green-600 hover:text-green-700 text-sm mt-2 inline-block"
                                    >Read</router-link
                                >
                            </div>
                        </article>
                    </div>
                </section>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";

const route = useRoute();
const story = ref(null);
const relatedStories = ref([]);

const formattedStory = computed(() => {
    if (!story.value?.story) return "";
    return story.value.story;
});

// Use the first paragraph of the story as a lead/excerpt for the hero
const storyLead = computed(() => {
    if (!story.value?.story) return "";
    const temp = document.createElement("div");
    temp.innerHTML = story.value.story;
    const firstP = temp.querySelector("p");
    return firstP ? firstP.textContent?.trim() : "";
});

const bgStyle = computed(() => ({
    backgroundImage: `url(${
        story.value?.image_url || "/images/placeholder-news.jpg"
    })`,
}));

const fetchStory = async () => {
    const slug = route.params.slug;
    const res = await axios.get(`/api/success-stories/${slug}`);
    if (res.data?.story) {
        story.value = res.data.story;
        relatedStories.value = res.data.related_stories || [];
    } else {
        story.value = res.data?.data || res.data;
        relatedStories.value = [];
    }
    window.scrollTo({ top: 0, behavior: "smooth" });
};

onMounted(fetchStory);

// Refetch when language changes
const handleLanguageChanged = () => fetchStory();
window.addEventListener("language:changed", handleLanguageChanged);
onUnmounted(() => {
    window.removeEventListener("language:changed", handleLanguageChanged);
});
</script>

<style scoped>
.prose :where(img) {
    border-radius: 0.5rem;
}
</style>
