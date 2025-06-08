<template>
    <div class="min-h-screen bg-gray-100">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <input type="text" v-model="searchQuery" placeholder="Search..."
                               class="border rounded p-2 mb-4 w-full" @keyup.enter="search"/>
                        <div v-if="hasSearchQuery" class="mb-4">
                            <a href="/" class="text-blue-500 hover:underline">Back to Articles</a>
                        </div>
                    </div>
                    <div class="p-6 text-gray-900">
                        <div v-if="searchResults.length > 0">
                            <h1 class="text-4xl font-bold text-center mb-8">Search Results for "{{ searchQueryFromUrl }}"</h1>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <ArticleCard v-for="article in searchResults" :key="article.id" :article="article"/>
                            </div>
                        </div>
                        <div v-else>
                            <h1 class="text-4xl font-bold text-center mb-8">Latest News</h1>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <ArticleCard v-for="article in articles" :key="article.id" :article="article"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, computed} from 'vue';
import ArticleCard from '../../Components/ArticleCard.vue';

const searchQuery = ref('');

const hasSearchQuery = computed(() => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.has('q');
});

const searchQueryFromUrl = computed(() => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('q') || '';
});

function search() {
    if (searchQuery.value) {
        window.location.href = `?q=${searchQuery.value}`;
    }
}

defineProps({
    articles: {
        type: Array,
        required: true
    },
    searchResults: {
        type: Array,
        required: false
    }
});
</script>
