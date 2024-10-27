<template>
    <h1>Dashboard</h1>
    <v-row>
      <v-col v-for="framework in frameworks" :key="framework.id">
        <v-skeleton-loader
            class="mx-auto"
            elevation="2"
            type="heading, chip"
            :loading=loading
          >
          <v-card @click="viewFramework(framework.id)" width="100%">
            <v-card-title>{{ framework.short_name }}</v-card-title>
            <v-card-title><v-chip>{{ framework.percent_complete }}%</v-chip></v-card-title>
            <v-progress-linear :model-value="framework.percent_complete" />
          </v-card>
        </v-skeleton-loader>
      </v-col>
    </v-row>
</template>

<script>
export default {
  data() {
    return {
      frameworks: [
        {
          id: 1,
          short_name: 'test1',
          percent_complete: 34
        },
        {
          id: 2,
          short_name: 'test2',
          percent_complete: 55
        },
      ],
      loading: true,
    };
  },
  created() {
    fetch(import.meta.env.VITE_AXIOS_BASE_URL + 'dashboard')
      .then(response => response.json())
      .then((data) => {
        this.frameworks = data;
        this.loading = false;
      })
      .catch((error) => {
        this.loading = false;
      });
  },
  methods: {
    viewFramework(id) {
      this.$router.push(`/frameworks/${id}`);
    },
  },
};
</script>
