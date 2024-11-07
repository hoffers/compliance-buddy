<template>
  <v-app>

    <v-layout>
      <v-app-bar
        v-if="$route.path !== '/'"
      >
        <v-app-bar-nav-icon variant="text" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

        <v-img
          class="mx-2"
          src="@/assets/compliance-buddy-logo.png"
          max-height="30"
          max-width="25"
          contain
        ></v-img>
        <v-toolbar-title>Compliance Buddy</v-toolbar-title>
      </v-app-bar>

      <v-navigation-drawer
        v-model="drawer"
        :location="$vuetify.display.mobile ? 'bottom' : undefined"
        temporary
      >
        <v-list>
          <v-list-item
            v-for="item in menuItems"
            :prepend-icon="item.icon"
            :title="item.title"
            :to="item.path"
          ></v-list-item>
          <v-list-item
            href="https://github.com/hoffers/compliance-buddy"
            prepend-icon="mdi-code-block-tags"
            title="Open-Source Code"
            target="_blank"
          ></v-list-item>
          <v-list-item
            href="https://securecontrolsframework.com/"
            prepend-icon="mdi-account-group-outline"
            title="Secure Controls Framework"
            target="_blank"
          ></v-list-item>
        </v-list>
      </v-navigation-drawer>

      <v-main>
        <v-container>
          <router-view />
          <br><br>
        </v-container>
      </v-main>
    </v-layout>
    <AppFooter />
  </v-app>
</template>
<style>
.v-toolbar__content > .v-toolbar-title {
    margin-inline-start: 2px !important;
    font-weight: bold;
}
</style>
<script>
export default {
  data() {
    return {
      drawer: false,
      group: null,
      menuItems: [
        {
          title: 'Home',
          path: '/',
          icon: 'mdi-home-outline',
        },
        {
          title: 'Dashboard',
          path: '/dashboard',
          icon: 'mdi-rocket-launch-outline',
        },
        {
          title: 'Controls',
          path: '/controls',
          icon: 'mdi-security',
        },
        {
          title: 'Frameworks',
          path: '/frameworks',
          icon: 'mdi-list-box-outline',
        },
      ],
    }
  },

  watch: {
    group () {
      this.drawer = false;
    },
  },
}
</script>
