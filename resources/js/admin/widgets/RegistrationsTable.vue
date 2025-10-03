<template>
  <div class="registrations-table__wrapper">
    <table class="registrations-table">
      <thead>
        <tr>
          <th>Applicant</th>
          <th>Program</th>
          <th>Status</th>
          <th>Applied</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in registrations" :key="row.applicant">
          <td>{{ row.applicant }}</td>
          <td>{{ row.program }}</td>
          <td>
            <span class="registrations-table__status" :class="statusClass(row.status)">
              {{ row.status }}
            </span>
          </td>
          <td>{{ formattedDate(row.appliedAt) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
const props = defineProps({
  registrations: {
    type: Array,
    default: () => [],
  },
});

const statusClass = (status) => `registrations-table__status--${status}`;

const formattedDate = (date) => new Intl.DateTimeFormat('en').format(new Date(date));
</script>




