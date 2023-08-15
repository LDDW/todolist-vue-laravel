<template>
    <AuthLayout>
        <section class="h-screen max-w-md w-full flex flex-col justify-center items-center">
            <h1 class="text-2xl">Connexion</h1>
            <form @submit.prevent="login" class="w-full">
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
    import { RouterLink } from 'vue-router';

    const btnDisabled = ref(true)
    const errors = ref({})

    const email = ref('')
    const password = ref('')

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
            const res = await axios.post('login', {
                email: email.value,
                password: password.value
            })

        } catch (error) {
            console.log(error.response.data)
        }

    }   

</script>