window.app = new Vue({
  el: "#app",
  router: new VueRouter({
    routes: []
  }),
  vuetify: new Vuetify({
    theme: {
      dark: false,
      themes: {
        dark: {
          primary: "#a8daff"
        },
        light: {
          primary: "#003060"
        }
      }
    }
  }),
  data: {
    // System alerts
    alerts: [],
    // Determines if loader is visible
    loader_visible: false,
    // Loader current message
    loader_message: "",
    app_loader: {},
    app_navigator: {},
    app_footer: {},
    app_notifications: {},
    pages: [],
    apishift: null,
    paths: [
      {
        name: "Home",
        path: "/",
        component: "home",
        tab: true
      },
      {
        name: "Menu",
        path: "/menu",
        component: "menu",
        tab: true
      },
      {
        name: "Cart",
        path: "/cart",
        component: "cart",
        tab: false
      },
      {
        name: "Account",
        path: "/account",
        component: "account",
        tab: false
      },
      {
        name: "Edit menu",
        path: "/edit-menu",
        component: "edit",
        tab: true
      }
    ]
  },
  created() {
    this.apishift = new APIShift()

    // Link components & pages to apishift
    APIShift.Loader.load((resolve, reject) => {
      //   app.app_footer = APIShift.API.getComponent("footer", true)
      //   app.app_loader = APIShift.API.getComponent("loader", true)
      app.app_navigator = APIShift.API.getComponent("navigator", true)
      app.app_notifications = APIShift.API.getComponent("notifications", true)
      resolve(0)
    })

    APIShift.Loader.load((resolve, reject) => {
      app.app_notifications = APIShift.API.getComponent("notifications")

      this.paths.forEach((item) => {
        app.pages.push({
          path: item.path,
          component: APIShift.API.getPage(item.component, true)
        })
      })
      resolve(0)
    })

    APIShift.Loader.load((resolve, reject) => {
      app.$router.addRoutes(app.pages)
      // Handle first load of page
      // if(app.$route.path == "/") app.$router.push("/main");

      resolve(0)
    })
  }
})
