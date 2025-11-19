<template>
  <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <!-- Hero Section -->
      <div class="text-center mb-12">
        <h1 class="text-5xl font-bold text-white mb-4">
          Bem-vindo ao Flight3D Vision
        </h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto">
          Planeje seu voo com visualização 3D, previsão do tempo e análise de
          tráfego aeroportuário em tempo real
        </p>
      </div>

      <!-- Feature Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div
          class="bg-blue-900/30 backdrop-blur-sm border border-blue-700 rounded-xl p-6 text-center"
        >
          <div
            class="w-16 h-16 bg-blue-600/30 rounded-full flex items-center justify-center mx-auto mb-4"
          >
            <svg
              class="w-8 h-8 text-blue-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              ></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">Visualização 3D</h3>
          <p class="text-gray-400 text-sm">
            Visualize a rota do seu voo em uma representação 3D interativa
          </p>
        </div>

        <div
          class="bg-blue-900/30 backdrop-blur-sm border border-blue-700 rounded-xl p-6 text-center"
        >
          <div
            class="w-16 h-16 bg-blue-600/30 rounded-full flex items-center justify-center mx-auto mb-4"
          >
            <svg
              class="w-8 h-8 text-blue-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"
              ></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">
            Previsão do Tempo
          </h3>
          <p class="text-gray-400 text-sm">
            Condições climáticas detalhadas para seu destino
          </p>
        </div>

        <div
          class="bg-blue-900/30 backdrop-blur-sm border border-blue-700 rounded-xl p-6 text-center"
        >
          <div
            class="w-16 h-16 bg-blue-600/30 rounded-full flex items-center justify-center mx-auto mb-4"
          >
            <svg
              class="w-8 h-8 text-blue-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
              ></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">
            Análise de Tráfego
          </h3>
          <p class="text-gray-400 text-sm">
            Identifique horários de pico e planeje sua chegada ao aeroporto
          </p>
        </div>
      </div>

      <!-- Flight Form -->
      <div
        class="bg-blue-900/30 backdrop-blur-sm border border-blue-700 rounded-xl p-8 shadow-2xl"
      >
        <h2 class="text-3xl font-bold text-white mb-6 text-center">
          Planeje Seu Voo
        </h2>

        <FlightForm
          :airports="airports"
          :loading-airports="loadingAirports"
          :loading="loadingFlight"
          :error="error"
          @submit="handleSubmit"
        />
      </div>

      <!-- Loading State -->
      <div v-if="loadingAirports" class="text-center mt-8">
        <div
          class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-400"
        ></div>
        <p class="text-gray-400 mt-4">Carregando aeroportos...</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useAirportStore } from "../stores/airportStore";
import { useFlightStore } from "../stores/flightStore";
import FlightForm from "../components/FlightForm.vue";

const router = useRouter();
const airportStore = useAirportStore();
const flightStore = useFlightStore();

const airports = ref([]);
const loadingAirports = ref(false);
const loadingFlight = ref(false);
const error = ref("");

onMounted(async () => {
  loadingAirports.value = true;
  try {
    await airportStore.fetchAirports();
    airports.value = airportStore.airports;
  } catch (err) {
    error.value = "Erro ao carregar aeroportos. Tente novamente.";
  } finally {
    loadingAirports.value = false;
  }
});

const handleSubmit = async (formData) => {
  loadingFlight.value = true;
  error.value = "";

  try {
    const result = await flightStore.createFlight(formData);

    // Navigate to result page
    router.push({
      name: "FlightResult",
      params: { id: result.flight.id },
    });
  } catch (err) {
    error.value =
      flightStore.error ||
      "Erro ao gerar análise do voo. Verifique os dados e tente novamente.";
  } finally {
    loadingFlight.value = false;
  }
};
</script>
