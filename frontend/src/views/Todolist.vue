<template>
    <UserLayout>
        <div v-if="todolist">
            <header>
                {{ title }}
                <button @click="deleteTodo">Supprimer</button>
            </header>
            <ul>
                <li v-for="todo in todolist">
                    <input type="text" v-model="todo.name" @keypress="updateTodo">
                    <input type="checkbox" v-model="todo.done" @change="updateTodo">
                    <button @click="deleteTask(todo)">Supprimer</button>
                </li>
            </ul>
            <form @submit.prevent="createTask">
                <input type="text" placeholder="contenue" v-model="name">
                <input type="submit" value="ajouter">
            </form>
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
        todolist.value.push({
            'name': name.value,
            'done': false,
        });
        console.log(todolist.value);
        updateTodo();
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
        }, 2500);
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