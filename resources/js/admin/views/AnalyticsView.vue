<template>
  <div class="analytics-view">
    <header class="analytics-view__header">
      <div>
        <h2>Analytics</h2>
        <p>Understand performance across content and programs.</p>
      </div>
      <div class="analytics-view__actions">
        <button class="button button--ghost">Download Report</button>
        <button class="button button--primary">Schedule Export</button>
      </div>
    </header>

    <section class="analytics-view__grid">
      <Panel title="News by status">
        <BarChart :data="newsByStatus" />
      </Panel>
      <Panel title="Programs by status">
        <BarChart variant="sky" :data="programsByStatus" />
      </Panel>
      <Panel title="Registrations by status">
        <BarChart variant="amber" :data="registrationsByStatus" />
      </Panel>
    </section>

    <div class="analytics-view__two-column">
      <Panel title="Highlights" description="Quick insights from the data">
        <InsightsList :items="highlights" />
      </Panel>
      <Panel title="Next steps" description="Suggested actions to maintain momentum">
        <Checklist :items="nextSteps" />
      </Panel>
    </div>
  </div>
</template>

<script setup>
import BarChart from '../widgets/BarChart.vue';
import Checklist from '../widgets/Checklist.vue';
import InsightsList from '../widgets/InsightsList.vue';
import Panel from '../widgets/Panel.vue';

const newsByStatus = {
  published: 82,
  draft: 16,
  scheduled: 8,
  archived: 12,
};

const programsByStatus = {
  active: 12,
  upcoming: 5,
  completed: 9,
  paused: 2,
};

const registrationsByStatus = {
  pending: 45,
  approved: 120,
  rejected: 8,
  waitlisted: 6,
};

const highlights = [
  { label: 'Published articles', value: '82', description: 'Up 12% vs last quarter' },
  { label: 'Training program completion rate', value: '86%', description: 'Consistent performance' },
  { label: 'Average review turnaround', value: '36h', description: 'Down from 48h' },
];

const nextSteps = [
  'Review pending program registrations and update statuses.',
  'Publish drafted news items to keep content fresh.',
  'Highlight completed environmental projects on the website.',
  'Expand partnership outreach for market access initiatives.',
];
</script>




