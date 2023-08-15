<template>
    <GuestLayout>
        <section class="h-[calc(100vh-80px)] container mx-auto px-5">
            <div>
                <h1>Domptez Votre Journée avec Style. Découvrez l'App Todolist Ultime !</h1>
                <RouterLink to="/todolist">
                    <button>Commencez dès Maintenant !</button>
                </RouterLink>
            </div>
            <div>

            </div>
        </section>
    </GuestLayout>
</template>

<script setup>
    import GuestLayout from '../layouts/GuestLayout.vue';
    import { RouterLink } from 'vue-router';
</script>