<template>
  <v-responsive
    class="align-centerfill-height mx-auto"
    max-width="900"
  >
    <v-img
      class="mb-4"
      height="150"
      src="@/assets/compliance-buddy-logo.png"
    />

    <div class="text-center">
      <div class="text-body-2 font-weight-light mb-n1">Welcome to</div>

      <h1 class="text-h2 font-weight-bold">Compliance Buddy</h1>
    </div>

    <div class="py-4" />

    <v-row>
      <v-col cols="12">
        <v-card
          class="py-4"
          color="surface-variant"
          href="/dashboard"
          prepend-icon="mdi-rocket-launch-outline"
          rounded="lg"
          variant="outlined"
        >
          <template #image>
            <v-img position="top right" />
          </template>

          <template #title>
            <h2 class="text-h5 font-weight-bold">Dashboard</h2>
          </template>

          <template #subtitle>
            <div class="text-subtitle-1">
              Manage your company's compliance goals.
            </div>
          </template>

          <v-overlay
            opacity=".12"
            scrim="primary"
            contained
            model-value
            persistent
          />
        </v-card>
      </v-col>

      <v-col cols="6">
        <v-card
          append-icon="mdi-open-in-new"
          class="py-4"
          color="surface-variant"
          href="/frameworks"
          prepend-icon="mdi-list-box-outline"
          rel="noopener noreferrer"
          rounded="lg"
          subtitle="Explore compliance frameworks."
          title="Compliance Frameworks"
          variant="text"
        >
          <v-overlay
            opacity=".06"
            scrim="primary"
            contained
            model-value
            persistent
          />
        </v-card>
      </v-col>

      <v-col cols="6">
        <v-card
          append-icon="mdi-open-in-new"
          class="py-4"
          color="surface-variant"
          href="/controls"
          prepend-icon="mdi-security"
          rel="noopener noreferrer"
          rounded="lg"
          subtitle="Discover security controls."
          title="Security Controls"
          variant="text"
        >
          <v-overlay
            opacity=".06"
            scrim="primary"
            contained
            model-value
            persistent
          />
        </v-card>
      </v-col>

      <v-col cols="6">
        <v-card
          append-icon="mdi-open-in-new"
          class="py-4"
          color="surface-variant"
          href="https://github.com/hoffers/compliance-buddy"
          prepend-icon="mdi-code-block-tags"
          rel="noopener noreferrer"
          rounded="lg"
          subtitle="Contribute to Compliance Buddy source code."
          target="_blank"
          title="Open-Source Code"
          variant="text"
        >
          <v-overlay
            opacity=".06"
            scrim="primary"
            contained
            model-value
            persistent
          />
        </v-card>
      </v-col>

      <v-col cols="6">
        <v-card
          append-icon="mdi-open-in-new"
          class="py-4"
          color="surface-variant"
          href="https://securecontrolsframework.com/"
          prepend-icon="mdi-account-group-outline"
          rel="noopener noreferrer"
          rounded="lg"
          subtitle="Learn more about our data source."
          target="_blank"
          title="Secure Controls Framework"
          variant="text"
        >
          <v-overlay
            opacity=".06"
            scrim="primary"
            contained
            model-value
            persistent
          />
        </v-card>
      </v-col>
    </v-row>
  </v-responsive>
</template>

<script setup>
  //
</script>
