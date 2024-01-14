<template>
    <BackendLayout>
        <Head title="User Edit"></Head>

        <template #breadcrumbs>
            <Breadcrumbs :home="{ name: $t('users'), href: route('admin.users.index') }" />
        </template>

        <div class="border-b border-gray-200 dark:border-gray-700 mb-4 ">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                <li @click="selectTag = index + 1" class="me-2" v-for="(tag, index) in tags">
                    <a href="#"
                        :class="[(index + 1) == selectTag ? 'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group'
                            : 'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group']">
                        <i :class="tag.icon"></i> <span class="ms-2">{{ tag.title }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Profile And Roles  -->
        <section v-if="selectTag == 1">
            <form @submit.prevent="updateUser()">
                <FromInput :name="$t('name')" v-model="editUserForm.name" :error="editUserForm.errors.name" />
                <FromInput :name="$t('email')" v-model="editUserForm.email" :error="editUserForm.errors.email" />

                <div>
                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $t('roles') }}</h2>
                    <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                        <li class="flex items-center" v-for="(role, index) in editUserForm.roles" :key="index">
                            <Switch v-model="role.status" :class="role.status ? 'bg-blue-600' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 items-center rounded-full">
                                <span :class="role.status ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition" />
                            </Switch>
                            <span class="ms-3 capitalize ">{{ role.name }}</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-10">
                    <SubmitBtn :submitting="submitting" />
                </div>
            </form>
        </section>
        <!-- Security  -->
        <section v-if="selectTag == 2">
            <div class="row">
                <form @submit.prevent="updatePassword">
                    <FromInput :name="$t('new password')" v-model="changePasswordForm.newPassword"
                        :error="changePasswordForm.errors?.newPassword" />
                    <SubmitBtn :text="$t('change password')" :submitting="submitting" />
                </form>
            </div>

            <div v-if="$page.props.sessions.length > 0" class="mt-26 space-y-6">
                <hr>
                <h5 class="text-xl"> Browser Sessions</h5>
                <div v-for="(session, i) in $page.props.sessions" :key="i" class="flex items-center">
                    <div>
                        <svg v-if="session.agent.is_desktop" class="w-8 h-8 text-gray-500"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                        </svg>

                        <svg v-else class="w-8 h-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                        </svg>
                    </div>

                    <div class="ms-3">
                        <div class="text-sm text-gray-600">
                            {{ session.agent.platform ? session.agent.platform : 'Unknown' }} - {{ session.agent.browser ?
                                session.agent.browser : 'Unknown' }}
                        </div>

                        <div>
                            <div class="text-xs text-gray-500">
                                {{ session.ip_address }},

                                <span v-if="session.is_current_device" class="text-green-500 font-semibold">This
                                    device</span>
                                <span v-else>Last active {{ session.last_active }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <SubmitBtn :submitting="false" @click="clearAllSession"
                    text='<i class="fa-brands fa-space-awesome"></i> Clear All Sessions' />
            </div>
        </section>
    </BackendLayout>
</template>


<script setup>
import BackendLayout from '@/Layouts/BackendLayout.vue';
import FromInput from '../Components/FormInput.vue';
import SubmitBtn from '../Components/SubmitBtn.vue';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Switch } from '@headlessui/vue';
import Breadcrumbs from '../Components/Breadcrumbs.vue';
const page = usePage();

const tags = [{
    title: 'Profile & Roles',
    icon: 'fa-solid fa-user',
}, {
    title: 'Security',
    icon: 'fa-solid fa-lock',
}];

const submitting = ref(false);
const selectTag = ref(1);


const editUserForm = useForm({
    id: page.props.editUser.id,
    name: page.props.editUser.name,
    email: page.props.editUser.email,
    roles: page.props.roles,
});

const changePasswordForm = useForm({
    newPassword: ''
})

const updateUser = () => {
    submitting.value = true;
    editUserForm.put(route('admin.users.update', editUserForm.id), {
        onFinish: () => {
            submitting.value = false;
        }
    })
}

const updatePassword = () => {
    submitting.value = true;
    changePasswordForm.post(route('admin.users.updatePassword', editUserForm.id), {
        onFinish: () => {
            submitting.value = false;
        }
    })
}

const clearAllSession = (event) => {
    router.post(route('admin.users.destroySession', editUserForm.id));
}
</script>

<style lang="scss" scoped></style>
