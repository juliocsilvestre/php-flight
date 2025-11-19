import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import FlightResult from "../views/FlightResult.vue";

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/flight/:id",
    name: "FlightResult",
    component: FlightResult,
    props: true,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
