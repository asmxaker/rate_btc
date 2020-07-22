import { Line, mixins } from 'vue-chartjs'
const { reactiveProp } = mixins

export default {
  extends: Line,
  mixins: [reactiveProp],
  props: ['options'],
  mounted () {
    this.renderChart(this.chartData, this.options)
  },
  watch: {
    chartData () {
      console.log('test')
      this.$data._chart.update()
    }
  }
}