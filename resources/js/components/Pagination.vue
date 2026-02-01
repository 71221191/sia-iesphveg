<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: Array
});
</script>

<template>
    <div v-if="links.length > 3" class="flex flex-wrap justify-center mt-8 gap-1">
        <template v-for="(link, key) in links" :key="key">
            <div v-if="link.url === null"
                 class="px-4 py-2 text-sm text-gray-400 bg-white border rounded-lg cursor-not-allowed"
                 v-html="link.label" />

            <Link v-else
                  :href="link.url"
                  class="px-4 py-2 text-sm border rounded-lg transition-all hover:bg-indigo-50"
                  :class="{ 'bg-indigo-600 text-white font-bold border-indigo-600 hover:bg-indigo-700': link.active, 'bg-white text-gray-700': !link.active }"
                  v-html="link.label"
                  preserve-scroll />
        </template>
    </div>
</template>
