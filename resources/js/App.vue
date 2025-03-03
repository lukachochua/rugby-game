<template>
    <div>
        <nav>
            <router-link to="/">Dashboard</router-link> |
            <router-link to="/login">Login</router-link> |
            <router-link to="/register">Register</router-link>
        </nav>
        <router-view></router-view>
    </div>
</template>