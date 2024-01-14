<template>
    <li>
        <Link class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white
         group"
            :class="[$page.url.startsWith(`/admin/${active}`) ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700']"
            :href="href">
        <i :class="icon"></i><span class="ms-3">{{ name }}</span>
        </Link>
    </li>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    href: String,
    icon: String,
    name: String,
    active: {
        type: String,
        default: '*',
    }
})

</script>

<style lang="scss" scoped></style>
