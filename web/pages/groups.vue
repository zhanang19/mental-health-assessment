<template>
  <v-main app>
    <app-navbar 
      title="Groups"
      :elevate-on-scroll="true"
      :show-avatar="true"
    >
      <template v-slot:actions>
        <v-btn large rounded depressed color="primary">
          <v-icon left>mdi-plus</v-icon>
          ADD GROUP
        </v-btn>
      </template>
    </app-navbar>

    <v-container>
      <v-row>
        <v-col>
          <ag-grid-vue 
            ref="grid"
            style="
              height: 100vh; 
              width: 100%; 
              font-family: 'Product Sans Medium Regular', sans-serif;"
            class="ag-theme-material"
            :columnDefs="columnDefs"
            :rowData="rowData"
            :defaultColDef="defaultColDef"
          ></ag-grid-vue>
        </v-col>
      </v-row>
    </v-container>
    
  </v-main>
</template>

<script>
import { AgGridVue } from "ag-grid-vue";

export default {
  head () {
    return {
      title: `App | Groups`,
    }
  },
  
  components: {
    AgGridVue
  },

  data: () => ({
    columnDefs: null,
    rowData: null
  }),

  beforeMount() {
    this.columnDefs = [
      {headerName: 'Make', sortable: true, filter: true, field: 'make'},
      {headerName: 'Model', sortable: true, filter: true, field: 'model'},
      {headerName: 'Price', filter: 'agNumberColumnFilter', sortable: true, field: 'price'},
      {headerName: 'Date Created', type: 'agDateColumnFilter', filter: 'agDateColumnFilter', sortable: true, field: 'date'}
    ];

    this.rowData = [
      {make: 'Toyota', model: 'Celica', price: 35000, date: '24/08/2020'},
      {make: 'Ford', model: 'Mondeo', price: 32000, date: '24/06/2020'},
      {make: 'Porsche', model: 'Boxter', price: 72000, date: '24/05/2020'}
    ];

    this.defaultColDef = {
      floatingFilter: true,
      editable: true,
      resizable: true,
    }
  }
}
</script>

<style lang="scss">
  @import "../node_modules/ag-grid-community/dist/styles/ag-grid.css";
  @import "../node_modules/ag-grid-community/dist/styles/ag-theme-alpine.css";
  @import "../node_modules/ag-grid-community/dist/styles/ag-theme-material.css";
</style>