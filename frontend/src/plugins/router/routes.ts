export const routes = [
  { path: '/', redirect: '/login' },
  {
    path: '/',
    component: () => import('@/layouts/default.vue'),
    children: [
      {
        path: 'dashboard',
        name: 'dashboard',
        component: () => import('@/pages/dashboard.vue'),
        meta: {requiresAuth: true}
      },
      {
        path: 'new-travel-request',
        name: 'new-travel-request',
        component: () => import('@/pages/new-travel-request.vue'),
        meta: {requiresAuth: true}
      },
      {
        path: 'account-settings',
        name: 'account-settings',
        component: () => import('@/pages/account-settings.vue'),
        meta: {requiresAuth: true}
      },
    ],
  },
  {
    path: '/',
    component: () => import('@/layouts/blank.vue'),
    children: [
      {
        path: 'login',
        name: 'login',
        component: () => import('@/pages/login.vue'),
      },
      {
        path: 'register',
        name: 'register',
        component: () => import('@/pages/register.vue'),
      },
      {
        path: '/:pathMatch(.*)*',
        component: () => import('@/pages/[...error].vue'),
      },
    ],
  },
]
