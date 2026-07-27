<script setup>
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

defineProps({
    translations: Array,
});

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <p class="text-muted mb-3">{{ translations.Once_your_account_is_deleted }}</p>

    <button type="button" class="btn btn-danger" @click="confirmUserDeletion">{{ translations.delete_account }}</button>

    <Modal :show="confirmingUserDeletion" @close="closeModal">
        <div class="p-4">
            <h5 class="mb-2">{{ translations.are_your_sure }}</h5>

            <p class="text-muted">{{ translations.Once_your_account_is_deleted }}</p>

            <div class="mb-3">
                <label for="delete_password" class="form-label visually-hidden">{{ translations.password }}</label>
                <input id="delete_password" ref="passwordInput" type="password" class="form-control"
                    v-model="form.password" :placeholder="translations.password" @keyup.enter="deleteUser">
                <InputError :message="form.errors.password" class="mt-1" />
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" @click="closeModal">{{ translations.cancel }}</button>

                <button type="button" class="btn btn-danger" :disabled="form.processing" @click="deleteUser">
                    {{ translations.delete_account }}
                </button>
            </div>
        </div>
    </Modal>
</template>
