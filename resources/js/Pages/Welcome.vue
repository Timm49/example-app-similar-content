<template>
    <div class="min-h-screen bg-gray-100">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <input type="text" v-model="searchQuery" placeholder="Search..." class="border rounded p-2 mb-4 w-full" @keyup.enter="search" />
                    </div>
                    <div v-if="searchResults.length > 0">
                        <h1 class="text-4xl font-bold text-center mb-8">Search Results</h1>
                        <pre>{{ searchResults }}</pre>
                    </div>
                    <div class="p-6 text-gray-900">
                        <h1 class="text-4xl font-bold text-center mb-8">Latest News</h1>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <Link v-for="article in articles" :key="article.id"
                                :href="`/articles/${article.slug}`"
                                class="bg-white border rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ article.category }}
                                    </span>
                                </div>
                                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                    {{ article.title }}
                                </h2>
                                <p class="text-sm text-gray-500">
                                    By {{ article.author }} - {{ article.created_at }}
                                </p>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';
import { ref } from 'vue';

const searchQuery = ref('');

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
