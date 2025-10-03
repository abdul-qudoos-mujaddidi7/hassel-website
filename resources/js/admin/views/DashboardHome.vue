<template>
  <div class="dashboard-home">
    <section class="dashboard-home__hero">
      <div>
        <h2>Dashboard Overview</h2>
        <p>Monitor the health of your platform and manage content effortlessly.</p>
      </div>
      <div class="dashboard-home__actions">
        <button class="button button--primary">
          New Announcement
        </button>
        <button class="button button--ghost">
          Export Data
        </button>
      </div>
    </section>

    <section class="dashboard-home__grid">
      <StatCard
        v-for="item in contentStats"
        :key="item.title"
        :title="item.title"
        :value="item.value"
        :sub-value="item.subValue"
      />
    </section>

    <div class="dashboard-home__two-column">
      <Panel title="Recent Activity" description="Latest updates across the platform">
        <ActivityList :items="recentActivity" />
      </Panel>

      <Panel title="Engagement Metrics" description="Track how stakeholders interact with your platform">
        <MetricList :metrics="engagementStats" />
      </Panel>
    </div>

    <Panel
      title="Program Registrations"
      description="Monitor applications across active programs"
    >
      <RegistrationsTable :registrations="programRegistrations" />
    </Panel>
  </div>
</template>

<script setup>
import ActivityList from '../widgets/ActivityList.vue';
import MetricList from '../widgets/MetricList.vue';
import Panel from '../widgets/Panel.vue';
import RegistrationsTable from '../widgets/RegistrationsTable.vue';
import StatCard from '../widgets/StatCard.vue';

const contentStats = [
  { title: 'Total News', value: 128, subValue: '12 drafts awaiting review' },
  { title: 'Publications', value: 56, subValue: '4 releases pending' },
  { title: 'Success Stories', value: 32, subValue: 'Updated weekly' },
];

const engagementStats = [
  { title: 'Contact Requests', value: 642, trend: 'positive', change: '+12%' },
  { title: 'Active Programs', value: 18, trend: 'neutral', change: 'Stable' },
  { title: 'Beneficiaries', value: 15420, trend: 'positive', change: '+6%' },
];

const recentActivity = [
  {
    title: 'New training program published',
    description: 'Modern Irrigation Techniques – Kabul',
    timestamp: '2h ago',
    type: 'success',
  },
  {
    title: 'Program registration received',
    description: 'Sayed Rahim applied to Agri-Toolbox webinar',
    timestamp: '4h ago',
    type: 'info',
  },
  {
    title: 'Contact request resolved',
    description: 'Partnership inquiry from GreenFarm Co.',
    timestamp: 'Yesterday',
    type: 'warning',
  },
];

const programRegistrations = [
  {
    applicant: 'Sakina Ahmad',
    program: 'Agri-Tech Tool Adoption',
    status: 'approved',
    appliedAt: '2025-09-22',
  },
  {
    applicant: 'Mirwais Khan',
    program: 'Organic Farming Workshop',
    status: 'pending',
    appliedAt: '2025-09-20',
  },
  {
    applicant: 'Farahnaz Noori',
    program: 'Market Access Accelerator',
    status: 'review',
    appliedAt: '2025-09-18',
  },
];
</script>




