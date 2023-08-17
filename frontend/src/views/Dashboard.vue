<template>
    <UserLayout>
        <div v-if="user">
            <h1>Bonjour {{ user.name }}</h1>
        </div>
        <div v-if="todolists">
            <h2>Voici vos listes de tâches</h2>
            <ul>
                <li v-for="todo in todolists">
                    <RouterLink :to="'/todolist/' + todo.id">{{ todo.title }}</RouterLink>
                </li>
            </ul>
        </div>
    </UserLayout>   
</template>

<script setup>
    import UserLayout from '../layouts/UserLayout.vue';
    import { ref, onMounted } from 'vue';
    import { RouterLink } from 'vue-router';
    import axios from 'axios';

    const user = ref(null);
    const todolists = ref(null);

    onMounted(async () => {
        try {
            let res = await axios.get('dashboard')
            console.log(res.data);
            user.value = res.data.user;
            todolists.value = res.data.todolists;
        } catch (error) {
            console.log(error);
        }
    })
</script>