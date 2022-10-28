<style media="screen">      
    *,
    *:before,
    *:after{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    body{
        background-color: #080710 !important;
    }
</style>
<template>
    <div>
        <div class="background">
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <div class="loginForm">
            <h3>Login Here</h3>

            <label for="email">Email</label>
            <input type="email" placeholder="Enter Email" id="email" v-model="user.email">

            <label for="password">Password</label>
            <input type="password" placeholder="Password" id="password" v-model="user.password">

            <br>
            <div v-if="errors" class="bg-red text-white py-2 px-4 pr-0 rounded font-bold mb-4 shadow-lg">
                <div v-for="(v, k) in errors" :key="k">
                    <li v-for="error in v" :key="error" class="text-sm">
                    {{ error }}
                    </li>
                </div>
            </div>

            <button @click="login">
                <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                Login</button>
            <p>New account? <router-link to="/register">Register</router-link></p>
        </div>
    </div>
</template>

<script>
    import Auth from '../Auth.js';

export default {
        data() {
            return {
                user: {
                    email: '',
                    password: '',
                },
                errors : null,
                loading : false,
            };
        },

        methods: {
            login() {
                this.loading = true;
                this.axios.post(this.appName+'/api/login', this.user)
                    .then(({data}) => {
                        Auth.login(data.access_token,data.user);
                        this.$router.push('/dashboard');
                        this.loading = false;
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors;
                        this.loading = false;
                    });
            }
        }
    }
</script>