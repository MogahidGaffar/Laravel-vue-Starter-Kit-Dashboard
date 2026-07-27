<template>
  <div class="country-autocomplete position-relative">
    <div v-if="selected" class="d-inline-flex align-items-center badge bg-primary fs-6 py-2 px-3">
      <span class="me-2">{{ selected.cname }}</span>
      <button type="button" class="btn-close btn-close-white" style="font-size: 0.6rem;" @click="clear"></button>
    </div>

    <input
      v-else
      type="text"
      class="form-control"
      v-model="query"
      :placeholder="placeholder"
      autocomplete="off"
      @focus="open = true"
      @input="open = true"
      @blur="onBlur"
    />

    <ul
      v-if="open && !selected && filtered.length"
      class="list-group position-absolute w-100 shadow"
      style="z-index: 1000; max-height: 220px; overflow-y: auto;"
    >
      <li
        v-for="country in filtered"
        :key="country.data_val"
        class="list-group-item list-group-item-action"
        @mousedown.prevent="select(country)"
      >
        {{ country.cname }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { loadCountries } from '@/utils/countries'

const props = defineProps({
  modelValue: { type: [Number, String], default: null },
  placeholder: { type: String, default: 'Type a country...' },
})
const emit = defineEmits(['update:modelValue'])

const countries = ref([])
const query = ref('')
const open = ref(false)

onMounted(async () => {
  countries.value = await loadCountries()
})

const selected = computed(() => countries.value.find(c => Number(c.data_val) === Number(props.modelValue)) || null)

const filtered = computed(() => {
  const q = query.value.trim().toLowerCase()
  if (!q) return []
  return countries.value.filter(c => c.cname.toLowerCase().includes(q)).slice(0, 8)
})

const select = (country) => {
  emit('update:modelValue', Number(country.data_val))
  query.value = ''
  open.value = false
}

const clear = () => {
  emit('update:modelValue', null)
  query.value = ''
}

const onBlur = () => {
  setTimeout(() => { open.value = false }, 150)
}
</script>
