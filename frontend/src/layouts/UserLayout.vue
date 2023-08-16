<template>
    <!-- modal new todolist -->
    <div 
        v-if="modalNewTodo"
        class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center"
    >
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-md shadow max-w-lg w-full p-5">
            <div class="flex items-center justify-between">
                <h2 class="text-xl">Créer une todolist</h2>
                <button
                @click="modalNewTodo = false"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            </div>
            <form @submit.prevent="createTodo" class="mb-0 mt-5">
                <label class="input_form">
                    <span>Nom</span>
                    <input 
                        type="text" 
                        v-model.trim="name"
                        placeholder="ex : Objectifs"
                        required
                    >
                    <span v-if="errors.name" class="text-red-400 mt-2">{{ errors.name }}</span>
                </label>
                <input 
                    type="submit" 
                    value="Créer la todolist" 
                    :disabled="btnDisabled"
                >
            </form>
           
        </div>
    </div>

    <!-- modal logout -->
    <div
        v-if="modalLogout"
        class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center"
    >
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-md shadow max-w-lg w-full p-5">
            <div class="flex items-center justify-between">
                <h2 class="text-xl">Déconnexion</h2>
                <button
                @click="modalLogout = false"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            </div>
            <p>Êtes vous sur de vouloir vous déconnecter ?</p>
            <button 
                @click="logoutUser"
                class="bg-blue text-white rounded-md px-3 py-2 mt-1 text-sm outline-none cursor-pointer disabled:bg-slate-300 transition-all"
            >
                Je me déconnecte
            </button>
        </div>
    </div>

    <!-- layout -->
    <div class="grid grid-cols-12 h-screen">
        <header class="col-span-2 bg-gray-50 flex flex-col justify-between p-5 max-h-screen">
            <nav>
                <h1 class="text-xl mb-5">TodolistApp</h1>
                <p class="text-sm text-gray-500">Navigation</p>
                <ul class="mb-10 text-sm">
                    <li>
                        <RouterLink to="/dashboard" class="flex items-center my-2 p-2" active-class="active_link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                            </svg>
                            <span class="ml-2">Tableau de bord</span>
                        </RouterLink>
                    </li>
                    <li>
                        <RouterLink to="/account" class="flex items-center my-2 p-2" active-class="active_link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span class="ml-2">Mon compte</span>
                        </RouterLink>
                    </li>
                    <li class="flex items-center my-2 p-2 text-red-400 w-full cursor-pointer" @click="modalLogout = true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                        </svg>
                        <span class="ml-2">Déconnexion</span>
                    </li>
                </ul>
                <p class="text-sm text-gray-500">Todolists</p>
                <ul v-for="todo in todos">
                    <li><RouterLink :to="'/todolist/' + todo.id">{{ todo.title }}</RouterLink></li>
                </ul>
            </nav>
            <button 
                class="flex justify-center items-center gap-2 w-full bg-blue text-white p-2 py-2.5 rounded-md text-sm"
                @click="modalNewTodo = true"
            >
                Créer une todolist
            </button>
        </header>
        <section class="col-span-10 p-5 flex flex-col items-center gap-5">
            <slot/>
        </section>
    </div>
    <Footer/>
</template>

<script setup>
    import { ref, onMounted, watch } from 'vue'
    import axios from 'axios'
    import { RouterLink , useRouter } from 'vue-router';
    import Footer from '../components/Footer.vue';

    const router = useRouter();
    const todos = ref([])
    const modalNewTodo = ref(false)
    const modalLogout = ref(false)
    const name = ref('')
    const errors = ref({})
    const btnDisabled = ref(true)

    watch(name, () => {
        if(name.value.trim() !== '') {
            btnDisabled.value = false
        } else {
            btnDisabled.value = true
        }
    })

    const fetchTodos = async () => {
        try {
            const res = await axios.get('todo')
            todos.value = res.data.todos
            console.log(res.data)
        } catch (error) {
            console.log(error)
        }
    }

    const logoutUser = async () => {
        try {
            await axios.post('logout')
            localStorage.removeItem('token')
            router.push('/login')
        } catch (error) {
            console.log(error)
        }
    }

    onMounted(() => {
        fetchTodos()
    })

    const createTodo = async () => {
        try {
            await axios.post('todo', {
                name: name.value
            })
            fetchTodos();
            modalNewTodo.value = false
        } catch (error) {
            console.log(error)
        }
    }

</script>