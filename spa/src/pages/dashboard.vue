<template>
  <h1>Dashboard</h1>
  <v-container>
    <v-row>
      <v-col v-for="framework in frameworks" :key="framework.id">
        <v-card @click="viewFramework(framework.id)">
          <v-card-title>{{ framework.short_name }}</v-card-title>
          <v-card-subtitle>{{ framework.percent_complete }}%</v-card-subtitle>
          <v-progress-linear :model-value="framework.percent_complete" />
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      frameworks: [],
    };
  },
  created() {
    fetch(import.meta.env.VITE_AXIOS_BASE_URL + 'dashboard')
      .then(response => response.json())
      .then((data) => {
        this.frameworks = data;
      });
  },
  methods: {
    viewFramework(id) {
      this.$router.push(`/frameworks/${id}`);
    },
  },
};
</script>
