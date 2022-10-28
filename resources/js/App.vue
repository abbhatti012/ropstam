<template>
    <div class="container">
        <div class="navbar-nav" v-if="!loggedUser">
            <router-link to="/login">Login</router-link>
            <router-link to="/register">Register</router-link>
        </div>
        <router-view> </router-view>
    </div>
</template>

<script>
    import Auth from './Auth.js';
    export default {
        data() {
            return {
                loggedUser: this.auth.user
            };
        },
        mounted() {
            console.log(this.auth.user);
        },
        methods: {
           
        }
    }
</script>