<template>
    <form action="#" @submit.prevent="login()" >
        <input class="mt-4 mx-4 border px-2" type="text" name="email" id="email" placeholder="eMail Address" v-model="formData.email">
        <input class="mt-4 mx-4 border px-2" type="password" name="password" id="password" placeholder="password" v-model="formData.password">
        <button type="submit">Submit</button>
    </form>
</template>

<script>
    export default {
        name: 'login',
        data() {
            return {
                formData: {
                    'email': '',
                    'password' : ''
                }
            }
        },
        methods: {
            login() {
                axios.get('/sanctum/csrf-cookie').then(response => {
                   axios.post('/login', this.formData).then(response => {
                       console.log(response)
                   })
                });
            }
        }
    }
</script>
