<template>
  <ul class="sidenav app-sidenav grey lighten-4" :class="{open: value}">

    <router-link
      v-for="link in links"
      :key="link.url"
      tag="li"
      active-class="active"
      data-target="modal1"
      class="modal-trigger"
      :to="link.url"
      :exact="link.exact"
    >
      <a href="#" class="waves-effect waves-blue pointer">{{link.title}}</a>
    </router-link>
  </ul>


</template>

<script>
import M from "materialize-css";
export default {
  props: ['value'],
  data: () => ({
    links: [
      {title: 'Главная', url: '/admin', exact: true},
      {title: 'Все обращения', url: '/admin/references'},
      {title: 'Ответы на обращения', url: '/admin/measures'},
      // {title: 'Обращения без адресата', url: '/admin/references?empty'},
      {title: 'Добавить пользователя', url: '/admin/create'},
      {title: 'Отчеты', url: '/admin/export'}
    ],

    modalData: "data-"
  })
}
</script>



