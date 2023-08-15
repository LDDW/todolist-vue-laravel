<template>
    <UserLayout>
        <!-- modal delete user account -->
        <div>

        </div>
        <!-- content of page account -->
        <div class="max-w-3xl w-full flex flex-col gap-4">
            <h1 class="">Mon Compte</h1>
            <div class="bg-gray-50 shadow p-4 mb-5 rounded-md">
                <form @submit.prevent="updateUser" class="m-0">
                    <p>Modifier mes informations personnelles</p>
                    <label class="input_form">
                        <span>Nom</span>
                        <input 
                            type="text" 
                            v-model.trim="name"
                            placeholder="John doe"
                            required
                        >
                        <span v-if="errors.name" class="text-red-400 mt-2">{{ errors.name }}</span>
                    </label>
                    <label class="input_form">
                        <span>Email</span>
                        <input 
                            type="email" 
                            v-model.trim="email"
                            placeholder="john@example.com"
                            required
                        >
                        <span v-if="errors.email" class="text-red-400 mt-2">{{ errors.email }}</span>
                    </label>
                    <input 
                        type="submit"
                        value="Modifier mes informations personnelles"
                    >
                </form>
            </div>

            <div class="bg-gray-50 shadow p-4 mb-5 rounded-md">
                <form @submit.prevent="updatePassword" class="m-0">
                    <p>Modifier mon mot de passe</p>
                    <label class="input_form">
                        <span>Mot de passe actuel</span>
                        <input 
                            type="password" 
                            v-model.trim="old_password"
                            placeholder="Mot de passe actuel"
                            required
                        >
                        <span v-if="errors.old_password" class="text-red-400 mt-2">{{ errors.old_password }}</span>
                    </label>
                    <label class="input_form">
                        <span>Nouveau mot de passe</span>
                        <input 
                            type="password" 
                            v-model.trim="new_password"
                            placeholder="Nouveau mot de passe"
                            required
                        >
                        <span v-if="errors.new_password" class="text-red-400 mt-2">{{ errors.new_password }}</span>
                    </label>
                    <label class="input_form">
                        <span>Confirmez le nouveau mot de passe</span>
                        <input 
                            type="password" 
                            v-model.trim="confirm_new_password"
                            placeholder="Confirmez le nouveau mot de passe"
                            required
                        >
                        <span v-if="errors.confirm_new_password" class="text-red-400 mt-2">{{ errors.confirm_new_password }}</span>
                    </label>
                    <input 
                        type="submit" 
                        value="Modifier mon mot de passe"
                    >
                </form>
            </div>

            <div class="bg-gray-50 shadow p-4 mb-5 rounded-md">
                <form @submit.prevent="deleteUserAccount" class="m-0">
                    <p>Supprimer mon compte</p>
                    <input type="submit" value="Supprimer mon compte">
                </form>
            </div>
        </div>
    </UserLayout>
</template>

<script setup>
    import UserLayout from '../layouts/UserLayout.vue';
    import { ref, onMounted } from 'vue';
    import axios from 'axios';

    const name = ref('');
    const email = ref('');
    const old_password = ref('');
    const new_password = ref('');
    const confirm_new_password = ref('');
    
    const errors = ref({});
    const modal = ref(false);

    const fetchUser = async () => {
        try {
            const res = await axios.post('/user', {
                token: localStorage.getItem('token')
            })

        } catch (error) {
            console.log(error)
        }
    }

    const updateUser = async () => {

        if(name.value.trim() !== '') {
            errors.value.name = 'Le nom ne peut pas être vide';
            return ;
        }

        if(email.value.trim() !== '') {
            errors.value.email = 'L\'email ne peut pas être vide';
            return ;
        }
    }

    const updatePassword = async () => {

    }

    const deleteUserAccount = async () => {

    }

    onMounted(() => {
        fetchUser();
    })

</script>