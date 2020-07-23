<template>
  <div class="container">
    <div class="form-row">
      <div class="col">
        <select class="form-control" v-model="range">
          <option v-for="el in dateRange" :value="el">{{el}}</option>
        </select>
      </div>
      <div class="col">
        <select class="form-control" v-model="currency">
          <option v-for="el in currencies" :value="el">{{el}}</option>
        </select>
      </div>
      <div class="col">
        <button class="btn btn-info" @click="fillData">Fill</button>
      </div>
    </div>
    <line-chart class="small" :chart-data="datacollection"
                :options="options"></line-chart>

  </div>
</template>

<script>
  import LineChart from './LineChart.js'
  import axios from 'axios'

  export default {
    components: {
      LineChart
    },
    props: {},
    data() {
      return {
        datacollection: null,
        dateRange: [],
        currencies: [],
        range: '12 hours',
        currency: 'USD',
        options: {
          maintainAspectRatio: false,
          animation: {
            duration: 0
          }
        }
      }
    },
    mounted() {
      this.fillData()
      this.getOptions()
    },
    methods: {
      fillData () {
        axios.get('/api/rate', {
          params: {
            range: this.range,
            currency: this.currency
          }
        })
        .then(response => {
          this.datacollection = {
            labels: response.data.labels,
            datasets: response.data.datasets,
          }
        });
      },
      getOptions() {
        axios.get('/api/params').then(response => {
          [this.dateRange, this.currencies] = response.data
        });
      }
    }
  }

</script>