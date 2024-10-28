<template>
  <v-skeleton-loader
      class="mx-auto"
      elevation="2"
      type="heading, subtitle, list-item-two-line, divider, table-thead, table-tbody"
      :loading=loading
    >
    <v-card class="ma-4">
      <h1>{{framework.short_name}}</h1>
      <h2>{{framework.full_name}}</h2>
      <h3>{{framework.source}} - {{framework.geography}}</h3>
      <a :href="framework.url">Source</a>
    </v-card>
    <v-card class="ma-4">

      <v-text-field
        v-model="search"
        label="Search"
        prepend-inner-icon="mdi-magnify"
        hide-details
        single-line
      ></v-text-field>
      
      <v-data-table
        :items="framework.controls"
        :headers="headers"
        hover
        multi-sort
        sticky
        filter-mode="some"
        :search="search"
        no-data-text="No controls found"
        @click:row="rowClick" />
    </v-card>
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
        {
          title: "Status",
          key: "status",
        },
      ],
      framework: {},
      frameworkId: useRoute().params.id,
      loading: true,
      search: '',
    };
  },
  created() {
    fetch(import.meta.env.VITE_AXIOS_BASE_URL + 'frameworks/' + this.frameworkId)
      .then(response => response.json())
      .then((data) => {
        this.framework = data;
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