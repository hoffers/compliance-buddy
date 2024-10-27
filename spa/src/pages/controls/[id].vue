<template>
  <v-skeleton-loader
      class="mx-auto"
      elevation="2"
      type="heading, subtitle, list-item-two-line, divider, table-thead, table-tbody"
      :loading=loading
    >
    <v-sheet class="ma-4">
      <h1>{{control.identifier}} - {{control.name}}</h1>
      <p><b>PPTDF Applicability</b>: {{control.pptdf_applicability}}</p>
      <p><b>Relative Control Weighting</b>: {{control.weight}}</p>
      <p><b>NIST CSF Function Grouping</b>: {{control.nist_csf_function_grouping}}</p>
      <p>{{control.description}}</p>
    </v-sheet>

    <v-sheet class="ma-4">
      <h4>Methods To Comply With SCF Control</h4>
      <p>{{control.methods}}</p>
      <h4>SCF Control Question</h4>
      <p>{{control.questions[0].question}}</p>
    </v-sheet>

    <v-sheet class="ma-4" :if="control.evidence_requests">
      <h4>SCF Evidence Requests</h4>
      <div v-for="evidence_request in control.evidence_requests">
        <h5>{{evidence_request.identifier}} - {{evidence_request.area}}</h5>
        <p><b>Artifact</b>: {{evidence_request.artifact}}</p>
        <p>{{evidence_request.description}}</p>
      </div>
    </v-sheet>

    <v-sheet class="ma-4" :if="control.assessment_objectives">
      <h4>SCF Assessment Objectives</h4>
      <v-data-table :items="control.assessment_objectives" :headers="headers" />
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
          title: "Description",
          key: "description",
        },
      ],
      control: {},
      controlId: useRoute().params.id,
      loading: true,
    };
  },
  created() {
    fetch(import.meta.env.VITE_AXIOS_BASE_URL + 'controls/' + this.controlId)
      .then(response => response.json())
      .then((data) => {
        this.control = data;
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