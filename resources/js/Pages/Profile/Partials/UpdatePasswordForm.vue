<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

defineProps({
    translations: Array,
});

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <form @submit.prevent="updatePassword" class="row g-3">
        <div class="col-md-4">
            <label for="current_password" class="form-label">{{ translations.current_password }}</label>
            <input id="current_password" ref="currentPasswordInput" type="password" class="form-control"
                v-model="form.current_password" autocomplete="current-password">
            <InputError :message="form.errors.current_password" class="mt-1" />
        </div>

        <div class="col-md-4">
            <label for="password" class="form-label">{{ translations.new_password }}</label>
            <input id="password" ref="passwordInput" type="password" class="form-control" v-model="form.password"
                autocomplete="new-password">
            <InputError :message="form.errors.password" class="mt-1" />
        </div>

        <div class="col-md-4">
            <label for="password_confirmation" class="form-label">{{ translations.confirm_password }}</label>
            <input id="password_confirmation" type="password" class="form-control"
                v-model="form.password_confirmation" autocomplete="new-password">
            <InputError :message="form.errors.password_confirmation" class="mt-1" />
        </div>

        <div class="col-12 d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary" :disabled="form.processing">{{ translations.save }}</button>

            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                <span v-if="form.recentlySuccessful" class="text-success small">{{ translations.data_updated_successfully }}</span>
            </Transition>
        </div>
    </form>
</template>
