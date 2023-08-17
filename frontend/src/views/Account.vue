<template>
    <UserLayout>
        <!-- modal delete user account -->
        <div
            v-if="modal"
            class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center z-50"
        >
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-md shadow max-w-lg w-full p-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl">Déconnexion</h2>
                    <button
                        @click="modal = false"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p class="my-5">Êtes vous sur de vouloir supprimer votre compte ?</p>
                <button 
                    @click="deleteUserAccount"
                    class="bg-blue text-white rounded-md px-3 py-2 mt-1 text-sm outline-none cursor-pointer disabled:bg-slate-300 transition-all"
                >
                    Je supprime mon compte
                </button>
            </div>
        </div>

        <!-- content of page account -->
        <div class="max-w-3xl w-full flex flex-col gap-4">
            <h1 class="text-3xl font-medium">Mon Compte</h1>
            <div class="bg-gray-50 shadow p-4 mb-5 rounded-md">
                <form @submit.prevent="updateUser" class="m-0">
                    <p class="mb-5 text-xl">Modifier mes informations personnelles</p>
                    <p v-if="errors.userMessage" class="text-red-900 bg-red-300 p-2 mb-5 rounded-md text-sm">{{ errors.userMessage }}</p>
                    <p v-if="success.updateUser" class="text-green-900 bg-green-300 p-2 mb-5 rounded-md text-sm">Modifications enregistrées</p>
                    <label class="input_form w-3/4">
                        <span>Nom</span>
                        <input 
                            type="text" 
                            v-model.trim="name"
                            placeholder="John doe"
                            required
                        >
                        <span v-if="errors.name" class="text-red-400 mt-2">{{ errors.name }}</span>
                    </label>
                    <label class="input_form w-3/4">
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
                    <p class="mb-5 text-xl">Modifier mon mot de passe</p>
                    <p v-if="errors.passwordMessage" class="text-red-900 bg-red-300 p-2 mb-5 rounded-md text-sm">{{ errors.passwordMessage }}</p>
                    <p v-if="success.updatePassword" class="text-green-900 bg-green-300 p-2 mb-5 rounded-md text-sm">Modifications enregistrées</p>
                    <label class="input_form w-3/4">
                        <span>Mot de passe actuel</span>
                        <input 
                            type="password" 
                            v-model.trim="old_password"
                            placeholder="Mot de passe actuel"
                            required
                        >
                        <span v-if="errors.old_password" class="text-red-400 mt-2">{{ errors.old_password }}</span>
                    </label>
                    <label class="input_form w-3/4">
                        <span>Nouveau mot de passe</span>
                        <input 
                            type="password" 
                            v-model.trim="new_password"
                            placeholder="Nouveau mot de passe"
                            required
                        >
                        <span v-if="errors.new_password" class="text-red-400 mt-2">{{ errors.new_password }}</span>
                    </label>
                    <label class="input_form w-3/4">
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
                <p class="mb-5 text-xl">Supprimer mon compte</p>
                <button 
                    @click="modal = true"
                    class="bg-blue text-white rounded-md px-3 py-2 mt-1 text-sm outline-none cursor-pointer disabled:bg-slate-300 transition-all"
                >
                    Supprimer mon compte
                </button>
            </div>
        </div>
    </UserLayout>
</template>

<script setup>
    import UserLayout from '../layouts/UserLayout.vue';
    import { ref, onMounted } from 'vue';
    import axios from 'axios';
    import { useRouter } from 'vue-router';

    const router = useRouter();

    const name = ref('');
    const email = ref('');
    const old_password = ref('');
    const new_password = ref('');
    const confirm_new_password = ref('');
    
    const errors = ref({});
    const success = ref({});
    const modal = ref(false);

    const fetchUser = async () => {
        try {
            let res = await axios.get('/user')

            name.value = res.data.name;
            email.value = res.data.email;

        } catch (error) {
            console.log(error)
        }
    }

    const updateUser = async () => {

        errors.value = {};
        success.value = {};

        if(name.value.trim() === '') {
            errors.value.name = 'Le nom ne peut pas être vide';
            return ;
        }

        if(email.value.trim() === '') {
            errors.value.email = 'L\'email ne peut pas être vide';
            return ;
        }

        try {
            await axios.put('/user/account', {
                name: name.value,
                email: email.value
            })

            success.value.updateUser = true;
        } catch (error) {
            if(error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value[key.toLowerCase()] = error.response.data.errors[key][0]
                }
            } else if (error.response.status === 500) {
                errors.value.userMessage = error.response.data.message
            } else {
                errors.value.userMessage = 'Une erreur est survenue, veuillez réessayer plus tard'
            }
        }
    }

    const updatePassword = async () => {

        errors.value = {};
        success.value = {};

        if(old_password.value.trim() === '') {
            errors.value.old_password = 'Le mot de passe actuel ne peut pas être vide';
            return ;
        }

        if(new_password.value.trim() === '') {
            errors.value.new_password = 'Le nouveau mot de passe ne peut pas être vide';
            return ;
        }

        if(new_password.value.trim().length < 8) {
            errors.value.new_password = 'Le nouveau mot de passe doit contenir au moins 8 caractères';
            return ;
        }

        if(confirm_new_password.value.trim() === '') {
            errors.value.confirm_new_password = 'La confirmation du nouveau mot de passe ne peut pas être vide';
            return ;
        }

        try {
            let res = await axios.put('/user/password', {
                old_password: old_password.value,
                new_password: new_password.value,
                confirm_new_password: confirm_new_password.value
            })

            success.value.updatePassword = true;
        } catch (error) {
            if(error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value[key.toLowerCase()] = error.response.data.errors[key][0]
                }
            } else if (error.response.status === 500) {
                errors.value.passwordMessage = error.response.data.message
            } else {
                errors.value.passwordMessage = 'Une erreur est survenue, veuillez réessayer plus tard'
            }
        }

    }

    const deleteUserAccount = async () => {
        try {
            await axios.delete('/user')
            localStorage.removeItem('token')
            router.push('/login')
        } catch (error) {
            console.log(error)
        }
    }

    onMounted(() => {
        fetchUser();
    })

</script>