<script setup>
import Modal from '@/Components/Modal.vue';

const props = defineProps({
  show: { type: Boolean, default: false },
  user: { type: Object, default: null },
  translations: { type: Object, default: () => ({}) },
});

defineEmits(['close']);
</script>

<template>
  <Modal :show="show" max-width="xl" @close="$emit('close')">
    <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200">
      <h3 class="text-xl font-semibold text-gray-900">View User</h3>
      <button type="button" class="text-gray-400 hover:text-gray-600" :aria-label="translations.close" @click="$emit('close')">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <div class="p-8" v-if="user">
      <div class="flex items-center gap-4 mb-8">
        <img :src="user.avatar" alt="Avatar" class="w-20 h-20 rounded-full object-cover" />
        <div>
          <h2 class="text-2xl font-semibold text-gray-900">{{ user.name }}</h2>
          <p class="text-base text-gray-500">{{ user.email }}</p>
        </div>
      </div>

      <dl class="grid grid-cols-3 gap-y-4 text-base">
        <dt class="text-gray-500">{{ translations.role }}</dt>
        <dd class="col-span-2 text-gray-900">
          <span v-for="role in user.roles" :key="role.id" class="badge bg-secondary me-1">{{ role.name }}</span>
          <span v-if="!user.roles || !user.roles.length">-</span>
        </dd>

        <dt class="text-gray-500">{{ translations.country }}</dt>
        <dd class="col-span-2 text-gray-900">{{ user.country_name ?? '-' }}</dd>

        <dt class="text-gray-500">{{ translations.status }}</dt>
        <dd class="col-span-2 text-gray-900">
          {{ user.is_active == 1 ? translations.active : translations.not_active }}
        </dd>

        <dt class="text-gray-500">{{ translations.created_at }}</dt>
        <dd class="col-span-2 text-gray-900">{{ user.created_at }}</dd>
      </dl>
    </div>
  </Modal>
</template>
