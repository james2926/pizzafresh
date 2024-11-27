<template>
    <div class="">
        <v-app-bar elevation="0" app light>
            <v-app-bar-nav-icon @click.stop="toggleDrawer"></v-app-bar-nav-icon>

            <v-toolbar-title  style="color:black;background-color: white !important;">Pizza Fresh</v-toolbar-title>

            <v-spacer></v-spacer>



            <v-btn @click="doLogout" icon>
                <v-icon>mdi-login-variant</v-icon>
            </v-btn>

        </v-app-bar>
    </div>
</template>

<script>
    import auth from '../../auth/auth.js'
    export default {
        methods: {
            toggleDrawer() {
                this.$emit('toggleDrawer')
            },
            doLogout() {
                auth.logout()
            },
        }
    }
</script>
<style media="screen">
  .theme--light.v-app-bar.v-toolbar.v-sheet {
    background-color: #ffffff !important;
}
</style>