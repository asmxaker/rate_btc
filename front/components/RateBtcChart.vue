<template>
    <div class="container">
        {{chart}}

        <line-chart class="small" :chart-data="datacollection"></line-chart>
        <button @click="fillData()">Randomize</button>
    </div>
</template>

<script>
  import LineChart from './LineChart.js'

  export default {
    components: {
      LineChart
    },
    props: {
      chart: { type: String, default: "123" },

    },
    data() {
      return {
        datacollection: {  }
      }
    },
    mounted () {
      this.fillData()
    },
    methods: {
      fillData () {
        this.datacollection = {
          labels: ['BTC', 'USD'],
          datasets: [
            {
              label: '1',
              data: [this.getRandomInt(), this.getRandomInt(),this.getRandomInt(),this.getRandomInt(),this.getRandomInt(),this.getRandomInt()]
            }
            , {
              label: '6',
              data: [this.getRandomInt(), this.getRandomInt(),this.getRandomInt(),this.getRandomInt(),this.getRandomInt(),this.getRandomInt(),this.getRandomInt(),]
            }
          ]
        }
      },
      getRandomInt () {
        return Math.floor(Math.random() * (20 - 5 + 1)) + 5
      }
    }
  }

</script>