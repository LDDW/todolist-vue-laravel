<template>
    <AuthLayout>
        <section class="h-screen max-w-md w-full flex flex-col justify-center items-center">
            <h1 class="text-2xl">Inscription</h1>
            <form @submit.prevent="login" class="w-full">
                <!-- email -->
                <label class="input_form">
                    <span>Nom</span>
                    <input 
                        type="text" 
                        v-model.trim="name"
                        placeholder="John Doe"
                        required
                    >
                    <span v-if="errors.name" class="text-red-400 mt-2">{{ errors.name }}</span>
                </label>
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
                <!-- email -->
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
                <!-- email -->
                <label class="input_form">
                    <span>Confirmez le mot de passe</span>
                    <input 
                        type="password" 
                        v-model.trim="confirmPassword"
                        placeholder="Confirmez le mot de passe"
                        required
                    >
                    <span v-if="errors.confirmPassword" class="text-red-400 mt-2">{{ errors.confirmPassword }}</span>
                </label>
                <input 
                    type="submit" 
                    value="S'inscrire"
                    :disabled="btnDisabled"
                />
            </form>

            <p class="text-sm">Vous avez un compte ? <RouterLink to="login" class="underline">Connexion</RouterLink></p>

        </section>
    </AuthLayout>
</template>

<script setup>
    import AuthLayout from '../../layouts/AuthLayout.vue';
    import { ref, watch } from 'vue';
    import { RouterLink } from 'vue-router';

    const btnDisabled = ref(true)
    const errors = ref({})

    const name = ref('')
    const email = ref('')
    const password = ref('')
    const confirmPassword = ref('')

    watch([name, email, password, confirmPassword], () => {
        if(name.value.trim() !== '' && email.value.trim() !== '' && password.value.trim() !== '' && confirmPassword.value.trim() !== '' ) {
            btnDisabled.value = false
        } else {
            btnDisabled.value = true
        }
    })

    const register = async () => {

        errors.value = {}

        if(name.value.trim() === ''){
            errors.value.name = 'Veuillez renseigner votre nom';
            return;
        }
        
        if(email.value.trim() === ''){
            errors.value.email = 'Veuillez renseigner votre email';
            return;
        }

        if(password.value.trim() === ''){
            errors.value.password = 'Veuillez renseigner votre mot de passe';
            return;
        }
        
        if(confirmPassword.value.trim() === ''){
            errors.value.confirmPassword = 'Veuillez confirmer votre mot de passe';
            return;
        }

        if(password.value.trim() !== confirmPassword.value.trim()){
            errors.value.password = 'Les mots de passe ne correspondent pas';
            return;
        }

        try {

            const res = await axios.post('register', {
                name: name.value,
                email: email.value,
                password: password.value,
                password_confirmation: confirmPassword.value
            })

        } catch (error) {
            console.log(error)
        }

    }

</script>