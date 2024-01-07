<template>
    <div>

        <Head title="User Edit"></Head>
        <form @submit.prevent="updateUser()">
            <FromInput :name="$t('name')" v-model="formData.name" :error="formData.errors.name"/>
            <FromInput :name="$t('email')" v-model="formData.email" :error="formData.errors.email" />
            <div>
                <h5>{{ $t('roles') }}</h5>
                <ul class="list-group list-group-flush">
                    <li v-for="(role, index) in formData.roles" :key="index"
                        class="list-group-item d-flex justify-content-between align-items-start">
                        <div class=" text-capitalize ">
                            {{ role.name }}
                        </div>
                        <Switch v-model="role.status" :class="role.status ? 'bg-blue-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full">
                            <span :class="role.status ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                        </Switch>
                    </li>
                </ul>
            </div>
            <div class="mt-10">
                <div class="float-end ">
                    <button v-if="!submitting" class="btn btn-primary ">{{ $t('submit') }}</button>
                    <button v-if="submitting" class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        <span role="status">Loading...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    layout: BackendLayout
}
</script>

<script setup>
import BackendLayout from '@/Layouts/BackendLayout.vue';
import FromInput from '../Components/FormInput.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Switch } from '@headlessui/vue';
const page = usePage();
const submitting = ref(false);
const formData = useForm({
    id: page.props.editUser.id,
    name: page.props.editUser.name,
    email: page.props.editUser.email,
    roles: page.props.roles,
});
const updateUser = async () => {
    submitting.value = true;
    formData.put(route('admin.users.update', formData.id), {
        onFinish: () => {
            submitting.value = false;
        }
    })
}
</script>

<style lang="scss" scoped></style>
