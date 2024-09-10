const routes = [
    {
        path: "",
        name: "home",
        component: () => import('@/views/HomeView.vue')
    },
    {
      path: '/usuario',
      name: 'criar',
      component: () => import('@/views/Form/UserFormView.vue')
    },
    {
      path: '/usuario/:id',
      name: 'editar',
      component: () => import('@/views/Form/UserFormView.vue')
    }
]

export default routes