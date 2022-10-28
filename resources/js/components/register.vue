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
            <h3>Register Now</h3>

            <label for="name">Full Name</label>
            <input type="text" placeholder="Enter namefull " id="name" v-model="user.name">
            
            <label for="email">Email</label>
            <input type="email" placeholder="Enter Email" id="email" v-model="user.email">

            <label for="password">Password</label>
            <input type="password" placeholder="Password" id="password" v-model="user.password">
            
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" v-model="user.password_confirmation">
            <br>
            <div v-if="errors" class="bg-red text-white py-2 px-4 pr-0 rounded font-bold mb-4 shadow-lg">
                <div v-for="(v, k) in errors" :key="k">
                    <li v-for="error in v" :key="error" class="text-sm">
                    {{ error }}
                    </li>
                </div>
            </div>

            <button @click="register()">
                <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                Register</button>
            <p>Already have an account? <router-link to="/login">Login</router-link></p>
        </div>
    </div>
</template>
<script>
import '../app.js';
    export default {
        data() {
            return {
                user: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                errors: null,
                loading : false,
            };
        },

        methods: {
            register() {
                this.loading = true;
                this.axios.post(this.appName+'/api/register', this.user)
                    .then(({data}) => {
                        this.$router.push('/login');
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