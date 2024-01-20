<template>
    <div class=" flex justify-between my-3 mx-3">
        <div><p>
        Showing {{ links.from }} to {{ links.to }} of {{ links.total }} entries
      </p></div>
        <nav aria-label="Pagination Table">
            <ul class="inline-flex -space-x-px text-base h-10">
                <li>
                    <Link  :href="links.links[0].url ?? ''"
                        class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Previous</Link>
                </li>
                <li v-for="(link, index) in links.links">
                    <Link class="flex items-center justify-center px-4 h-10 border border-gray-300" :href="link.url"
                        v-if="(index !== 0) && (index !== links.links.length - 1)" :class="{
                            'text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:bg-gray-700 dark:text-white': links.current_page === index,
                            'leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white': links.current_page !== index,
                        }">
                    {{ link.label }}
                    </Link>
                </li>
                <li>
                    <Link :href="links.links[links.links.length - 1].url ?? ''"
                        class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    Next</Link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: {
        type: Object,
        required: true,
    }
})

// onMounted(() => {
//     console.log(links);
// }),
</script>

<style lang="scss" scoped></style>
