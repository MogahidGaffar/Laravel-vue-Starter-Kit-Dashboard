<script setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
  show: { type: Boolean, default: false },
  user: { type: Object, default: null },
  translations: { type: Object, default: () => ({}) },
});

defineEmits(['close']);
</script>

<template>
  <Modal :show="show" max-width="md" @close="$emit('close')">
    <div class="p-6" v-if="user">
      <div class="flex items-center gap-4 mb-6">
        <img :src="user.avatar" alt="Avatar" class="w-16 h-16 rounded-full object-cover" />
        <div>
          <h2 class="text-lg font-semibold text-gray-900">{{ user.name }}</h2>
          <p class="text-sm text-gray-500">{{ user.email }}</p>
        </div>
      </div>

      <dl class="grid grid-cols-3 gap-y-3 text-sm">
        <dt class="text-gray-500">{{ translations.role }}</dt>
        <dd class="col-span-2 text-gray-900">
          <span v-for="role in user.roles" :key="role.id" class="badge bg-secondary me-1">{{ role.name }}</span>
          <span v-if="!user.roles || !user.roles.length">-</span>
        </dd>

        <dt class="text-gray-500">{{ translations.status }}</dt>
        <dd class="col-span-2 text-gray-900">
          {{ user.is_active == 1 ? translations.active : translations.not_active }}
        </dd>

        <dt class="text-gray-500">{{ translations.created_at }}</dt>
        <dd class="col-span-2 text-gray-900">{{ user.created_at }}</dd>
      </dl>
    </div>

    <div class="flex justify-end px-6 py-4 bg-gray-100">
      <SecondaryButton @click="$emit('close')">{{ translations.close }}</SecondaryButton>
    </div>
  </Modal>
</template>
