<template>
    <header class="flex items-center justify-between h-20 container mx-auto px-5">
        <RouterLink to="/">Todolist</RouterLink>
        <nav>
            <ul class="flex items-center gap-5">
                <li>
                    <RouterLink to="/login">Connexion</RouterLink>
                </li>
                <li>
                    <RouterLink to="/register">Inscription</RouterLink>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script setup>
    import { RouterLink } from 'vue-router';
</script>