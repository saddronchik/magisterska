<template>
  <div>
    <Navbar @click="isOpen = !isOpen" />
    <Sidenav v-model="isOpen"  />

    <section class="main">
      <div class="container center-align">
        <h5 class="title" @click="isOpen = !isOpen">Статистическая информация</h5>
        <div class="row">
          <div class="col s6">
              <Linechart :chartdata="lineData" :options="lineOptions" :width="lineProperty.width" />
          </div>
        <div class="col s6">
          <DoughnutChart :id="doughnutProperty.id" :type="doughnutProperty.type" :chartdata="doughnutData" />
        </div>
        </div>
      </div>

    </section>
  </div>
</template>

<script>
import Linechart from "../components/charts/LineChart.vue";
import DoughnutChart from '../components/charts/DoughnutChart.vue';
import Navbar from "../components/app/AdminNavbar";
import Sidenav from "../components/app/Sidenav";
import axios from "axios";
let  countProcessed= [];
let  countNoProcessed= [];
let  countRejected= [];
let  countInProcessing= [];

$.ajax({
    method: 'GET',
    url: '/api/count',
    async:false,
    success: function (response) {
        countProcessed = response.countProcessed,
        countNoProcessed = response.countNoProcessed
        countRejected = response.countRejected
        countInProcessing = response.countInProcessing

    },

});

export default {

  components: {
    Navbar,
    Sidenav,
    Linechart,
    DoughnutChart
  },

    data: () => ({
    isOpen: true,

    lineProperty: {
      width: 900,
      delayed: "",
    },

    doughnutProperty: {
      id: "doughnut",
      type: "doughnut",
    },

    lineData: {
      labels: ['Обработанные', 'Необработанные', 'В обработке', 'Отклонены'],
      datasets: [
        {
          label: "Обращения",
          data: [countProcessed, countNoProcessed, countInProcessing, countRejected],
          backgroundColor: [
            "rgba(255, 99, 132, 0.9)",
            "rgba(54, 162, 235, 0.9)",
            "rgba(255, 206, 86, 0.2)",
            "rgba(75, 192, 192, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
          ],
          borderColor: [
            "rgba(255, 99, 132, 1)",
            "rgba(54, 162, 235, 1)",
            "rgba(255, 206, 86, 1)",
            "rgba(75, 192, 192, 1)",
            "rgba(153, 102, 255, 1)",
            "rgba(255, 159, 64, 1)",
          ],
          borderWidth: 1,
        },
      ],
    },

    doughnutData: {
        labels: ['Обработанные', 'Необработанные', 'В обработке', 'Отклонены'],
        datasets: [
          {

            backgroundColor: [
              '#9966ff',
              '#E46651',
              '#00D8FF',
              '#DD1B16'
            ],
            data: [countProcessed, countNoProcessed, countInProcessing, countRejected]
          }
        ]
    },

    lineOptions: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  }),


    mounted: function () {
        // this.counts()

    },

    // methods: {
    //   counts(){
    //       axios.get('/api/count')
    //       .then(res=>{
    //           this.count=res.data;
    //           console.log(count)
    //       })
    //   }
    // }

};

</script>

<style scoped>
@import "/assets/css/index.css";

.title {
  margin-bottom: 100px;
}
</style>
