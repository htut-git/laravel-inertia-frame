<template>
    <form @submit.prevent="submitForm()">
        <FromInput v-model="roleForm.name" :name="$t('name')"></FromInput>
        <div>
            <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $t('permissions') }}</h2>
            <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                <li class="flex items-center" v-for="(permission, index) in roleForm.permissions" :key="index">
                    <Switch v-model="permission.status" :class="permission.status ? 'bg-blue-600' : 'bg-gray-200'"
                        class="relative inline-flex h-6 w-11 items-center rounded-full">
                        <span :class="permission.status ? 'translate-x-6' : 'translate-x-1'"
                            class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                    </Switch>
                    <span class="ms-3 capitalize ">{{ permission.name }}</span>
                </li>
            </ul>
            <div class="mt-10">
                <SubmitBtn :submitting="submitting"/>
            </div>
        </div>
    </form>
</template>

<script setup>
import FromInput from '../Components/FormInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { Switch } from '@headlessui/vue';
import { ref } from 'vue';
import SubmitBtn from '../Components/SubmitBtn.vue';
const page = usePage();
const submitting = ref(false);

const props = defineProps({
    type: {
        type: String,
        validator: (value) => {
            return ['create', 'edit'].includes(value);
        },
        required: true,
    }
})

const roleForm = useForm({
    id: page.props.role?.id,
    name: page.props.role?.name,
    permissions: page.props.permissions
});

const submitForm = () => {
    submitting.value = true;
    if (props.type == 'edit') {
        roleForm.put(route('admin.roles.update', roleForm.id), {
            onFinish: () => {
                submitting.value = false;
            }
        })
    } else if (props.type == 'create') {
        roleForm.post(route('admin.roles.store'), {
            onFinish: () => {
                submitting.value = false;
            }
        })
    }
}
</script>

<style lang="scss" scoped></style>
