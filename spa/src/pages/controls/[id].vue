<template>
  <v-skeleton-loader
      class="mx-auto"
      elevation="2"
      type="heading, subtitle, list-item-two-line, divider, table-thead, table-tbody"
      :loading=loading
    >
    <v-container>
      <v-row>
        <v-col>
          <v-sheet>
            <h1>{{control.identifier}} - {{control.name}}</h1>
            <p>{{control.description}}</p>
          </v-sheet>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <v-card variant="tonal">
            <v-card-title v-if="!updatingStatus"><v-chip>{{status.status}}</v-chip></v-card-title>
            <v-card-subtitle v-if="!updatingStatus">Last updated: {{status.updated_at}}</v-card-subtitle>
            <v-card-actions v-if="!updatingStatus">
              <v-btn @click="updatingStatus = true">Update Status</v-btn>
            </v-card-actions>

            <v-card-title v-if="updatingStatus">
              <v-select
                width="200px"
                v-model="newStatus"
                label="Select Status"
                :items="statuses"
              ></v-select>
            </v-card-title>
            <v-card-actions v-if="updatingStatus">
              <v-btn @click="saveStatus">Save</v-btn>
              <v-btn @click="updatingStatus = false">Cancel</v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
      <v-sheet>
        <p><b>Relative Control Weighting</b>: {{control.weight}}</p>
        <p><b>NIST CSF Function Grouping</b>: {{control.nist_csf_function_grouping}}</p>
        <p><b>PPTDF Applicability</b>: {{control.pptdf_applicability}}</p>
      </v-sheet>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
      <v-sheet>
        <h4>Methods To Comply With SCF Control</h4>
        <p>{{control.methods}}</p>
        <br>
        <h4>SCF Control Question</h4>
        <p v-if="control.questions">{{control.questions[0].question}}</p>
      </v-sheet>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
      <v-sheet :if="control.evidence_requests">
        <h4>SCF Evidence Requests</h4>
        <div v-for="evidence_request in control.evidence_requests">
          <h5>{{evidence_request.identifier}} - {{evidence_request.area}}</h5>
          <p><i>Artifact</i>: {{evidence_request.artifact}}</p>
          <p>{{evidence_request.description}}</p>
          <br>
        </div>
      </v-sheet>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
      <v-sheet :if="control.assessment_objectives">
        <h4>SCF Assessment Objectives</h4>
        <v-data-table :items="control.assessment_objectives" :headers="headers" />
      </v-sheet>
        </v-col>
      </v-row>
    </v-container>
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
          minWidth: 150,
        },
        {
          title: "Description",
          key: "description",
        },
      ],
      control: {},
      controlId: useRoute().params.id,
      loading: true,
      status: {
        status: "Not Started",
        updated_at: "N/A",
      },
      statuses: [
        {
          title: "In Progress",
          value: "in_progress",
        },
        {
          title: "Complete",
          value: "complete",
        },
      ],
      updatingStatus: false,
      newStatus: '',
    };
  },
  created() {
    fetch(import.meta.env.VITE_AXIOS_BASE_URL + 'controls/' + this.controlId)
      .then(response => response.json())
      .then((data) => {
        this.control = data;
        this.loading = false;
        if (this.control.control_statuses.length) {
          this.status = this.control.control_statuses[this.control.control_statuses.length - 1];
        }
      });
  },
  methods: {
    saveStatus() {
      console.log(this.newStatus);
      const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ newStatus: this.newStatus })
      };
      fetch(import.meta.env.VITE_AXIOS_BASE_URL + 'controls/' + this.controlId + '/status', requestOptions)
        .then(response => response.json())
        .then(data => (this.status = data));
      this.updatingStatus = false;
    },
  },
};
</script>