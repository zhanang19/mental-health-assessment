import Vue from 'vue'
import VuePageTransition from 'vue-page-transition'
import { capitalize, exportToCSV, toBase64 } from '../utils/Util'
import moment from 'moment'

Vue.use(VuePageTransition)
Vue.mixin({
  methods: {
    isObjectEmpty (obj) {
      return Object.keys(obj).length === 0 
        && obj.constructor === Object
    },

    toMonth(value) {
      if (!value) {
        return null
      }
      
      return moment(value, 'MM').format('MMMM')
    },

    async base64Encode(file) {
      return await toBase64(file)
    },
    
    dateFormatUTC(date) {
      return dateFormatUTC(date)
    },
    
    async exportToCSV(data, title, filename) {
      if (data.length <= 0) {
        return this.$helpers.notify({
          type: 'info',
          message: 'Cannot export empty data.'
        })
      }
      
      return await exportToCSV(data, title, filename)
    },
    
    capitalize(string) {
      return capitalize(string)
    },
    
    mapDate(date) {
      const d = new Date(date)

      return `${d.getUTCFullYear()} ${d.getUTCMonth() + 1} ${d.getUTCDate()}`
    },
    /**
     * Filter records by given date (from & to)
     * It should be in the data() option and def is null
     * Expects each object data from array to contain "created_at"
     * in date format.
     * 
     * @param { Object }
     * @return { Array }
     */
    filterByDate({ data, from, to, key = 'created_at' }) {
      if (from && to) {
        const formatFrom = new Date(this.mapDate(from)).toLocaleDateString()
        const formatTo = new Date(this.mapDate(to)).toLocaleDateString()

        if (formatFrom == formatTo) {
          console.log('current')
          return data.filter(item => {
            const orderDate = new Date(item[key]).toLocaleDateString()
            return formatFrom == orderDate && formatTo == orderDate
          })
        } else {
          return data.filter(item =>
            new Date(item[key]).getTime() >= new Date(this.mapDate(from)).getTime() 
            && new Date(item[key]).getTime() <= new Date(this.mapDate(to)).getTime()
          )
        }
      }

      return data
    },

    /** @param { * } array */
    distinct(array) {
      const onlyUnique = (value, index, self) => { 
        return self.indexOf(value) === index;
      }

      return array.filter( onlyUnique );
    },

    /** sorts the array of integers */
    sortInt(a, b) {
      return a - b;
    },

    /**
     * Returns a mapped array into readable
     * form for Google Charts.
     * 
     * e.g, 
     * 
     * dataset({
     *  data: orders, // must have created_at
     *  years: distinct(years),
     *  headers: [['Year', 'Orders']]
     * })
     * 
     * const orders = $store.getters['orders/GET_ORDER_LIST'] // data
     * const orderYears = distinct($store.getters['reporting/GET_ORDER_DATES']) // years
     * 
     * @param {*} param0 
     * @return { array }
     */
    dataset({ data, years, headers }) {
      let chartData = headers
      years.sort(this.sortYear);

      const yearly = years.map(year => {
        return {
          year,
          count: 0,
        }
      })

      data.forEach(val => {
        for(let i = 0; i < yearly.length; i++) {
          const yearCreated = new Date(val.created_at).getFullYear() 
          yearly[i].year == yearCreated ? yearly[i].count++ : null
        }
      })

      for (const [key, value] of Object.entries(yearly)) {
        chartData.push([value.year, value.count]);
      }

      console.log(chartData)
      return chartData
    },

    moneyFormat(number) {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
      }).format(number)
    }
  }
})