<template>
  <div v-if="filters.length" class="d-flex flex-wrap gap-2 mt-2 mb-3">
    <span
      v-for="filter in filters"
      :key="filter.key"
      class="badge bg-primary d-inline-flex align-items-center"
    >
      {{ filter.label }} : {{ filter.value }}
      <button
        type="button"
        class="btn-close btn-close-white ms-2"
        style="font-size: 1.2rem;"
        @click="filter.onRemove"
      ></button>
    </span>
  </div>
</template>

<script setup>
defineProps({
  filters: { type: Array, default: () => [] },
})
</script>
