<template>
  <v-skeleton-loader
      class="mx-auto"
      elevation="2"
      type="heading, divider, table-thead, table-tbody"
      :loading=loading
    >
    <v-sheet class="ma-4">
      <h1>Frameworks</h1>

      <v-text-field
        v-model="search"
        label="Search"
        prepend-inner-icon="mdi-magnify"
        hide-details
        single-line
      ></v-text-field>
      
      <v-data-table
        :items="frameworks"
        :headers="headers"
        hover
        multi-sort
        sticky
        filter-mode="some"
        :search="search"
        no-data-text="No frameworks found"
        @click:row="rowClick" />
    </v-sheet>
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
      search: '',
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