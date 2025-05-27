<template>
    <div class="min-h-screen bg-gray-100">
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Category and Back Button -->
                        <div class="flex items-center justify-between mb-6">
                            <Link href="/" class="text-blue-600 hover:text-blue-800">
                                ← Back to Articles
                            </Link>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ article.category }}
                            </span>
                        </div>

                        <!-- Article Header -->
                        <div class="mb-8">
                            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                                {{ article.title }}
                            </h1>
                            <p class="text-gray-600">
                                By {{ article.author }} • {{ formatDate(article.published_at) }}
                            </p>
                        </div>

                        <!-- Article Content -->
                        <div class="prose max-w-none text-xl italic">
                            {{ article.content }}
                        </div>

                        <!-- Keywords -->
                        <div class="mt-8">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Keywords:</h3>
                            <div class="flex flex-wrap gap-2">
                                <span v-for="keyword in article.keywords" :key="keyword"
                                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ keyword }}
                                </span>
                            </div>
                        </div>

                        <!-- Similar content -->
                        <div class="mt-12 pt-6 border-t border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Related articles:</h3>

                            <div v-for="similarContent in similar_content" :key="similarContent"
                                 class="my-4 p-4 text-md text-lg bg-gray-100 text-gray-800 relative">
                                <div>
                                    {{ similarContent.title }}
                                <div class="text-sm my-2">
                                    {{ similarContent.content }}
                                </div>
                                <div class="text-xs my-2">
                                    <strong>Category:</strong> {{ similarContent.category }}
                                </div>
                                <div class="text-xs">
                                    <strong>Keywords:</strong> {{ similarContent.keywords }}
                                </div>
                                <div class="absolute -top-3 -right-3">
                                        <span
                                            class=" inline-flex bg-amber-600 text-white items-center p-1 font-bold rounded-full aspect-square"
                                            :class="{
                                                'bg-red-600': similarContent.similarity_score < 0.5,
                                                'bg-orange-500': similarContent.similarity_score >= 0.5 && similarContent.similarity_score < 0.7,
                                                'bg-green-600': similarContent.similarity_score >= 0.7
                                            }">
                                            {{ similarContent.similarity_score.toFixed(2) }}
                                        </span>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    article: {
        type: Object,
        required: true
    },
    similar_content: {
        type: Array,
        required: true
    }
});

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}
</script>
