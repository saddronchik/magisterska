<template>
  <div class="main">
    <nav class="navbar  light-blue accent-1">
      <div class="nav-wrapper">
        <div class="navbar-left">
          <a href="#" @click.prevent="$emit('click')">
            <i class="material-icons black-text">dehaze</i>
          </a>
          <span class="black-text">Панель администратора</span>
        </div>

        <ul class="right hide-on-small-and-down">
          <li>
            <a
              class="dropdown-trigger black-text"
              href="#"
              data-target="dropdown"
              ref="dropdown"
            >
              {{ getUsername }}
              <i class="material-icons right">arrow_drop_down</i>
            </a>

            <ul id="dropdown" class="dropdown-content">
              <li>
                <router-link to="/profile" class="black-text">
                  <i class="material-icons">account_circle</i>Профиль
                </router-link>
              </li>
              <li class="divider" tabindex="-1"></li>
              <li>
                <a href="#" class="black-text" @click.prevent="logout">
                  <i class="material-icons">assignment_return</i>Выйти
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
    data: () => ({
    dropdown: null,
    userInfo: "",
  }),

  computed: {
    getUsername() {
     return this.userInfo.Name;
    }
  },
  

  methods: {
    logout() {
      console.log('Logout')
      this.$router.push('/login?message=logout')
    }
  },


    mounted() {
    this.dropdown = M.Dropdown.init(this.$refs.dropdown, {
      constrainWidth: false
    })

    this.userInfo = JSON.parse(localStorage.getItem('userInfo'));
  },
}
</script>