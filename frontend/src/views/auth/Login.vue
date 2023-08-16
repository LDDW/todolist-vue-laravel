<template>
    <AuthLayout>
        <section class="h-screen max-w-md w-full flex flex-col justify-center items-center">
            <h1 class="text-2xl">Connexion</h1>
            <form @submit.prevent="login" class="w-full">
                <p v-if="errors.message" class="text-red-900 bg-red-300 p-2 mb-5 rounded-md text-sm">{{ errors.message }}</p>
                <!-- email -->
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
                <!-- password -->
                <label class="input_form">
                    <span>Mot de passe</span>
                    <input 
                        type="password" 
                        v-model.trim="password"
                        placeholder="Mot de passe"
                        required
                    >
                    <span v-if="errors.password" class="text-red-400 mt-2">{{ errors.password }}</span>
                </label>

                <input 
                    type="submit" 
                    value="Se connecter"
                    :disabled="btnDisabled"
                />
            </form>

            <p class="text-sm">Vous n'avez pas de compte ? <RouterLink to="register" class="underline">Inscription</RouterLink></p>

        </section>
    </AuthLayout>
</template>

<script setup>
    import AuthLayout from '../../layouts/AuthLayout.vue';
    import { ref, watch } from 'vue';
    import { RouterLink, useRouter } from 'vue-router';
    import axios from 'axios';

    const router = useRouter()
    
    const email = ref('')
    const password = ref('')
    const errors = ref({})
    const btnDisabled = ref(true)

    watch([email, password], () => {
        if(email.value.trim() !== '' && password.value.trim() !== '' ) {
            btnDisabled.value = false
        } else {
            btnDisabled.value = true
        }
    })

    const login = async () => {

        errors.value = {}

        if(email.value.trim() === ''){
            errors.value.email = 'Veuillez renseigner votre email';
            return;
        }

        if(password.value.trim() === ''){
            errors.value.email = 'Veuillez renseigner votre mot de passe';
            return;
        }

        try {
            let res = await axios.post('login', {
                email: email.value,
                password: password.value
            })

            localStorage.setItem('token', res.data.token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`;
            router.push({ name: 'dashboard' })

        } catch (error) {
            if(error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value[key.toLowerCase()] = error.response.data.errors[key][0]
                }
            } else if (error.response.status === 500) {
                errors.value.message = error.response.data.message
            } else if (error.response.status === 401) {
                errors.value.message = error.response.data.message
            }
            console.log(error)
        }

    }   

</script>