<template>
    <UserLayout>
        <div v-if="user">
            <h1 class="text-3xl font-medium">Bonjour {{ user.name }}</h1>
        </div>
        <div v-if="todolists" class="bg-gray-50 w-1/2 p-5 rounded-md">
            <h2 class="text-xl mb-5">Mes Todolists</h2>
            <ul>
                <li v-for="todo in todolists">
                    <RouterLink 
                        :to="'/todolist/' + todo.id"
                        class="bg-white p-2 rounded-md shadow-md w-full flex justify-between items-center mb-4"
                    >
                        <span>{{ todo.title }}</span>
                        <span class="text-sm text-gray-400">{{ JSON.parse(todo.todos).length }} Tâches</span>
                    </RouterLink>
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