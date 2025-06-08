<template>
    <Link :href="`/articles/${article.slug}`"
          class="bg-white border rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between mb-4">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                {{ article.category }}
            </span>
        </div>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">
            {{ article.title }}
        </h2>
        <p class="text-sm text-gray-700">
            By {{ article.author }} - {{ article.created_at }}
        </p>
        <p v-if="article.similarity_score" class="text-xs text-gray-700 mt-2 italic">
            Similarity score: {{ article.similarity_score.toFixed(2) }}
        </p>
    </Link>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';
import {defineProps} from 'vue';

defineProps({
    article: {
        type: Object,
        required: true
    }
});
</script>
