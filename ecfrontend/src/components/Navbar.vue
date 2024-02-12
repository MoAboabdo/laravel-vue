<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <!-- Navigation bar -->
  <nav>
    <!-- Links for different routes. They are conditionally rendered based on the 'isLoggedIn' state. -->
    <router-link to="/" v-if="isLoggedIn">Product List</router-link> |
    <router-link to="/add-product" v-if="isLoggedIn">Add Product</router-link> |
    <router-link to="/login" v-if="!isLoggedIn">Login</router-link> |
    <router-link to="/register" v-if="!isLoggedIn">Register</router-link> |
    <!-- Logout button that calls 'logout' action when clicked -->
    <a href="#" @click="logout" v-if="isLoggedIn">Logout</a>
  </nav>
</template>

<script>
import { mapState, mapActions } from "vuex";

export default {
  computed: {
    // Using Vuex helpers to map the 'isLoggedIn' state to a computed property
    ...mapState(["isLoggedIn"]),
  },
  methods: {
    // Using Vuex helpers to map the 'logout' action to a method
    ...mapActions(["logout"]),
  },
};
</script>
