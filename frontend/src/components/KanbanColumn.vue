<template>
    <div class="kanban-column">
      <h3>{{ column.title }}</h3>
      <div class="cards">
        <DealCard
          v-for="deal in column.deals"
          :key="deal.id"
          :deal="deal"
          @dragstart="onDragStart(deal)"
          draggable
        />
      </div>
    </div>
  </template>
  
  <script>
  import DealCard from './DealCard.vue'
  
  export default {
    name: 'KanbanColumn',
    components: { DealCard },
    props: {
      column: { type: Object, required: true }
    },
    emits: ['drag-start'],
    methods: {
      onDragStart(deal) {
        this.$emit('drag-start', deal)
      }
    }
  }
  </script>
  
  <style scoped>
  .kanban-column {
    min-width: 280px;
    background: #f7fafc;
    border-radius: 8px;
    padding: 16px;
    margin-right: 16px;
  }
  .cards {
    min-height: 100px;
  }
  </style>