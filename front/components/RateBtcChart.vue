<template>
  <div class="container">
    <div class="form-row">
      <div class="col">
        <select class="form-control" @change="changeRange">
          <option v-for="el in dateRange" :value="el">{{el}}</option>
        </select>
      </div>
      <div class="col">
        <select class="form-control" @change="changeCurrency">
          <option v-for="el in currencies" :value="el">{{el}}</option>
        </select>
      </div>
      <div class="col">
        <button class="btn btn-info" @click="fillData">Fill</button>
      </div>
    </div>
    <line-chart class="small" :chart-data="dataCollection"
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
    props: {
    },
    data() {
      return {
        dataCollection: {},
        dateRange: [],
        currencies: [],
        range: '12h',
        currency: 'USD',
        options: {
          responsive: true,
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
      async fillData() {
        await axios.post('/api/rate', { range: this.range, currency: this.currency })
        .then(response => {
          [this.dataCollection.labels, this.dataCollection.datasets] = response.data
        });
      },
      async getOptions() {
        await axios.get('/api/params').then(response => {
          [this.dateRange, this.currencies] = response.data
        });
      },

      changeRange(value) {
        this.range = value;
      },
      changeCurrency(value) {
        this.currency = value;
      }
    }
  }

</script>