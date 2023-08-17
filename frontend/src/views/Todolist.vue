<template>
    <UserLayout>
        <div v-if="todolist">
            <header class="flex justify-between mb-10">
                <input type="text" v-model="title" @keypress="updateTodo" class="text-3xl font-medium w-full outline-none">
                <button @click="deleteTodo" class="bg-gray-100 text-red-400 rounded-md w-9 h-9 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            </header>
            <form @submit.prevent="createTask" class="flex items-center bg-gray-100 rounded-md overflow-hidden">
                <input type="text" placeholder="Entrer une tâche" v-model="name" class="w-full bg-transparent outline-none px-3 py-2">
                <button type="submit" class="shrink-0 bg-blue px-5 py-2 text-white">Ajouter</button>
            </form>
            <ul>
                <li v-for="todo in todolist" class="flex items-center justify-between bg-gray-100 px-3 py-2 rounded-md mb-4">
                    <input type="checkbox" v-model="todo.done" @change="updateTodo" class="w-5 h-5 outline-none">
                    <input type="text" v-model="todo.name" @keypress="updateTodo" class="w-full px-3 py-2 outline-none bg-transparent">
                    <button @click="deleteTask(todo)" class="text-red-400 outline-none" v-if="todo.done === true ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </li>
            </ul>
        </div>
    </UserLayout>
</template>

<script setup>
    import UserLayout from '../layouts/UserLayout.vue';
    import { ref, onMounted, onUpdated } from 'vue';
    import axios from 'axios';
    import { useRoute, useRouter } from 'vue-router';

    const route = useRoute();
    const router = useRouter();
    
    const title = ref(null);
    const name = ref(null);
    const todolist = ref(null);
    let timeoutId;

    const fetchData = async () => {
        try {
            let res = await axios.get('todo/' + route.params.id);
            title.value = res.data.title;
            todolist.value = res.data.todos;
            console.log(res.data);
        } catch (error) {
            console.log(error);
        }
    }

    const createTask = async () => {
        if(name.value.trim() === '') {
            return;
        }
        todolist.value.push({
            'name': name.value,
            'done': false,
        });
        console.log(todolist.value);
        updateTodo();

        name.value = '';
    }

    const deleteTask = async (todo) => {
        todolist.value = todolist.value.filter(item => item !== todo)
        updateTodo();
    }

    const updateTodo = async () => {
        console.log('update');
        clearTimeout(timeoutId);
        timeoutId = setTimeout(async () => {
            try {
                let res = await axios.put('todo/' + route.params.id, {
                    'title': title.value,
                    'todos': todolist.value,
                });
                console.log(res.data);
            } catch (error) {
                console.log(error);
            }
        }, 1000);
    }

    const deleteTodo = async () => {
        try {
            const res = await axios.delete('todo/' + route.params.id)
            console.log(res)
            router.push('/dashboard')
        } catch (error) {
            console.log(error);
        }
    }

    onMounted(() => {
        fetchData();
    })

    onUpdated(() => {
        fetchData();
    })

</script>