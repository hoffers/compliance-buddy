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
        <v-col
          cols="12"
          md="3">
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
        <v-spacer></v-spacer>
        <v-col
          cols="12"
          md="8">
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
            <h3>SCF Control Question</h3>
            <p v-if="control.questions">{{control.questions[0].question}}</p>
          </v-sheet>
          <br>
          <v-divider></v-divider>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <v-sheet v-if="control.evidence_requests">
            <span class="text-h6 mr-5">SCF Evidence Requests</span>
            <div v-for="evidence_request in control.evidence_requests">
              <div class="text-subtitle-1 mr-5">
                {{evidence_request.identifier}} - {{evidence_request.area}}
                <v-btn
                  class="text-none font-weight-regular"
                  icon="mdi-receipt-text-plus-outline"
                  size="x-small"
                  variant="tonal"
                  title="Add This Evidence"
                  @click="addThisEvidence(evidence_request)"
                ></v-btn>
              </div>
              <p><i>Artifact</i>: {{evidence_request.artifact}}</p>
              <p>{{evidence_request.description}}</p>
              <br>
            </div>
          </v-sheet>
          <v-divider></v-divider>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <v-sheet>
            <span class="text-h5 mr-5">Evidence</span>
            <v-dialog
              v-model="evidenceDialog"
              max-width="600"
            >
              <template v-slot:activator="{ props: activatorProps }">
                <v-btn
                  class="text-none font-weight-regular"
                  icon="mdi-receipt-text-plus-outline"
                  variant="tonal"
                  v-bind="activatorProps"
                  title="Add Evidence"
                ></v-btn>
              </template>

              <v-card
                prepend-icon="mdi-receipt-text-plus-outline"
                title="Add Evidence"
              >
                <v-form @submit.prevent ref="evidenceForm" v-model="validEvidenceForm">
                  <v-card-text>
                    <v-row dense>
                      <v-col
                        cols="12"
                        md="12"
                      >
                        <v-text-field
                          v-model="evidenceTitle"
                          hint="Short description of your evidence"
                          label="Title"
                          required
                          :rules="[v => !!v || 'You must enter a title!']"
                        ></v-text-field>
                      </v-col>

                      <v-col
                        cols="12"
                        md="12"
                      >
                        <v-textarea
                          v-model="evidenceDescription"
                          label="Details"
                          auto-grow
                          counter
                          rows="5"
                          required
                          :rules="[v => !!v || 'You must enter details!']"
                        ></v-textarea>
                      </v-col>
                    </v-row>

                    <small class="text-caption text-medium-emphasis">*all fields required</small>
                  </v-card-text>

                  <v-divider></v-divider>

                  <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                      text="Close"
                      variant="plain"
                      @click="closeEvidenceForm()"
                    ></v-btn>

                    <v-btn
                      color="primary"
                      text="Save"
                      variant="tonal"
                      type="submit"
                      @click="saveEvidence()"
                    ></v-btn>
                  </v-card-actions>
                </v-form>
              </v-card>
            </v-dialog>
            <v-data-table
              :items="control.evidence"
              :headers="evidenceHeaders"
              no-data-text="No evidence found" />
          </v-sheet>
          <br>
          <v-divider></v-divider>
          <br>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <v-sheet v-if="control.assessment_objectives.length">
            <span class="text-h5 mr-5">SCF Assessment Objectives</span>
            <v-data-table :items="control.assessment_objectives" :headers="assessmentObjHeaders" />
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
      evidenceHeaders: [
        {
          title: "Added",
          key: "created_at",
          width: "175",
        },
        {
          title: "Title",
          key: "title",
          minWidth: "240",
        },
        {
          title: "Details",
          key: "description",
          minWidth: "500",
        },
      ],
      assessmentObjHeaders: [
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
      evidenceDialog: false,
      evidenceDescription: '',
      evidenceTitle: '',
      validEvidenceForm: true,
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
      const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ newStatus: this.newStatus })
      };
      fetch(import.meta.env.VITE_AXIOS_BASE_URL + 'controls/' + this.controlId + '/status', requestOptions)
        .then(response => response.json())
        .then(data => {
          this.status = data;
          this.updatingStatus = false;
        });
    },
    saveEvidence() {
      if (!this.validEvidenceForm) {
        return;
      }
      const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          title: this.evidenceTitle,
          description: this.evidenceDescription,
        })
      };
      fetch(import.meta.env.VITE_AXIOS_BASE_URL + 'controls/' + this.controlId + '/evidence', requestOptions)
        .then(response => response.json())
        .then(data => {
          this.control.evidence.push(data);
          this.closeEvidenceForm();
        });
    },
    addThisEvidence(evidence_request) {
      this.evidenceDescription = evidence_request.description + '\n----------\n';
      this.evidenceTitle = evidence_request.identifier + ' - ' + evidence_request.artifact;
      this.evidenceDialog = true;
    },
    closeEvidenceForm() {
      this.evidenceDialog = false;
      this.evidenceDescription = '';
      this.evidenceTitle = '';
    }
  },
};
</script>