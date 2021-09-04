<template>
    <form action="#" @submit.prevent="login()" >
        <p v-if="user !== '' ">Hello {{ user }}</p>
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
                },
                user: ''
            }
        },
        created() {
          this.getLoggedInUser()
        },
        methods: {
            login() {
                axios.get('/sanctum/csrf-cookie').then(response => {
                   axios.post('/api/login', this.formData).then(response => {
                        this.getLoggedInUser()
                   })
                })
            },
            getLoggedInUser() {
                axios.get('/api/user').then(response => {
                    this.user = response.data.name
                    this.formData.email = ''
                    this.formData.password = ''
                })
            }
        }
    }
</script>
