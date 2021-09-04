<template>
    <nav>
        <router-link to='/'>Home</router-link>
        <router-link to='/show'>Show</router-link>
        <button @click="logOut()">logout</button>
    </nav>
</template>

<script>
    export default {
        name:'Navbar',
        methods: {
            logOut() {
                axios.post('/api/logout').then(response => {
                    this.$router.push('/');
                })
            }
        }
    }
</script>
