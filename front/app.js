import Vue from 'vue'
import axios from 'axios'
import RateBtcChart from './components/RateBtcChart.vue'

new Vue({
  el: '#app',
  components: {
    'rate-btc-chart': RateBtcChart
  }
})
