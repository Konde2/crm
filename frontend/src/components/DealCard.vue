<template>
    <div class="deal-card" :class="`priority-${deal.priority}`">
      <h4>{{ deal.title }}</h4>
      <p><strong>{{ deal.contactName }}</strong></p>
      <p>{{ deal.contactPhone }} | {{ deal.contactEmail }}</p>
      <p>Менеджер: {{ deal.assignedTo.fullName }}</p>
    </div>
  </template>
  
  <script>
  export default {
    name: 'DealCard',
    props: {
      deal: { type: Object, required: true }
    }
  }
  </script>
  
  <style scoped>
  .deal-card {
    background: white;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    cursor: grab;
  }
  .priority-high { border-left: 4px solid #e53e3e; }
  .priority-medium { border-left: 4px solid #dd6b20; }
  .priority-low { border-left: 4px solid #38a169; }
  </style>