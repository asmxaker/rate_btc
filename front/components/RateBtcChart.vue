<template>
    <div class="container">
        {{datacollection}}
        <div class="form-row">
            <div class="col">
                <select class="form-control" v-model="range">
                    <option :value="el" v-for="el in dateRange">{{el}}</option>
                </select>
            </div>
            <div class="col">
                <select class="form-control" v-model="currency">
                    <option :value="el" v-for="el in currencies">{{el}}</option>
                </select>
            </div>
            <div class="col">
                <button @click="fillData()" class="btn btn-info">Fill</button>
            </div>
        </div>
        <line-chart :chart-data="datacollection"
                    class="small"></line-chart>

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
    data () {
      return {
        datacollection: {},
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
    mounted () {
      this.fillData()
      this.getOptions()
    },
    methods: {
      async fillData () {
        await axios.get('/api/rate', {
          params: {
            range: this.range,
            currency: this.currency
          }
        })
          .then(response => {
            console.log(response.data)
            this.datacollection = response.data
            // this.datacollection.labels = response.data.labels
            // this.datacollection.datasets = response.data.datasets
          })

      },
      getOptions () {
        axios.get('/api/params').then(response => {
          [this.dateRange, this.currencies] = response.data
        })
      }
    }
  }

</script>