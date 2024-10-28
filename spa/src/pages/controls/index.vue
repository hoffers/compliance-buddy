<template>
  <v-skeleton-loader
      class="mx-auto"
      elevation="2"
      type="heading, divider, table-thead, table-tbody"
      :loading=loading
    >
    <v-sheet class="ma-4">
      <h1>Controls</h1>

      <v-text-field
        v-model="search"
        label="Search"
        prepend-inner-icon="mdi-magnify"
        hide-details
        single-line
      ></v-text-field>
      
      <v-data-table
        :items="controls"
        :headers="headers"
        hover
        multi-sort
        sticky
        filter-mode="some"
        :search="search"
        no-data-text="No controls found"
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
          title: "ID",
          key: "identifier",
          minWidth: 100,
        },
        {
          title: "Name",
          key: "name",
        },
        {
          title: "Weight",
          key: "weight",
        },
        {
          title: "Description",
          key: "description",
        },
      ],
      controls: [],
      loading: true,
      search: '',
    };
  },
  created() {
    fetch(import.meta.env.VITE_AXIOS_BASE_URL + 'controls')
      .then(response => response.json())
      .then((data) => {
        this.controls = data;
        this.loading = false;
      });
  },
  methods: {
    rowClick(e, row) {
      console.log(row);
      this.$router.push(`/controls/${row.item.id}`);
    },
  },
};
</script>