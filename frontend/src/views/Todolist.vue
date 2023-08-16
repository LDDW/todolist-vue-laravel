<template>
    <UserLayout>

    </UserLayout>
</template>

<script setup>
    import UserLayout from '../layouts/UserLayout.vue';
    import { ref, onMounted, onUpdated } from 'vue';
    import axios from 'axios';
    import { useRoute } from 'vue-router'

    const route = useRoute()

    // fetch data with id in url
    const fetchData = () => {
        
        console.log(route.params.id);
    }

    onMounted(() => {
        fetchData();
    })

    // onUpdated(() => {
    //     fetchData();
    // })

</script>