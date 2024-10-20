<template>
  <v-skeleton-loader
      class="mx-auto"
      elevation="2"
      type="heading, divider, table-thead, table-tbody"
      :loading=loading
    >
    <v-card class="ma-4">
      <h1>Frameworks</h1>
      <v-data-table :items="frameworks" :headers="headers" @click:row="rowClick" />
    </v-card>
  </v-skeleton-loader>
</template>

<script>
export default {
  data() {
    return {
      headers: [
        {
          title: "Geography",
          key: "geography",
        },
        {
          title: "Source",
          key: "source",
        },
        {
          title: "Name",
          key: "short_name",
          minWidth: 100,
        },
        {
          title: "Authoritative Source",
          key: "full_name",
        },
      ],
      frameworks: [],
      loading: true,
    };
  },
  created() {
    fetch(import.meta.env.VITE_AXIOS_BASE_URL + 'frameworks')
      .then(response => response.json())
      .then((data) => {
        this.frameworks = data;
        this.loading = false;
      });
  },
  methods: {
    rowClick(e, row) {
      console.log(row);
      this.$router.push(`/frameworks/${row.item.id}`);
    },
  },
};
</script>