<template>
    <div  style="display: flex; justify-content: center;">
    <nav>
        <ul class="pagination">
            <li class="page-item" v-for="(link, index) in links">
                <Link :key="index" class="page-link" :href="link.url" :class="{ 'active': link.active }"
                    v-html="link.label" />
            </li>

        </ul>
    </nav>
</div>
</template>
<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({ links: Array })
</script>